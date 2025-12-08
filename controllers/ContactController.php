<?php

namespace Controllers;

use App\Controller;
use Models\Message;

class ContactController extends Controller
{

    /**
     * Démarre la session chaque fois qu'une instance de ContactController est créée
     */
    public function __construct()
    {
        // Démarre la session pour pouvoir utiliser $_SESSION
        session_start();
    }


    /**
     * Méthode pour afficher la page de contact
     */
    public function index()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->send();
        }
        $this->render('contact');
    }


    /**
     * Gère l'envoi du formulaire de contact
     */
    public function send()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name = trim(htmlspecialchars($_POST['name']));
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $message = trim(htmlspecialchars($_POST['message']));
            $filePath = null;

            // Détecte la page d'origine
            $origin = $_POST['origin'] ?? 'contact';
            $redirectUrl = ($origin === 'home') ? '/#home-contact-form' : '/contact#contact-form';

            // Vérification de la case à cocher RGBD
            $rgbd = isset($_POST['rgbd']) ? true : false;


            // On vérifie si le champ "recaptcha-response" contient une valeur
            if (empty($_POST['recaptcha-response'])) {
                $_SESSION['error'] = "Une erreur est survenue. Veuillez réessayer.";
                header("Location: $redirectUrl");
                exit;
            }

            // Vérification du reCAPTCHA
            $recaptchaSecret = '6LdYIPIqAAAAAACGAKECKWZ8M8dopli33fjDF0Ng';

            // On prépare l'URL
            $url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response={$_POST['recaptcha-response']}";

            // On vérifie si curl est installé
            if (function_exists('curl_version')) {
                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($curl);
            } else {
                // Sinon on utilise file_get_contents
                $response = file_get_contents($url);
            }

            // Debug affiche la réponse de Google
            // dd(json_decode($response));

            // On vérifie qu'on a une réponse
            if (empty($response) || is_null($response)) {
                header("Location: $redirectUrl");
            } else {
                $data = json_decode($response);
                if ($data->success) {

                    // Google a répondu avec un succès
                    // On traite le formulaire

                    // Vérifier si les champs obligatoires sont remplis
                    if (empty($name) || empty($email) || empty($message) || !$rgbd) {
                        $_SESSION['name'] = $name;
                        $_SESSION['email'] = $email;
                        $_SESSION['message'] = $message;
                        $_SESSION['error'] = "Tous les champs doivent être remplis.";
                        header("Location: $redirectUrl");
                        exit;
                    }

                    // Gestion du fichier
                    if (!empty($_FILES['file']['name'])) {
                        $uploadDir = 'uploads/' . date('Y/m/d') . '/';
                        //var_dump($uploadDir); die;
                        if (!is_dir($uploadDir)) {

                            // Crée le dossier s'il n'existe pas
                            mkdir($uploadDir, 0775, true);
                        }

                        $fileExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
                        $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'];
                        $maxFileSize = 5 * 1024 * 1024; // 5 Mo

                        if (!in_array($fileExt, $allowedTypes)) {
                            $_SESSION['error'] = "Format de fichier non autorisé.";
                            header("Location: $redirectUrl");
                            exit;
                        }
                        if ($_FILES['file']['size'] > $maxFileSize) {
                            $_SESSION['error'] = "Le fichier dépasse la taille maximale de 5 Mo.";
                            header("Location: $redirectUrl");
                            exit;
                        }
                        $newFileName = uniqid("file_", true) . "." . $fileExt;
                        $filePath = $uploadDir . $newFileName;
                        //var_dump($_FILES['file']['tmp_name']); die;
                        
                        // if (!file_exists($_FILES['file']['tmp_name'])) {
                        //     die("Le fichier temporaire n'existe plus.");
                        // }
                        // if (!is_writable($uploadDir)) {
                        //     die("Le dossier cible n'est pas accessible en écriture.");
                        // }
                        // if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
                        //     die("Échec de move_uploaded_file() : ".$_FILES['file']['tmp_name']." → ".$filePath);
                        // }
                        // die("Fichier uploadé avec succès !");

                        if (!move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {

                            $_SESSION['error'] = "Erreur lors du téléchargement du fichier.";
                            header("Location: $redirectUrl");
                            exit;
                        } else {
                            error_log("Fichier bien uploadé : " . $filePath);
                        }
                        // if (file_exists($filePath)) {
                        //     die("Le fichier a bien été déplacé et est accessible à : " . $filePath);
                        // } else {
                        //     die("Le fichier a été uploadé mais n'est pas trouvé après déplacement !");
                        // }
                        
                    }
                } else {
                    header("Location: $redirectUrl");
                }
            }


            // Envoyer l'email
            $to = "thomasuzanpro@gmail.com";
            $subject = "$name vous écrit depuis votre portfolio";
            $headers = "From: $email\r\nReply-To: $email";
            $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

            if (mail($to, $subject, $body, $headers)) {

                // Sauvegarde en base de données
                $messageModel = new Message();
                $messageModel->saveMessage($name, $email, $message, $filePath);

                $_SESSION['success'] = "Votre message a bien été envoyé.";
                unset($_SESSION['name'], $_SESSION['email'], $_SESSION['message']);
            } else {
                $_SESSION['error'] = "Erreur lors de l'envoi du message.";
            }
            header("Location: $redirectUrl");
            exit;
        }
    }
}
