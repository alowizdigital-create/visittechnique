
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
        <h1 style="color: #4CAF50;">kussala</h1>
        <div class="email-header">
            <h4> Verify your email address to complete registration </h4>
        </div>
        <div class="email-body">
            <p>Hi!</p>
            <p>Thanks for your interest in joining kussala ! To complete your registration, we need you to verify your email address.</p>
            <p>
                <a href="http://cms.com/users/validsignup/<?= h($token) ?>" class="button" style='text-decoration:none;'>
                    Verify Email
                </a>
            </p>
        </div>
        <div class="footer" style="margin-top: 40px;">
            <p>&copy; {{2025}} [kussala] - Tous droits réservés</p>
        </div>
    </div>
</body>
</html>

