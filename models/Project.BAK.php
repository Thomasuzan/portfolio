<?php

namespace Models;

use App\Model;
use PDO;


class Project extends Model
{
    protected $db;
    /**
     * Constructeur de la classe Project
     * Définit la table associée au modèle et initialise la connexion à la bdd
     */
    public function __construct()
    {
        $this->table = "projects";
        $this->db = $this->getConnection();
    }

    /**
     * Récupère tous les enregistrements de la table projects avec jointure d'image_url sur la table images
     * @return array
     */
    public function getProjectsWithImages()
    {
        $sql = "SELECT p.*, 
                       i.image_url, 
                    -- permet de récupérer toutes les catégories associées à un projet sous forme d'une chaîne de caractères séparée par des virgules (ex 'Front-end,Back-end')
                       GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM projects p
                LEFT JOIN images i ON p.id = i.project_id
                LEFT JOIN projects_categories_rel r ON p.id = r.project_id
                LEFT JOIN projects_categories c ON r.category_id = c.id
                GROUP BY p.id;";

        $q = $this->connection->prepare($sql);
        $q->execute();

        // Retourne un tableau associatif indexé par le slug
        $projects = $q->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($projects);


        $projectsBySlug = [];
        foreach ($projects as $project) {
             // Convertir la chaîne de catégories en tableau
        $project['categories'] = $project['categories'] ? explode(',', $project['categories']) : [];
            $projectsBySlug[$project['slug']] = $project;
        }

        return $projectsBySlug;
    }



    /**
     * Récupère tous les enregistrements de la table associée en fonction de son slug
     * @param string $slug
     */
    public function findBySlug(string $slug)
    {
        $sql = "SELECT p.*, i.image_url 
            FROM projects p
            LEFT JOIN images i ON p.id = i.project_id
            WHERE p.slug = :slug";

        $q = $this->connection->prepare($sql);
        $q->execute(['slug' => $slug]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les enregistrements de la table associée en fonction de son slug
     * @param string $slug
     */
    public function findById(int $id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        return $q->fetch();
    }

    public function saveProject($id, $title, $slug, $description, $content, $thumbnail = '')
    {
        if ($id == 0) {
            $q = $this->db->prepare("INSERT INTO projects (title, slug, description, content, thumbnail, updated_at) VALUES (:title, :slug, :description, :content, :thumbnail, NOW())");
            $q->execute([
                'title' => htmlspecialchars($title),
                'slug' => htmlspecialchars($slug),
                'description' => htmlspecialchars($description),
                'content' => htmlspecialchars($content),
                'thumbnail' => $thumbnail,
            ]);
        } else {
            $q = $this->db->prepare("UPDATE projects set title = :title, slug = :slug, description = :description, content= :content, thumbnail = :thumbnail, updated_at = NOW() WHERE id = :id");
            $q->execute([
                'id' => $id,
                'title' => htmlspecialchars($title),
                'slug' => htmlspecialchars($slug),
                'description' => htmlspecialchars($description),
                'content' => htmlspecialchars($content),
                'thumbnail' => $thumbnail,
            ]);
        }
    }

    public function deleteProject($id)
    {
        $q = $this->db->prepare("DELETE FROM projects WHERE id = :id");
        $q->execute([
            'id' => $id
        ]);
    }

    public function deleteThumbnail($id)
    {
        $q = $this->db->prepare("UPDATE projects set thumbnail = '' WHERE id = :id");
        $q->execute([
            'id' => $id
        ]);
        $q = $this->db->prepare("DELETE FROM images WHERE project_id = :project_id");
        $q->execute([
            'project_id' => $id
        ]);
    }

    public function saveImage($project_id, $image_url)
    {
        $q = $this->db->prepare("INSERT INTO images (image_url, project_id) VALUES (:image_url, :project_id)");
        $q->execute([
            'image_url' => htmlspecialchars($image_url),
            'project_id' => htmlspecialchars($project_id)
        ]);
    }
}
