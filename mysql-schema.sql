-- Structure des tables principales
CREATE DATABASE IF NOT EXISTS gestion_app;
USE gestion_app;

-- Table des employés
CREATE TABLE employes (
    employe_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    poste VARCHAR(50),
    salaire DECIMAL(10,2)
);

-- Table des clients
CREATE TABLE clients (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    adresse VARCHAR(255)
);

-- Table des documents
CREATE TABLE documents (
    document_id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    description_fichier TEXT,
    chemin_fichier VARCHAR(255) NOT NULL,
    type_fichier VARCHAR(50),
    related_to ENUM('employe', 'client') NOT NULL,
    related_id INT NOT NULL,
    date_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    uploaded_by INT,
    FOREIGN KEY (uploaded_by) REFERENCES employes(employe_id) ON DELETE CASCADE
);

-- Index pour améliorer les performances
CREATE INDEX idx_related ON documents(related_to, related_id);
