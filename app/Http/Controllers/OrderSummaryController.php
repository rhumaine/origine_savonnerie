<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\Commande;
use App\Models\CommandeProduit;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Rest\ApiContext;

class OrderSummaryController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.secret')
            )
        );

        $this->apiContext->setConfig(config('services.paypal.settings'));
    }

    public function show(Request $request)
    {
        
        $panier = Session::get('panier', []);
        $total = 0;
        if(count($panier) > 0){
            // Calculer le total de la commande
            foreach ($panier as $item) {
                $total += $item['produit']->prix * $item['quantite'];
            }
            
            return view('recap.show',  ['panier' => $panier, 'total' => $total]);
        }else{
            return Redirect::route('panier.show');
        }
    }

    // Méthode pour gérer le paiement
    public function createPayPalPayment(Request $request)
    {

        $panier = Session::get('panier', []);
       
        if(count($panier) > 0){
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $commande = new Commande();
            $commande->date_commande = now();
            $commande->mode_paiement = 'paypal';
            $commande->user_id = auth()->id();

            $commande->historique_statuts = [
                [
                    'statut' => 'En attente de paiement',
                    'date' => now()
                ]
            ];


            $items = [];
            $total = 0;
            $commande->total = $total;
            
            $commande->save();

            foreach ($panier as $panierItem) {
                $total += $panierItem['produit']->prix * $panierItem['quantite'];
                $item = new Item();
                $item->setName($panierItem['produit']->nom)
                    ->setCurrency('EUR')
                    ->setQuantity($panierItem['quantite'])
                    ->setPrice($panierItem['produit']->prix);
                $items[] = $item;

                // Ajouter les produits dans la table pivot commande_produit
                $commande->produit()->attach($panierItem['produit']->id, [
                    'quantite' => $panierItem['quantite'],
                    'prix_unitaire' => $panierItem['produit']->prix,
                ]);
            }

            $commande->total = $total;
            $commande->save();

            $itemList = new ItemList();
            $itemList->setItems($items);

            $amount = new Amount();
            $amount->setCurrency('EUR')
            ->setTotal($total);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription('paiement de la commande Origine Savonnerie');

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('paypal.execute',['commande_id' => $commande->id]))
                    ->setCancelUrl(route('recap.show'));

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

            try {
                $payment->create($this->apiContext);
    

                $datePrefix = now()->format('Ymd');
                $numCommande = $datePrefix . $commande->id;
                $commande->num_commande = $numCommande;
                $commande->save();

                return redirect($payment->getApprovalLink());
            } catch (\Exception $e) {
                return back()->withErrors('Erreur! ' . $e->getMessage());
            }
        }else{
            return Redirect::route('home');
        }
    }


    // Méthode pour gérer le paiement
    public function executePayPalPayment(Request $request)
    {
        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);
        $commandeId = $request->get('commande_id');

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            if($result->state == "approved"){

                // update commande en apprrouvé
                $commande = Commande::find($commandeId);
                if ($commande) {
                    
                    $historique = $commande->historique_statuts ?? [];
                    $historique[] = [
                        'statut' => 'Approuvé',
                        'date' => now()
                    ]; 
                    $commande->historique_statuts = $historique;
                    $commande->save();
                }

                Session::forget('panier');
                return view('paiement.success', compact('result'));
            }else{
                return redirect()->route('recap.show')->with('error', 'Paiement échoué, veuillez nous contacter si le problème persiste !');
            }

        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    public function commandeShow(Request $request, $id){
        $commande = Commande::findOrFail($id);
        $user = $commande->user->id;

        if($user === $request->user()->id || $request->user()->role === "admin"){
            return view('commandes.show', [
                'user' => $user,
                'commande' => $commande,
            ]);
        }else{
            return redirect()->route('home');
        }
    }
}
