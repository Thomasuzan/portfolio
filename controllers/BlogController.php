<?php

namespace Controllers;

use App\Controller;


class BlogController extends Controller
{

    /**
     * Méthode pour afficher la page blog
     */
    public function index()
    {
        // Charger la vue home.php
        $this->render('blog');
    }
}
