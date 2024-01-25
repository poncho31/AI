<?php

namespace GillesPinchart\Ai\database;

use PDO;
use PDOException;

class Sqlite
{
    public function connect(): bool
    {
        try {
            // Chemin vers le fichier de base de données SQLite
            $databasePath = __DIR__.'\database.sqlite';
            var_dump($databasePath);
            // Création de la connexion à la base de données SQLite
            $pdo = new PDO('sqlite:' . $databasePath);

            // Activation du mode d'erreur PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connexion à la base de données SQLite réussie";
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            return false;
        }
        return true;
    }
}