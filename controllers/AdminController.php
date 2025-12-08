<?php

namespace Controllers;

use App\Controller;
use Models\Message;
use Models\Project;


class AdminController extends Controller
{

    protected $router;

    public function __construct($router)
    {
        // Démarre la session uniquement pour les pages Admin
        session_start();
        $this->router = $router;
    }


    // Définition de la propriété User
    protected $User;


    public function login()
    {
        // Initialise la variable $error avec une valeur par défaut
        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->loadModel('User');
            $user = $this->User->findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
                //var_dump($_SESSION['user']);
                //dd("Redirection vers dashboard"); 
                header('Location: ' . $this->router->generate('admin_dashboard'));
                exit;
            } else {
                $error = "Identifiants incorrects";
            }
        }

        if (isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->render('login', compact('error'));
    }


    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        // Instancier le modèle Project
        $projectModel = new Project();
        
        // Récupérer les projets via la méthode getProjectsWithImages
        $projects = $projectModel->getProjectsWithImages();

        $this->render('dashboard', ['projects' => $projects]);
    }

    public function messages()
    {
        // Instancier le modèle Message
        $messageModel = new Message();

        // Récupérer les messages via la méthode getMessages
        $messages = $messageModel->getMessages();

        // Passer les messages à la vue
        // Si tu utilises une méthode render(), assure-toi que tu passes $messages comme paramètre
        $this->render('messages', ['messages' => $messages]);
    }


    public function add_project()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        $this->render('project', ['id' => 0]);
    }


    public function edit_project($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->loadModel('Project');

        // On stocke le projet dans $project
        $project = $this->Project->findById($id);
        $categories = $this->Project->getCategories();
        $details = $this->Project->getDetails($id);
        $savoir_faire = $this->Project->getSavoirFaire($id);

        $this->render('project', ['id' => $id, 'categories' => $categories, 'details' => $details, 'savoir_faire' => $savoir_faire, 'project' => $project]);
    }


    public function add_detail($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->loadModel('Project');
        $this->Project->newDetail($id);
        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
        exit;
    }


    public function add_savoir_faire($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->loadModel('Project');
        $this->Project->newSavoirFaire($id);
        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
        exit;
    }


    public function delete_detail($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->loadModel('Project');
        $project_id = $this->Project->deleteDetail($id);

        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $project_id]));
        exit;
    }


    public function delete_savoir_faire($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        $this->loadModel('Project');
        $project_id = $this->Project->deleteSavoirFaire($id);

        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $project_id]));
        exit;
    }


    public function save_project($id)
    {

        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        foreach($_POST as $key => $value) {
          $$key = $value;
          $_SESSION[$key] = $value;
        }

        // Initialise la variable $error avec une valeur par défaut
        $error = false;
        if ( empty($title) ) $error = "Le titre est obligatoire";
        else if ( empty($slug) ) $error = "Le slug est obligatoire";
        else if ( empty($description) ) $error = "La description est obligatoire";
        else if ( empty($content) ) $error = "Le contenu est obligatoire";

        if ( $error ) {
            $_SESSION['error'] = $error;
            header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
            exit;
        }

        // Gestion du fichier
        $filePath = $thumbnail_old;
        if (!empty($_FILES['thumbnail']['name'])) {
            $uploadDir = 'assets/img/picture/common/portfolio-section/' . date('Y/m/d') . '/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true); // Crée le dossier s'il n'existe pas
            }
            $fileExt = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
            $newFileName = uniqid("file_", true) . "." . $fileExt;
            $filePath = $uploadDir . $newFileName;
            if (!move_uploaded_file($_FILES['thumbnail']['tmp_name'], $filePath)) {
                $_SESSION['error'] = "Erreur lors du téléchargement du fichier.";
                header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
                exit;
            }
            $projectModel = new Project();
            $projectModel->saveImage($id, $filePath);
        }

        // Gestion du fichier détails
        $filePathDetails = $thumbnail_old_details;
        if (!empty($_FILES['thumbnail_details']['name'])) {
            $uploadDir = 'assets/img/picture/common/portfolio-section/' . date('Y/m/d') . '_details/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true); // Crée le dossier s'il n'existe pas
            }
            $fileExtDetails = strtolower(pathinfo($_FILES['thumbnail_details']['name'], PATHINFO_EXTENSION));
            $newFileNameDetails = uniqid("file_", true) . "_details." . $fileExtDetails;
            $filePathDetails = $uploadDir . $newFileNameDetails;
            if (!move_uploaded_file($_FILES['thumbnail_details']['tmp_name'], $filePathDetails)) {
                $_SESSION['error'] = "Erreur lors du téléchargement du fichier du bloc détails.";
                header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
                exit;
            }
            $projectModel = new Project();
        }

        // Gestion du fichier savoir faire
        $filePathSavoirFaire = $thumbnail_old_savoir_faire;
        if (!empty($_FILES['thumbnail_savoir_faire']['name'])) {
            $uploadDir = 'assets/img/picture/common/portfolio-section/' . date('Y/m/d') . '_savoir_faire/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0775, true); // Crée le dossier s'il n'existe pas
            }
            $fileExtSavoirFaire = strtolower(pathinfo($_FILES['thumbnail_savoir_faire']['name'], PATHINFO_EXTENSION));
            $newFileNameSavoirFaire = uniqid("file_", true) . "_savoir_faire." . $fileExtSavoirFaire;
            $filePathSavoirFaire = $uploadDir . $newFileNameSavoirFaire;
            if (!move_uploaded_file($_FILES['thumbnail_savoir_faire']['tmp_name'], $filePathSavoirFaire)) {
                $_SESSION['error'] = "Erreur lors du téléchargement du fichier du bloc savoir-faire.";
                header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
                exit;
            }
            $projectModel = new Project();
        }

        // Sauvegarde en base de données
        $projectModel = new Project();
        $id = $projectModel->saveProject($id, $title, $slug, $description, $content, $content_savoir_faire, $filePath, $filePathDetails, $filePathSavoirFaire);
        $projectModel->updateCategories($id, $categories);

        foreach( $details as $detail_id ) {
            $label_field = 'label_' . $detail_id;
            $value_field = 'value_' . $detail_id;
            $sort_order_field = 'sort_order_' . $detail_id;
            $projectModel->updateDetail($detail_id, $id, $$label_field, $$value_field, $$sort_order_field);
        }

        foreach( $savoir_faire as $savoir_faire_id ) {
            $value_field = 'savoir_faire_value_' . $savoir_faire_id;
            $sort_order_field = 'savoir_faire_sort_order_' . $savoir_faire_id;
            $projectModel->updateSavoirFaire($savoir_faire_id, $id, $$value_field, $$sort_order_field);
        }

        $_SESSION['success'] = "Le projet a bien été enregistré.";
        unset( $_SESSION['title'] );
        unset( $_SESSION['slug'] );
        unset( $_SESSION['description'] );
        unset( $_SESSION['content'] );
        unset( $_SESSION['content_savoir_faire'] );
        
        header('Location: ' . $this->router->generate('admin_dashboard'));
        exit;

    }


    public function delete_project($id)
    {

        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        // Sauvegarde en base de données
        $projectModel = new Project();
        $projectModel->deleteProject($id);
        $_SESSION['success'] = "Le projet a bien été supprimé.";
        
        header('Location: ' . $this->router->generate('admin_dashboard'));
        exit;

    }


    public function delete_thumbnail($id)
    {

        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        // Sauvegarde en base de données
        $projectModel = new Project();
        $projectModel->deleteThumbnail($id);
        $_SESSION['success'] = "Le visuel a bien été supprimé.";
        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
        exit;

    }


    public function delete_thumbnail_details($id)
    {

        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        // Sauvegarde en base de données
        $projectModel = new Project();
        $projectModel->deleteThumbnailDetails($id);
        $_SESSION['success'] = "Le visuel du bloc détails a bien été supprimé.";
        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
        exit;

    }


    public function delete_thumbnail_savoir_faire($id)
    {

        if (!isset($_SESSION['user'])) {
            header('Location: ' . $this->router->generate('admin_login'));
            exit;
        }

        if ( $id == '' ) {
            header('Location: ' . $this->router->generate('admin_dashboard'));
            exit;
        }

        // Sauvegarde en base de données
        $projectModel = new Project();
        $projectModel->deleteThumbnailSavoirFaire($id);
        $_SESSION['success'] = "Le visuel du bloc savoir-faire a bien été supprimé.";
        
        header('Location: ' . $this->router->generate('edit_project', ['id' => $id]));
        exit;

    }
}
