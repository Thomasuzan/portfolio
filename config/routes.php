<?php

/*============================== Pages ====================================*/

$router->map('GET', '/', 'HomeController#index', 'home');
$router->map('POST', '/', 'ContactController#send', 'home_send');
$router->map('GET', '/a-propos', 'AboutController#index', 'about');
$router->map('GET', '/contact', 'ContactController#index', 'contact');
$router->map('POST', '/contact/envoyer', 'ContactController#send', 'contact_send');
$router->map('GET', '/legal/mentions-legales', 'LegalController#legal_notice', 'legal_notice');
$router->map('GET', '/legal/politique-confidentialite', 'LegalController#privacy_policy', 'privacy_policy');
$router->map('GET', '/legal/plan-site', 'LegalController#site_map', 'site_map');

/*============================== Projets ====================================*/

$router->map('GET', '/projets', 'ProjectsController#index', 'projects');
$router->map('GET', '/projets/[a:slug]', 'ProjectsController#show', 'project');

/*============================== Blog =======================================*/

$router->map('GET', '/blog', 'BlogController#index', 'blog');
// $router->map('GET', '/blog/[a:slug]', 'BlogController#show', 'single-post');

/*============================== Admin =======================================*/

$router->map('POST', '/admin', 'AdminController#login');
$router->map('GET', '/admin', 'AdminController#login', 'admin_login');
$router->map('GET', '/admin/dashboard', 'AdminController#dashboard', 'admin_dashboard');
$router->map('GET', '/admin/messages', 'AdminController#messages', 'admin_messages');
$router->map('GET', '/admin/add_project', 'AdminController#add_project', 'add_project');
$router->map('GET', '/admin/edit_project/[a:id]', 'AdminController#edit_project', 'edit_project');
$router->map('GET', '/admin/save_project/[a:id]', 'AdminController#save_project', 'save_project');
$router->map('GET', '/admin/delete_project/[a:id]', 'AdminController#delete_project', 'delete_project');
$router->map('GET', '/admin/delete_thumbnail/[a:id]', 'AdminController#delete_thumbnail', 'delete_thumbnail');
$router->map('GET', '/admin/delete_thumbnail_details/[a:id]', 'AdminController#delete_thumbnail_details', 'delete_thumbnail_details');
$router->map('GET', '/admin/add_detail/[a:id]', 'AdminController#add_detail', 'add_detail');
$router->map('GET', '/admin/delete_detail/[a:id]', 'AdminController#delete_detail', 'delete_detail');
$router->map('GET', '/admin/delete_thumbnail_savoir_faire/[a:id]', 'AdminController#delete_thumbnail_savoir_faire', 'delete_thumbnail_savoir_faire');
$router->map('GET', '/admin/add_savoir_faire/[a:id]', 'AdminController#add_savoir_faire', 'add_savoir_faire');
$router->map('GET', '/admin/delete_savoir_faire/[a:id]', 'AdminController#delete_savoir_faire', 'delete_savoir_faire');


/* Debug */

// $match = $router->match($_SERVER['REQUEST_URI']);
// if ($match === false) {
//     echo "Page non trouvée !";
// } else {
//     var_dump($match);
//     echo '<br>';
//     echo "Route trouvée pour " . $match['target'];
//     echo '<br>';
// }