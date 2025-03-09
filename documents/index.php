<?php
// documents/index.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Paramètres FTP
$ftp_server = "192.168.1.18";
$ftp_user = "ftpuser";
$ftp_password = "passer";
$ftp_upload_dir = "/home/ftpuser/ftp/"; // Répertoire distant où stocker les fichiers
$local_download_dir = "/var/www/html/smartecc/downloads/"; // Répertoire local où les fichiers seront téléchargés

$message = "";

// Connexion au serveur FTP
$ftp_conn = ftp_connect($ftp_server);
if (!$ftp_conn) {
    die("Échec de la connexion au serveur FTP.");
}
if (!ftp_login($ftp_conn, $ftp_user, $ftp_password)) {
    die("Échec de l'authentification FTP.");
}

if ($ftp_conn && ftp_login($ftp_conn, $ftp_user, $ftp_password)) {

    ftp_pasv($ftp_conn, true); // Mode passif si nécessaire
    // Récupération de la liste des fichiers du répertoire
    $files = ftp_nlist($ftp_conn, $ftp_upload_dir);
    
    if ($files === false) {
        $message = "Impossible de récupérer la liste des fichiers.";
        $files = [];
    }
} else {
    die("Erreur : Connexion au serveur FTP échouée.");
}

// Suppression d'un fichier si demandé
if (isset($_GET['delete'])) {
    $fileToDelete = $ftp_upload_dir . basename($_GET['delete']);
    if (ftp_delete($ftp_conn, $fileToDelete)) {
        $message = "Fichier supprimé avec succès.";
    } else {
        $message = "Erreur lors de la suppression du fichier.";
    }
    header("Location: index.php");
    exit;
}

// Téléchargement d'un fichier si demandé
if (isset($_GET['download'])) {
    $fileToDownload = $ftp_upload_dir . basename($_GET['download']);
    $local_file = $local_download_dir . basename($_GET['download']); // Destination du fichier dans le répertoire local

    // Télécharger le fichier depuis le serveur FTP vers le répertoire local
    if (ftp_get($ftp_conn, $local_file, $fileToDownload, FTP_BINARY)) {
        $message = "Le fichier a été téléchargé avec succès dans le répertoire 'downloads'.";
    } else {
        $message = "Erreur lors du téléchargement du fichier.";
    }
    header("Location: index.php");
    exit;
}

// Fermeture de la connexion FTP
ftp_close($ftp_conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Documents</title>
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
            max-width: 1200px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        th {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            font-weight: 500;
        }

        tr:hover {
            background-color: rgba(42,157,143,0.05);
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            background: var(--primary-color);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-create:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .message {
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 8px;
            background: rgba(231,111,81,0.1);
            color: var(--accent-color);
            border: 1px solid var(--accent-color);
        }

        .actions a {
            color: var(--primary-color);
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .actions a:hover {
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1rem;
            }
            
            table {
                display: block;
                overflow-x: auto;
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
        <h1>Liste des Documents</h1>
        <a href="create.php" class="btn-create">+ Uploader un document</a>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Nom du fichier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($files)) : ?>
                    <?php foreach ($files as $file) : ?>
                        <tr>
                            <td><?= htmlspecialchars(basename($file)) ?></td>
                            <td class="actions">
                                <a href="ftp://<?= $ftp_user ?>:<?= $ftp_password ?>@<?= $ftp_server . $file ?>" target="_blank">Visualiser</a>
                                <a href="?download=<?= urlencode(basename($file)) ?>" onclick="return confirm('Êtes-vous sûr de vouloir télécharger ce document ?');">Télécharger</a>
                                <a href="?delete=<?= urlencode(basename($file)) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">Aucun document trouvé sur le serveur FTP.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>