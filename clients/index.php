<?php
// clients/index.php
require_once '../config/database.php';  // Ajustez le chemin si nécessaire

try {
    // Récupérer tous les clients
    $stmt = $pdo->query("SELECT client_id, nom, prenom, email, telephone, adresse FROM clients");
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des clients : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clients</title>
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
        <h1>Liste des Clients</h1>
        <a href="create.php" class="btn-create">+ Ajouter un client</a>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Adresse</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($clients)) : ?>
                    <?php foreach ($clients as $cli) : ?>
                        <tr>
                            <td><?= $cli['client_id'] ?></td>
                            <td><?= htmlspecialchars($cli['nom']) ?></td>
                            <td><?= htmlspecialchars($cli['prenom']) ?></td>
                            <td><?= htmlspecialchars($cli['email']) ?></td>
                            <td><?= htmlspecialchars($cli['telephone']) ?></td>
                            <td><?= htmlspecialchars($cli['adresse']) ?></td>
                            <td class="actions">
                                <a href="update.php?id=<?= $cli['client_id'] ?>">Modifier</a>
                                <a href="delete.php?id=<?= $cli['client_id'] ?>" 
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
                                   Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7">Aucun client trouvé.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>