<?php
// clients/create.php
require_once '../config/database.php'; // Ajustez le chemin si nécessaire

// Initialisation d'un message (optionnel)
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $nom       = !empty($_POST['nom']) ? trim($_POST['nom']) : null;
    $prenom    = !empty($_POST['prenom']) ? trim($_POST['prenom']) : null;
    $email     = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $telephone = !empty($_POST['telephone']) ? trim($_POST['telephone']) : null;
    $adresse   = !empty($_POST['adresse']) ? trim($_POST['adresse']) : null;

    try {
        // Préparation de la requête d'insertion
        $sql = "INSERT INTO clients (nom, prenom, email, telephone, adresse)
                VALUES (:nom, :prenom, :email, :telephone, :adresse)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nom'       => $nom,
            ':prenom'    => $prenom,
            ':email'     => $email,
            ':telephone' => $telephone,
            ':adresse'   => $adresse
        ]);

        // Succès : on peut soit afficher un message, soit rediriger
        $message = "Client ajouté avec succès !";
        // header("Location: index.php"); 
        // exit;

    } catch (PDOException $e) {
        $message = "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Client</title>
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
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(42,157,143,0.25);
        }

        button {
            grid-column: span 2;
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
            form {
                grid-template-columns: 1fr;
            }
            
            button {
                grid-column: span 1;
            }
            
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
        <h1>Ajouter un Client</h1>
        
        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div>
                <label>Nom :</label>
                <input type="text" name="nom" required>
            </div>
            <div>
                <label>Prénom :</label>
                <input type="text" name="prenom" required>
            </div>
            <div>
                <label>Email :</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Téléphone :</label>
                <input type="text" name="telephone">
            </div>
            <div>
                <label>Adresse :</label>
                <input type="text" name="adresse">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>