<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Message de Contact</title>
</head>
<body>
    <h1>Nouveau message de contact</h1>

    <p><strong>Nom :</strong> {{ $data['nom'] }}</p>
    <p><strong>Prénom :</strong> {{ $data['prenom'] }}</p>
    <p><strong>Adresse :</strong> {{ $data['adresse'] }}</p>
    <p><strong>Téléphone :</strong> {{ $data['telephone'] }}</p>
    <p><strong>Message :</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>
