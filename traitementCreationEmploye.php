<?php
// session_start();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     try {
//         $db = new PDO('mysql:host=127.0.0.1;dbname=smarttech', 'root', '');

//         $stmt = $db->prepare("INSERT INTO employes 
//             (nom, prenom, email, poste, salaire, date_embauche, departement)
//             VALUES (?, ?, ?, ?, ?, ?, ?)");
//         var_dump($_POST);
//         $stmt->execute([
//             $_POST['nom'],
//             $_POST['prenom'],
//             $_POST['email'],
//             $_POST['poste'],
//             $_POST['salaire'],
//             $_POST['date_embauche'],
//             $_POST['departement']
//         ]);
//         echo "employer enregistrer";
//         // $_SESSION['success'] = "Employé enregistré avec succès!";
//     } catch (PDOException $e) {
//         // $_SESSION['error'] = "Erreur : " . $e->getMessage();
//         echo "employer non enregistrer";
//     }
//     // header('Location: employe_form.php');
//     echo $_SESSION;
//     exit();
// }
// session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Activer le rapport d'erreurs MySQLi
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    // echo "36";
    // var_dump($_POST);
    // INSERT INTO employes (nom, prenom, email, poste, salaire, date_embauche, departement) 
    // VALUES ('TestNom', 'TestPrenom', 'test@email.com', 'Développeur', 2000, '2024-03-06', 'IT');

    // Connexion à la base de données

    $db = new mysqli('localhost', 'admin', 'passer', 'smarttech');
    if ($db->connect_error) {
        die("Échec de la connexion : " . $db->connect_error);
    }
    // Préparation de la requête
    $stmt = $db->prepare("INSERT INTO employes 
            (nom, prenom, email, poste, salaire, date_embauche, departement)
            VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Debug (identique à la version PDO)
    // var_dump($_POST);
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $db->error);
    }
    // Récupération des données POST
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];
    $date_embauche = $_POST['date_embauche'];
    $departement = $_POST['departement'];

    // Liaison des paramètres (types: s=string, d=double)
    $stmt->bind_param('ssssdss', $nom, $prenom, $email, $poste, $salaire, $date_embauche, $departement);

    // Exécution
    $stmt->execute();

    // Message de succès
    echo "Employé enregistré avec succès!";
    // Gestion des erreurs
    // $_SESSION['error'] = "Erreur : " . $e->getMessage();

    // Redirection vers le formulaire
    // header('Location: employe_form.php');
    exit();
}
