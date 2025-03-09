<?php
// index.php
require_once 'config/database.php';  // Inclure ici la connexion PDO (variable $pdo)

// Initialisation des compteurs
$employe_count = 0;
$client_count = 0;
$document_count = 0;

// Récupération du nombre d'employés
try {
    $stmt = $pdo->query("SELECT COUNT(*) AS count FROM employes");
    $employe_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    // En cas d'erreur, on peut laisser la valeur à 0
}

// Récupération du nombre de clients
try {
    $stmt = $pdo->query("SELECT COUNT(*) AS count FROM clients");
    $client_count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
} catch (PDOException $e) {
    // idem
}

// Récupération du nombre de documents depuis le serveur FTP
$ftp_server = "192.168.1.18";  
$ftp_username = "ftpuser";  
$ftp_password = "passer";  
// Connexion au serveur FTP
$ftp_conn = ftp_connect($ftp_server) or die("Impossible de se connecter à $ftp_server");
// Connexion avec les identifiants
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

// Vérifier la connexion
if (!$login) {
    echo "Impossible de se connecter au serveur FTP.";
    exit();
}

// Spécifier le répertoire contenant les documents
$ftp_directory = "/home/ftpuser/ftp"; 
// Changer de répertoire
ftp_chdir($ftp_conn, $ftp_directory);

// Récupérer la liste des fichiers dans le répertoire
$documents = ftp_nlist($ftp_conn, ".");

// Compter le nombre de fichiers
$document_count = count($documents);

// Fermer la connexion FTP
ftp_close($ftp_conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Système de Gestion</title>
    <style>
  :root {
    --primary-color: #2A9D8F;
    --secondary-color: #264653;
    --accent-color: #E76F51;
    --light-bg: #F8F9FA;
    --dark-text: #2A2A2A;
    --gradient-start: #2A9D8F;
    --gradient-end: #264653;
  }

  body {
    background-color: var(--light-bg);
    font-family: 'Inter', system-ui, sans-serif;
    color: var(--dark-text);
    margin: 0;
  }

  header {
    background: var(--secondary-color);
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    padding: 1rem 0;
  }

  .container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
  }

  nav {
    display: flex;
    gap: 1.5rem;
    align-items: center;
  }

  .nav-link {
    color: white !important;
    text-decoration: none;
    position: relative;
    transition: all 0.3s ease;
  }

  .nav-link::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--accent-color);
    transition: width 0.3s;
  }

  .nav-link:hover::after {
    width: 100%;
  }

  .dashboard {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin: 2rem 0;
  }

  .card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
  }

  .card:hover {
    transform: translateY(-5px);
  }

  .card h3 {
    color: var(--secondary-color);
    margin-bottom: 1rem;
  }

  .count {
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--primary-color);
    margin: 1rem 0;
  }

  .card a {
    display: inline-block;
    padding: 0.8rem 1.5rem;
    background: var(--primary-color);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .card a:hover {
    background: var(--accent-color);
    transform: translateY(-2px);
  }

  .actions .action-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
  }

  .action-box {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }

  .action-box a {
    background: var(--primary-color);
    color: white !important;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    text-decoration: none;
  }

  footer {
    text-align: center;
    padding: 2rem 0;
    color: var(--secondary-color);
    margin-top: 3rem;
  }

  @media (max-width: 768px) {
    .container {
      padding: 0 1rem;
    }
    
    nav {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
</head>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<body>

<header>
    <h1>Système de Gestion</h1>
    <!-- Barre de navigation -->
    <nav>
        <div class="nav-item">
            <a href="https://mail.smarttech.sn/iredadmin" target="_blank" class="nav-link">iRedAdmin</a>
            <span class="tooltip">Accédez à l'administration d'iRedMail</span>
        </div>
        <div class="nav-item">
            <a href="https://mail.smarttech.sn/mail" target="_blank" class="nav-link">Boite Mail</a>
            <span class="tooltip">Accédez à la boîte mail via Roundcube</span>
        </div>
    </nav>
</header>

<div class="container">
    <!-- Section d'accueil -->
    <div class="welcome">
        <h2>Bienvenue dans votre Système de Gestion</h2>
        <p>Gérez facilement vos employés, clients et documents.</p>
    </div>

    <!-- Tableau de bord (cards) -->
    <div class="dashboard">
        <div class="card">
            <h3>Employés</h3>
            <div class="count"><?php echo $employe_count; ?></div>
            <a href="employe/index.php">Gérer</a>
        </div>
        <div class="card">
            <h3>Clients</h3>
            <div class="count"><?php echo $client_count; ?></div>
            <a href="clients/index.php">Gérer</a>
        </div>
        <div class="card">
            <h3>Documents</h3>
            <div class="count"><?php echo $document_count; ?></div>
            <a href="documents/index.php">Gérer</a>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="actions">
        <h3>Actions rapides</h3>
        <div class="action-list">
            <div class="action-box">
                <h4>Nouvel employé</h4>
                <p>Ajouter un nouvel employé dans la base de données.</p>
                <a href="employe/create.php">Créer</a>
            </div>
            <div class="action-box">
                <h4>Nouveau client</h4>
                <p>Ajouter un nouveau client dans la base de données.</p>
                <a href="clients/create.php">Créer</a>
            </div>
            <div class="action-box">
                <h4>Nouveau document</h4>
                <p>Ajouter un document lié à un employé ou un client.</p>
                <a href="documents/create.php">Créer</a>
            </div>
        </div>
    </div>

    <!-- Pied de page -->
    <footer>
        &copy; <?php echo date('Y'); ?> - Mon Système de Gestion
    </footer>
</div>

</body>
</html>
