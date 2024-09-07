<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use App\Models\Commande;
use App\Models\Produit;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class OrderSummaryController extends Controller
{
    protected $paypal;

    public function __construct()
    {
        // Instancier le client PayPal
        $this->paypal = new PayPalClient();
        $this->paypal->setApiCredentials(config('paypal')); // Charger les credentials PayPal depuis la config
    }

    /**
     * Affiche le récapitulatif de la commande.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request)
    {
        $panier = json_decode($request->cookie('panier', '[]'), true);
        $total = 0;
        $panierMisAJour = [];
        if (count($panier) > 0) {
            foreach ($panier as $item) {
                $produit = Produit::find($item['id']);

                if ($produit) {
                    // Ajouter les informations supplémentaires
                    $itemAvecInfos = [
                        'id' => $item['id'],
                        'nom' => $produit->nom,
                        'image' => $produit->url_image,
                        'prix' => $produit->prix,
                        'quantite' => $item['quantite'],
                        'sous_total' => $produit->prix * $item['quantite']
                    ];

                    $total += $itemAvecInfos['sous_total'];
                    $panierMisAJour[] = $itemAvecInfos;
                }
            }

            return response()->view('recap.show', [
                'panierMisAJour' => $panierMisAJour,
                'total' => $total
            ]);
        } else {
            return Redirect::route('panier.show');
        }
    }

    /**
     * Crée un paiement PayPal.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPayPalPayment(Request $request)
    {
        $panier = json_decode($request->cookie('panier', '[]'), true);

        if (count($panier) === 0) {
            return Redirect::route('home');
        }

        $invoiceId = uniqid();
        $total = 0;
        $items = [];

        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
            $items[] = [
                'name' => $item['nom'],
                'price' => $item['prix'],
                'qty' => $item['quantite'],
                'currency' => 'EUR'
            ];
        }

        // Créer la commande dans la base de données
        $commande = new Commande();
        $commande->date_commande = now();
        $commande->mode_paiement = 'paypal';
        $commande->user_id = auth()->id();
        $commande->total = $total;
        $commande->historique_statuts = [
            [
                'statut' => 'En attente de paiement',
                'date' => now()
            ]
        ];
        $commande->save();

        foreach ($panier as $panierItem) {
            $commande->produit()->attach($panierItem['id'], [
                'quantite' => $panierItem['quantite'],
                'prix_unitaire' => $panierItem['prix'],
            ]);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success', ['commande_id' => $commande->id]),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
           "purchase_units" => [
                [
                    "reference_id" => "default",
                    "amount" => [
                        "currency_code" => "EUR",
                        "value" => $total,
                    ],
                    "shipping" => [
                        "name" => [
                            "full_name" => $request->user()->name." ".$request->user()->prenom, // Nom du destinataire
                        ],
                        "address" => [
                            "address_line_1" => $request->user()->address, // Adresse ligne 1
                            "address_line_2" => "", // Adresse ligne 2 (facultatif)
                            "admin_area_2" => $request->user()->ville, // Ville
                            "admin_area_1" => "", // État/Région
                            "postal_code" => $request->user()->code_postal, // Code postal
                            "country_code" => "FR", // Code du pays
                        ],
                    ],
                ],
            ],
        ]);

        $datePrefix = now()->format('Ymd');
        $numCommande = $datePrefix . $commande->id;
        $commande->num_commande = $numCommande;
        $commande->save();

        
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()->route('cancel.payment')->with('error', 'Something went wrong.');
        } else {
            return redirect()->route('create.payment')->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * Exécute le paiement PayPal après redirection.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        $commandeId = $request->get('commande_id');

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $commande = Commande::find($commandeId);

            if ($commande) {
                $historique = $commande->historique_statuts ?? [];
                $historique[] = [
                    'statut' => 'Approuvé',
                    'date' => now()
                ];
                $commande->historique_statuts = $historique;
                $commande->save();

                Session::forget('panier');
                Cookie::queue(Cookie::forget('panier'));

                return view('paiement.success', ['result' => $response, 'commande_id' => $commandeId]);
            } else {
                return redirect()->route('recap.show')->with('error', 'Commande non trouvée.');
            }
        } else {
            return redirect()->route('recap.show')->with('error', 'Paiement échoué, veuillez nous contacter si le problème persiste !');
        }
    }

    /**
     * Gère l'annulation du paiement PayPal.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentCancel()
    {
        return redirect()->route('recap.show')->with('error', 'Paiement annulé.');
    }


    /**
     * Affiche les détails d'une commande.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function commandeShow(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $user = $commande->user->id;

        if ($user === $request->user()->id || $request->user()->role === "admin") {
            return view('commandes.show', [
                'user' => $user,
                'commande' => $commande,
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function createPaiementMainPropre(Request $request)
    {
       
        $panier = json_decode($request->cookie('panier', '[]'), true);

        if (count($panier) === 0) {
            return Redirect::route('home');
        }

        $total = 0;
        foreach ($panier as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        // Créer la commande dans la base de données
        $commande = new Commande();
        $commande->date_commande = now();
        $commande->mode_paiement = 'main propre';
        $commande->user_id = auth()->id();
        $commande->total = $total;
        $commande->historique_statuts = [
            [
                'statut' => 'En attente de retrait en main propre',
                'date' => now()
            ]
        ];
        $commande->save();

        foreach ($panier as $panierItem) {
            $commande->produit()->attach($panierItem['id'], [
                'quantite' => $panierItem['quantite'],
                'prix_unitaire' => $panierItem['prix'],
            ]);
        }

        $datePrefix = now()->format('Ymd');
        $numCommande = $datePrefix . $commande->id;
        $commande->num_commande = $numCommande;
        $commande->save();

        Session::forget('panier');
        Cookie::queue(Cookie::forget('panier'));

        return view('paiement.successMainPropre', ['total' => $total, 'commande_id' => $commande->id]);
    }
}
