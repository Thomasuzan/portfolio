<?php

namespace Controllers;

use App\Controller;

class AboutController extends Controller
{

    /**
     * Méthode pour afficher la page à-propos
     */
    public function index()
    {
        // Charger la vue home.php
        $this->render('about');
    }
}
