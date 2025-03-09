<?php
// add_employe.php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs du formulaire
    $nom       = $_POST['nom']       ?? '';
    $prenom    = $_POST['prenom']    ?? '';
    $email     = $_POST['email']     ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $poste     = $_POST['poste']     ?? '';
    $salaire   = $_POST['salaire']   ?? 0;

    try {
        // Préparation de la requête d’insertion
        $sql = "INSERT INTO employes (nom, prenom, email, telephone, poste, salaire)
                VALUES (:nom, :prenom, :email, :telephone, :poste, :salaire)";
        $stmt = $pdo->prepare($sql);

        // Exécution avec un tableau de paramètres
        $stmt->execute([
            ':nom'       => $nom,
            ':prenom'    => $prenom,
            ':email'     => $email,
            ':telephone' => $telephone,
            ':poste'     => $poste,
            ':salaire'   => $salaire
        ]);

        echo "Employé ajouté avec succès !";
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Employé</title>
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
            margin-bottom: 2rem;
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
        input[type="email"],
        input[type="number"] {
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
        }
    </style>
</head>
<body>
    <!-- Barre de navigation inchangée -->
    <nav class="navbar">
        <ul>
            <li><a href="../index.php">Accueil</a></li>
            <li><a href="../employe/index.php">Employés</a></li>
            <li><a href="../clients/index.php">Clients</a></li>
            <li><a href="../documents/index.php">Documents</a></li>
        </ul>
    </nav>

    <!-- Contenu principal inchangé -->
    <div class="container">
        <h1>Ajouter un Employé</h1>
        <form action="create.php" method="post">
            
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
                <label>Poste :</label>
                <input type="text" name="poste">
            </div>
            <div>
                <label>Salaire :</label>
                <input type="number" step="0.01" name="salaire">
            </div>
            <button type="submit">Ajouter</button>
        </form>
    </div>
</body>
</html>


