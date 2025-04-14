<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statut de votre commande</title>
</head>
<body>
    <h2>Bonjour {{ $prenom }} {{ $nom }},</h2>

    <p>Nous vous informons que votre commande #{{ $commande->id }} a été <strong>{{ $status }}</strong>.</p>

    <p>Montant total : {{ number_format($commande->prixTotal, 2, ',', ' ') }} Frs CFA</p>

    <p>Merci pour votre confiance !</p>
</body>
</html>
