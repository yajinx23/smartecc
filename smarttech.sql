-- Création de la base de données
CREATE DATABASE IF NOT EXISTS smarttech;
USE smarttech;

-- Table employes
CREATE TABLE IF NOT EXISTS employes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    poste VARCHAR(50) NOT NULL,
    salaire DECIMAL(10,2) NOT NULL,
    date_embauche DATE NOT NULL,
    departement VARCHAR(50) NOT NULL
);

-- Table client
CREATE TABLE IF NOT EXISTS client (
    idclient INT PRIMARY KEY AUTO_INCREMENT,
    societe VARCHAR(100) NOT NULL,
    contact VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telephone VARCHAR(20),
    date_ajout DATE NOT NULL
);

-- Table document
CREATE TABLE IF NOT EXISTS document (
    iddoc INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    typedoc VARCHAR(50) NOT NULL,
    descriptiondoc TEXT
);

