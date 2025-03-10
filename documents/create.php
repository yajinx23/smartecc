<?php
// documents/create.php
require_once '../config/database.php';  // Ajustez si nécessaire

$message = "";
$uploadDir = '../uploads/'; // Ce dossier ne sera plus utilisé pour stocker les fichiers

// Paramètres FTP
$ftp_server = "192.168.1.18";
$ftp_user = "ftpuser";
$ftp_password = "passer";
$ftp_upload_dir = "/home/ftpuser/ftp/"; // Répertoire distant où stocker les fichiers

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de l'upload du fichier
    if (isset($_FILES['chemin_fichier']) && $_FILES['chemin_fichier']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['chemin_fichier']['tmp_name'];
        $originalFileName = $_FILES['chemin_fichier']['name'];
        
        // Connexion au serveur FTP
        $ftp_conn = ftp_connect($ftp_server);
        
        if ($ftp_conn && ftp_login($ftp_conn, $ftp_user, $ftp_password)) {
            ftp_pasv($ftp_conn, true); // Activation du mode passif si nécessaire
            $remoteFile = $ftp_upload_dir . $originalFileName;
            
            // Envoi du fichier via FTP
            if (ftp_put($ftp_conn, $remoteFile, $tmpName, FTP_BINARY)) {
                $message = "Document transféré avec succès sur le serveur FTP.";
            } else {
                $message = "Erreur : Impossible de transférer le fichier vers le serveur FTP.";
            }
            
            // Fermeture de la connexion FTP
            ftp_close($ftp_conn);
        } else {
            $message = "Erreur : Connexion au serveur FTP échouée.";
        }
    } else {
        $message = "Aucun fichier sélectionné ou erreur lors de l'upload.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2A9D8F;
            --secondary-color: #264653;
            --accent-color: #E76F51;
            --light-bg: #F8F9FA;
            --dark-text: #2A2A2A;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background-color: var(--light-bg);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: var(--secondary-color);
            padding: 1rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 2rem;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
        }

        .navbar a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s;
        }

        .navbar a:hover::after {
            width: 100%;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        h1 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: 500;
            color: var(--secondary-color);
        }

        input[type="file"] {
            padding: 0.8rem;
            border: 2px dashed var(--primary-color);
            border-radius: 8px;
            background: rgba(42,157,143,0.05);
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            background: rgba(42,157,143,0.1);
        }

        button {
            padding: 1rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            background: rgba(231,111,81,0.1);
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }
            
            .navbar ul {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar">
        <ul>
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="../employe/index.php">Employés</a></li>
            <li><a href="../clients/index.php">Clients</a></li>
            <li><a href="../documents/index.php">Documents</a></li>
        </ul>
    </nav>

    <!-- Contenu principal -->
    <div class="container">
        <h1>Ajouter un Document</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <label>Fichier à uploader :</label>
            <input type="file" name="chemin_fichier" required>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>