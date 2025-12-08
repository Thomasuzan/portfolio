<?php

namespace Controllers;

use App\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        // Démarre la session pour pouvoir utiliser $_SESSION
        session_start();
    }

    /**
     * Méthode pour afficher la page d'accueil
     */
    public function index()
    {
        // Charger la vue home.php
        $this->render('home');
    }
}
