<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur le serveur de Geoffroy</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 700px;
            margin: 20px;
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #764ba2;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .subtitle {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 5px solid #764ba2;
            padding: 20px;
            border-radius: 5px;
            margin: 25px 0;
        }
        .info-box p {
            margin: 8px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 0.9em;
            color: #888;
            text-align: center;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        a {
            color: #764ba2;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .badge {
            background: #764ba2;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Bonjour Geoffroy Streit !</h1>
        <p class="subtitle">Bienvenue sur ton serveur Apache sous WSL (Ubuntu)</p>
        
        <div class="info-box">
            <span class="badge">Formation M2I</span>
            <span class="badge">Apprenti développeur</span>
            <p><strong>📅 Date et heure du serveur :</strong> <?php echo date('d/m/Y H:i:s'); ?></p>
            <p><strong>🌍 Ton adresse IP :</strong> <?php echo $_SERVER['REMOTE_ADDR']; ?></p>
            <p><strong>🐘 Version PHP :</strong> <?php echo phpversion(); ?></p>
            <p><strong>💻 Système d'exploitation :</strong> <?php echo PHP_OS; ?></p>
            <p><strong>📁 Dossier racine :</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
        </div>

        <p>Félicitations, ton environnement de développement est prêt !</p>
        <p>🔧 Tu peux maintenant :</p>
        <ul>
            <li>Placer tes projets PHP dans <code>/var/www/html/</code></li>
            <li>Accéder à <strong>phpMyAdmin</strong> via <a href="/phpmyadmin">ce lien</a></li>
            <li>Modifier ce fichier pour créer ta propre page d'accueil</li>
        </ul>

        <div class="footer">
            &copy; <?php echo date('Y'); ?> - Geoffroy Streit - Tous droits réservés<br>
            <small>En formation chez M2I - Apprentissage du développement</small>
        </div>
    </div>
</body>
</html>
