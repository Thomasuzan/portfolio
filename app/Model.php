<?php

namespace App;
use PDO;
use PDOException;

// Charge la configuration de la base de données
require_once dirname(__DIR__) . '/config/database.php';

/**
 * Cette classe sert de modèle de base pour toutes les classes qui interagissent avec la bdd
 * Elle définit les méthodes communes à tous les modèles
 */
abstract class Model
{
    // Propriété contenant la connexion
    protected $connection;

    // Propriétés contenant les informations de requêtes
    public $table;
    public $id;

    /**
     * Établit une connexion à la base de données
     * @return PDO
     */
    public function getConnection(): PDO
    {
        $this->connection = null;
        
        try {
            $this->connection = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur BDD : ' . $e->getMessage());
        }
        return $this->connection;
    }

    /**
     * Récupère tous les enregistrements de la table associée
     * @return array
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $q = $this->connection->prepare($sql);
        $q->execute();
        return $q->fetchAll();
    }

    /**
     * Récupère un enregistrement spécifique par son id
     * @return array|false
     */
    public function getOne(): array|false
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $this->id]);
        return $q->fetch();
    }
}