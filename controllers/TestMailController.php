<?php

// controllers/TestMailController.php

namespace Controllers;

use App\Controller;

class TestMailController extends Controller
{
    public function index()
    {
        // Tester l'envoi de l'email
        $to = "thomas_uzanpro@gmail.com";
        $subject = "Test d'envoi de mail";
        $message = "Ceci est un test d'envoi de mail depuis ton site web.";
        $headers = "From: test@thomasbinr.fr";

        if (mail($to, $subject, $message, $headers)) {
            echo "L'email a été envoyé avec succès.";
        } else {
            echo "Une erreur est survenue lors de l'envoi de l'email.";
        }
    }
}
