<?php

namespace Controllers;

use App\Controller;

class ProjectsController extends Controller
{
    
    // Définition de la propriété Project
    protected $Project;

    /**
     * Charge le modèle Project, récupère tous les projets et les transmet à la vue index.php
     * @return void
     */
    public function index()
    {
        // On instancie le modèle Project
        $this->loadModel('Project');

        // On stocke les projets dans $project
        $projects = $this->Project->getProjectsWithImages();

        // On envoie les données à la vue index
        $this->render('index', ['projects' => $projects]);
    }


    /**
     * Méthode permettant d'afficher un projet à partir de son slug
     * @param mixed $slug
     * @return void
     */
    public function show($slug)
    {
        // On instancie le modèle Project
        $this->loadModel('Project');

        // On stocke le projet dans $project
        $project = $this->Project->findBySlug($slug);

        // On envoie les données à la vue project.php
        $this->render('project', compact('project'));
    }
}
