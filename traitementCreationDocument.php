<?php // enregistrer_document.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO('mysql:host=localhost;dbname=entreprise;charset=utf8', 'root', '');

        $data = [
            ':nom' => substr($_POST['nom'], 0, 100),
            ':type' => in_array($_POST['type'], ['PDF', 'DOCX', 'XLSX']) ? $_POST['type'] : 'AUTRE',
            ':desc' => substr($_POST['description'], 0, 500)
        ];

        $db->prepare("INSERT INTO document (nom, type, description) VALUES (?, ?, ?)")
            ->execute([$data[':nom'], $data[':type'], $data[':desc']]);

        $_SESSION['success'] = "Document sauvegardé";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur base de données";
    }
    echo $_SESSION;
    // header('Location: document_form.php');
    exit();
}
