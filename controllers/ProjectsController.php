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

        // Récupérer tous les projets pour navigation
        $allProjects = $this->Project->getProjectsWithImages();
        $slugs = array_keys($allProjects);
        $currentIndex = array_search($slug, $slugs);
        $totalProjects = count($slugs);

        // Projet précédent (boucle vers le dernier si on est au premier)
        $prevIndex = ($currentIndex - 1 + $totalProjects) % $totalProjects;
        $prevSlug = $slugs[$prevIndex];
        $prevProject = $allProjects[$prevSlug];

        // Projet suivant (boucle vers le premier si on est au dernier)
        $nextIndex = ($currentIndex + 1) % $totalProjects;
        $nextSlug = $slugs[$nextIndex];
        $nextProject = $allProjects[$nextSlug];

        // On envoie les données à la vue project.php
        $this->render('project', compact('project', 'prevProject', 'nextProject'));
    }
}
