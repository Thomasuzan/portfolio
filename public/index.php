<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// On définit une constante ROOT qui pointe vers la racine du projet
define('ROOT', dirname(__DIR__));

// Détection automatique de l'environnement
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    define('BASE_URL', '/portfolio/public');
} else {
    define('BASE_URL', '');
}

// Autoload avec Composer
require_once ROOT . '/vendor/autoload.php';
$router = new AltoRouter();
$router->setBasePath(BASE_URL);
require ROOT . '/config/routes.php';

// On capture la partie de l'URL
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Adaptation pour WAMP en local
$basePath = 'portfolio/public';
if (strpos($request, $basePath) === 0) {
    $request = substr($request, strlen($basePath));
    $request = trim($request, '/');
}

// On sépare les paramètres
$params = explode('/', $request);


if ($params[0] === "") {
    $controller = new Controllers\HomeController();
    $controller->index();
    exit;
}

if ($params[0] === "admin") {
    if (!isset($params[1])) {

        // Route pour afficher le login
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->login(); // Appelle la méthode login
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "dashboard") {

        // Route pour afficher le dashboard
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->dashboard(); // Appelle la méthode dashboard
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "messages") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->messages(); // Appelle la méthode messages
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "add_project") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->add_project(); // Appelle la méthode messages
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "edit_project") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->edit_project($params[2]);
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "save_project") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->save_project($params[2]);
        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_project") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->delete_project($params[2]);
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_thumbnail") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->delete_thumbnail($params[2]);
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_thumbnail_details") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {
            $controller = new $controllerName($router);
            $controller->delete_thumbnail_details($params[2]);
        } else {
            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "add_detail") {

        // Route pour afficher les messages
        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {

            $controller = new $controllerName($router);

            $controller->add_detail($params[2]);

        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_detail") {

        // Route pour afficher les messages

        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {

            $controller = new $controllerName($router);

            $controller->delete_detail($params[2]);

        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_thumbnail_savoir_faire") {

        // Route pour afficher les messages

        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {

            $controller = new $controllerName($router);

            $controller->delete_thumbnail_savoir_faire($params[2]);

        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "add_savoir_faire") {

        // Route pour afficher les messages

        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {

            $controller = new $controllerName($router);

            $controller->add_savoir_faire($params[2]);

        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    } elseif ($params[1] === "delete_savoir_faire") {

        // Route pour afficher les messages

        $controllerName = "Controllers\AdminController";

        if (class_exists($controllerName)) {

            $controller = new $controllerName($router);

            $controller->delete_savoir_faire($params[2]);

        } else {

            echo "Le contrôleur AdminController n'a pas été trouvé.";
        }
    }
    exit;
}


    if ($params[0] === "legal") {
        if (!isset($params[1])) {
            $controllerName = "Controllers\LegalController";
            if (class_exists($controllerName)) {
                $controller = new $controllerName($router);
            } else {
                echo "Le contrôleur LegalController n'a pas été trouvé.";
            }
        } elseif ($params[1] === "mentions-legales") {

            // Route pour afficher la politique de confidentialité
            $controllerName = "Controllers\LegalController";

            if (class_exists($controllerName)) {
                $controller = new $controllerName($router);
                $controller->legal_notice(); // Appelle la méthode legal_notice
            } else {
                echo "Le contrôleur LegalController n'a pas été trouvé.";
            }
        } elseif ($params[1] === "politique-confidentialite") {

            // Route pour afficher la politique de confidentialité
            $controllerName = "Controllers\LegalController";

            if (class_exists($controllerName)) {
                $controller = new $controllerName($router);
                $controller->privacy_policy(); // Appelle la méthode privacy_policy
            } else {
                echo "Le contrôleur LegalController n'a pas été trouvé.";
            }
        } elseif ($params[1] === "plan-site") {

            // Route pour afficher le plan du site
            $controllerName = "Controllers\LegalController";

            if (class_exists($controllerName)) {
                $controller = new $controllerName($router);
                $controller->site_map(); // Appelle la méthode site_map
            } else {
                echo "Le contrôleur LegalController n'a pas été trouvé.";
            }
        }
        exit;
    }




    if ($params[0] === "a-propos") {
        $controller = new Controllers\AboutController();
        $controller->index();
        exit;
    }

    if ($params[0] === "projets") {
        $controller = new Controllers\ProjectsController();
        if (isset($params[1]) && $params[1] != '') $controller->show($params[1]);
        else $controller->index();
        exit;
    }

    if ($params[0] === "blog") {
        $controller = new Controllers\BlogController();
        $controller->index();
        exit;
    }


    if ($params[0] === "contact") {
        $controller = new Controllers\ContactController();
        $controller->index();
        exit;
    }


    if ($params[0] !== "") {

        // On récupère le nom du controller
        $controller = ucfirst($params[0]);



        // On vérifie s'il y a un deuxième paramètre sinon on renvoie vers la méthode index

        $action = isset($params[1]) ? $params[1] : 'index';



        //var_dump(file_exists(ROOT . '/controllers/' . $controller . 'Controller.php')); // Vérifie si le fichier existe



        require_once ROOT . '/controllers/' . $controller . 'Controller.php';



        //var_dump('Fichier inclus: ' . ROOT . '/controllers/' . $controller . 'Controller.php');



        // Ajouter 'Controller' à la fin du nom du contrôleur

        $controllerName = $controller . 'Controller';



        //var_dump('Avant instanciation de ' . $controllerName);

        //var_dump(class_exists($controllerName));





        if (method_exists($controller, $action)) {

            unset($params[0]);

            unset($params[1]);

            call_user_func_array([$controller, $action], $params);
        } else {
            require dirname(__DIR__) . '/errors/404-error.php';
        }
    }

