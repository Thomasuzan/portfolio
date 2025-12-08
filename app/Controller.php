<?php

namespace App;

abstract class Controller
{

    /**
     * Charge un modèle et l'instancie
     * @param string $model
     * @return void
     */
    public function loadModel(string $model)

    {   // Construit le chemin du fichier
        $file = ROOT . '/models/' . $model . '.php';
        if (!file_exists($file)) {
            die("Fichier modèle introuvable : " . $file);
        }
        require_once $file;
        
        // Ajoute le namespace correct
        $class = "Models\\" . $model;
        
        // Vérifie si la classe existe
        if (!class_exists($class)) {
            die("Classe modèle introuvable : " . $class);
        }
        $this->$model = new $class();
    }

    /**
     * Charge et affiche une vue associée à un contrôleur
     * @param string $file Nom du fichier de la vue à inclure (sans l'extension)
     * @param array $data Données à extraire et à rendre accessibles dans la vue
     * @return never
     */
    public function render(string $file, array $data = [])
    {
        //var_dump("Chargement de la vue : " . $file);

        // Convertit les clés du tableau associatif $data en variables accessibles dans la vue
        extract($data);

        global $router;

        // Démarrage du buffer
        ob_start();

        // Récupérer le nom complet de la classe
        $controllerName = get_class($this);

        //Prendre uniquement la dernière partie (ExempleController)
        $controllerName = substr($controllerName, strrpos($controllerName, '\\') + 1);

        // Supprimer 'Controller'
        $controllerName = str_replace('Controller', '', $controllerName);

        // Convertir en minuscule
        $controllerName = strtolower($controllerName);

        // On inclut la vue en utilisant un bon séparateur et en s'assurant du chemin correct
        $viewPath = ROOT . '/views' . DIRECTORY_SEPARATOR .  $controllerName . DIRECTORY_SEPARATOR . $file . '.php';
        
        // On vérifie que le fichier existe avant d'inclure la vue
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("La vue $file n'existe pas.");
        }
        $content = ob_get_clean();
        require_once ROOT . '/views/layouts/default.php';
        exit;
    }
}
