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
        $sql = "SELECT p.*, i.image_url 
                FROM projects p
                LEFT JOIN images i ON p.id = i.project_id";

        $q = $this->connection->prepare($sql);
        $q->execute();

        // Retourne un tableau associatif indexé par le slug
        $projects = $q->fetchAll(PDO::FETCH_ASSOC);

        //var_dump($projects);


        $projectsBySlug = [];
        foreach ($projects as $project) {
            $project['categories'] = [];
            $sql = "SELECT * FROM projects_categories_rel WHERE project_id = :id";
            $q = $this->connection->prepare($sql);
            $q->execute(['id' => $project['id']]);
            $projectCategories = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $projectCategories as $projectCategory ) {
                $project['categories'][] = $projectCategory['category_id'];
            }
            $project['details'] = [];
            $sql = "SELECT * FROM projects_details WHERE project_id = :id ORDER BY sort_order";
            $q = $this->connection->prepare($sql);
            $q->execute(['id' => $project['id']]);
            $projectDetails = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $projectDetails as $projectDetail ) {
                $project['details'][$projectDetail['label']] = $projectDetail['value'];
            }
            $project['savoir_faire'] = [];
            $sql = "SELECT * FROM projects_savoir_faire WHERE project_id = :id ORDER BY sort_order";
            $q = $this->connection->prepare($sql);
            $q->execute(['id' => $project['id']]);
            $projectSavoirFaire = $q->fetchAll(PDO::FETCH_ASSOC);
            foreach ( $projectSavoirFaire as $projectSavoir ) {
                $project['savoir_faire'][] = $projectSavoir['value'];
            }
            $projectsBySlug[$project['slug']] = $project;
        }

        return $projectsBySlug;
    }

    /**
     * Récupère tous les enregistrements de la table projects avec jointure d'image_url sur la table images
     * @return array
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM projects_categories ORDER BY name";

        $q = $this->connection->prepare($sql);
        $q->execute();

        // Retourne un tableau associatif indexé par le slug
        $categories = $q->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    public function updateCategories( $project_id, $projectCategories )
    {
        $categories = $this->getCategories();
        foreach ( $categories as $category ) {
            if ( in_array($category['id'], $projectCategories) ) {
                $sql = "INSERT IGNORE INTO projects_categories_rel (project_id, category_id) VALUES (:project_id, :category_id)";
                $q = $this->connection->prepare($sql);
                $q->execute(['project_id' => $project_id, 'category_id' => $category['id']]);
            }
            else {
                $sql = "DELETE FROM projects_categories_rel WHERE project_id = :project_id AND category_id = :category_id";
                $q = $this->connection->prepare($sql);
                $q->execute(['project_id' => $project_id, 'category_id' => $category['id']]);
            }
        }
    }

    public function getDetails($project_id)
    {
        $sql = "SELECT * FROM projects_details WHERE project_id = :project_id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id]);
        $details = $q->fetchAll(PDO::FETCH_ASSOC);
        return $details;
    }

    public function getSavoirFaire($project_id)
    {
        $sql = "SELECT * FROM projects_savoir_faire WHERE project_id = :project_id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id]);
        $savoir_faire = $q->fetchAll(PDO::FETCH_ASSOC);
        return $savoir_faire;
    }

    public function deleteDetail($id)
    {
        $sql = "SELECT project_id FROM projects_details WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $project = $q->fetch(PDO::FETCH_ASSOC);
        $sql = "DELETE FROM projects_details WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);

        return $project['project_id'];
    }

    public function deleteSavoirFaire($id)
    {
        $sql = "SELECT project_id FROM projects_savoir_faire WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $project = $q->fetch(PDO::FETCH_ASSOC);
        $sql = "DELETE FROM projects_savoir_faire WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);

        return $project['project_id'];
    }

    public function updateDetail($id, $id_project, $label, $value, $sort_order)
    {
        $sql = "SELECT * FROM projects_details WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $project = $q->fetch(PDO::FETCH_ASSOC);
        if ( $project ) {
            if ( !empty($label) && !empty($value)) {
                $q = $this->db->prepare("UPDATE projects_details set label = :label, value = :value, sort_order = :sort_order WHERE id = :id");
                $q->execute([
                    'label' => htmlspecialchars($label),
                    'value' => htmlspecialchars($value),
                    'sort_order' => htmlspecialchars($sort_order),
                    'id' => $id
                ]);
            }
            else {
                $sql = "DELETE FROM projects_details WHERE id = :id";
                $q = $this->connection->prepare($sql);
                $q->execute(['id' => $id]);
            }
        }
        else {
            if ( !empty($label) && !empty($value)) {
                $sql = "INSERT IGNORE INTO projects_details (project_id, label, value, sort_order) VALUES (:project_id, :label, :value, :sort_order)";
                $q = $this->connection->prepare($sql);
                $q->execute(['project_id' => $project_id, 'label' => $label, 'value' => $value, 'sort_order' => $sort_order + 1]);

                $q = $this->db->prepare("UPDATE projects_details set label = :label, value = :value, sort_order = :sort_order WHERE id = :id");
                $q->execute([
                    'label' => htmlspecialchars($label),
                    'value' => htmlspecialchars($value),
                    'sort_order' => htmlspecialchars($sort_order),
                    'id' => $id
                ]);
            }
        }
    }

    public function updateSavoirFaire($id, $id_project, $value, $sort_order)
    {
        $sql = "SELECT * FROM projects_savoir_faire WHERE id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $project = $q->fetch(PDO::FETCH_ASSOC);
        if ( $project ) {
            if ( !empty($value)) {
                $q = $this->db->prepare("UPDATE projects_savoir_faire set value = :value, sort_order = :sort_order WHERE id = :id");
                $q->execute([
                    'value' => htmlspecialchars($value),
                    'sort_order' => htmlspecialchars($sort_order),
                    'id' => $id
                ]);
            }
            else {
                $sql = "DELETE FROM projects_savoir_faire WHERE id = :id";
                $q = $this->connection->prepare($sql);
                $q->execute(['id' => $id]);
            }
        }
        else {
            if ( !empty($value)) {
                $sql = "INSERT IGNORE INTO projects_savoir_faire (project_id, value, sort_order) VALUES (:project_id, :value, :sort_order)";
                $q = $this->connection->prepare($sql);
                $q->execute(['project_id' => $project_id, 'value' => $value, 'sort_order' => $sort_order + 1]);

                $q = $this->db->prepare("UPDATE projects_savoir_faire set value = :value, sort_order = :sort_order WHERE id = :id");
                $q->execute([
                    'value' => htmlspecialchars($value),
                    'sort_order' => htmlspecialchars($sort_order),
                    'id' => $id
                ]);
            }
        }
    }

    public function newDetail($project_id)
    {
        $sql = "SELECT max(sort_order) as max FROM projects_details WHERE project_id = :project_id";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id]);
        $max = $q->fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT IGNORE INTO projects_details (project_id, sort_order) VALUES (:project_id, :sort_order)";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id, 'sort_order' => $max['max'] + 1]);
    }

    public function newSavoirFaire($project_id)
    {
        $sql = "SELECT max(sort_order) as max FROM projects_savoir_faire WHERE project_id = :project_id";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id]);
        $max = $q->fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT IGNORE INTO projects_savoir_faire (project_id, sort_order) VALUES (:project_id, :sort_order)";
        $q = $this->connection->prepare($sql);
        $q->execute(['project_id' => $project_id, 'sort_order' => $max['max'] + 1]);
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
        $project = $q->fetch(PDO::FETCH_ASSOC);
        $project['categories'] = [];
        $sql = "SELECT * FROM projects_categories_rel WHERE project_id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $project['id']]);
        $projectCategories = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectCategories as $projectCategory ) {
            $project['categories'][] = $projectCategory['category_id'];
        }
        $project['details'] = [];
        $sql = "SELECT * FROM projects_details WHERE project_id = :id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $project['id']]);
        $projectDetails = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectDetails as $projectDetail ) {
            $project['details'][$projectDetail['label']] = $projectDetail['value'];
        }
        $project['savoir_faire'] = [];
        $sql = "SELECT * FROM projects_savoir_faire WHERE project_id = :id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $project['id']]);
        $projectSavoirFaire = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectSavoirFaire as $projectSavoir ) {
            $project['savoir_faire'][] = $projectSavoir['value'];
        }
        return $project;
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
        $project = $q->fetch(PDO::FETCH_ASSOC);
        $project['categories'] = [];
        $sql = "SELECT * FROM projects_categories_rel WHERE project_id = :id";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $projectCategories = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectCategories as $projectCategory ) {
            $project['categories'][] = $projectCategory['category_id'];
        }
        $project['details'] = [];
        $sql = "SELECT * FROM projects_details WHERE project_id = :id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $projectDetails = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectDetails as $projectDetail ) {
            $project['details'][$projectDetail['label']] = $projectDetail['value'];
        }
        $project['savoir_faire'] = [];
        $sql = "SELECT * FROM projects_savoir_faire WHERE project_id = :id ORDER BY sort_order";
        $q = $this->connection->prepare($sql);
        $q->execute(['id' => $id]);
        $projectSavoirFaire = $q->fetchAll(PDO::FETCH_ASSOC);
        foreach ( $projectSavoirFaire as $projectSavoir ) {
            $project['savoir_faire'][] = $projectSavoir['value'];
        }
        return $project;
    }

    public function saveProject($id, $title, $slug, $description, $content, $content_savoir_faire, $thumbnail = '', $thumbnail_details = '', $thumbnail_savoir_faire = '')
    {
        if ($id == 0) {
            $q = $this->db->prepare("INSERT INTO projects (title, slug, description, content, thumbnail, thumbnail_details, thumbnail_savoir_faire, updated_at) VALUES (:title, :slug, :description, :content, :thumbnail, :thumbnail_details, :thumbnail_savoir_faire, NOW())");
            $q->execute([
                'title' => htmlspecialchars($title),
                'slug' => htmlspecialchars($slug),
                'description' => htmlspecialchars($description),
                'content' => htmlspecialchars($content),
                'thumbnail' => $thumbnail,
                'thumbnail_details' => $thumbnail_details,
                'thumbnail_savoir_faire' => $thumbnail_savoir_faire,
            ]);
            $id = $this->db->lastInsertId();
        } else {
            $q = $this->db->prepare("UPDATE projects set title = :title, slug = :slug, description = :description, content= :content, content_savoir_faire= :content_savoir_faire, thumbnail = :thumbnail, thumbnail_details = :thumbnail_details, thumbnail_savoir_faire = :thumbnail_savoir_faire, updated_at = NOW() WHERE id = :id");
            $q->execute([
                'id' => $id,
                'title' => htmlspecialchars($title),
                'slug' => htmlspecialchars($slug),
                'description' => htmlspecialchars($description),
                'content' => htmlspecialchars($content),
                'content_savoir_faire' => htmlspecialchars($content_savoir_faire),
                'thumbnail' => $thumbnail,
                'thumbnail_details' => $thumbnail_details,
                'thumbnail_savoir_faire' => $thumbnail_savoir_faire,
            ]);
        }
        return $id;
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

    public function deleteThumbnailDetails($id)
    {
        $q = $this->db->prepare("UPDATE projects set thumbnail_details = '' WHERE id = :id");
        $q->execute([
            'id' => $id
        ]);
    }

    public function deleteThumbnailSavoirFaire($id)
    {
        $q = $this->db->prepare("UPDATE projects set thumbnail_savoir_faire = '' WHERE id = :id");
        $q->execute([
            'id' => $id
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
