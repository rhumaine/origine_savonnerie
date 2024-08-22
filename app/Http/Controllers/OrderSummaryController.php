<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

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
           
            $items = [];
            $total = 0;

            foreach ($panier as $panierItem) {
                $total += $panierItem['produit']->prix * $panierItem['quantite'];
                $item = new Item();
                $item->setName($panierItem['produit']->nom)
                    ->setCurrency('EUR')
                    ->setQuantity($panierItem['quantite'])
                    ->setPrice($panierItem['produit']->prix);
                
                $items[] = $item;
            }

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
            $redirectUrls->setReturnUrl(route('paypal.execute'))
                    ->setCancelUrl(route('recap.show'));

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

            try {
                $payment->create($this->apiContext);
    
                return redirect($payment->getApprovalLink());
            } catch (\Exception $e) {
                return back()->withErrors('Erreur! ' . $e->getMessage());
            }

        }else{
            return Redirect::route('home');
        }
        // Logique pour traiter le paiement

        // créer une commande avec en statut "En attente de paiement"


        // Validation, communication avec le système de paiement, etc.
        return redirect()->route('payment.success');
    }


    // Méthode pour gérer le paiement
    public function executePayPalPayment(Request $request)
    {
        $paymentId = $request->paymentId;
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        try {
            $result = $payment->execute($execution, $this->apiContext);

            // Payment success logic

            if($result->state == "approved"){

                // update commande en apprrouvé
                
                Session::forget('panier');
                return view('paiement.success', compact('result'));
            }else{
                return redirect()->route('recap.show')->with('error', 'Paiement échoué, veuillez nous contacter si le problème persiste !');
            }

        } catch (\Exception $e) {
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

}
