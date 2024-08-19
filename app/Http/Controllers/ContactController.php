<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        // Valider les données du formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        // envoyer un email

        Mail::to('romain.demay56@gmail.com')->send(new \App\Mail\ContactMail($validated));

        // Rediriger avec un message de succès
        return back()->with('success', 'Votre message a été envoyé avec succès !');
    }
}
