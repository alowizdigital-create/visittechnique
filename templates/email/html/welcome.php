<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation de votre compte</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            text-align: center;
            font-size: 24px;
            color: #4CAF50;
        }
        .email-body {
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            Bonjour <?php $email ?>,
        </div>
        <div class="email-body">
            <p>Merci de vous être inscrit sur notre site. Pour activer votre compte, veuillez cliquer sur le lien suivant :</p>
            <p> 
                <a href="sosmall.local/users/validate/<?php $token ?>" class="button">Activer mon compte</a>
            </p>
            <p>Si vous n'avez pas demandé cette inscription, ignorez ce message. Votre compte restera inactif.</p>
        </div>
        <div class="footer">
            <p>&copy; {{annee}} [Nom de votre entreprise] - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>
