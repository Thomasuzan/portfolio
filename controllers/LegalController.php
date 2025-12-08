<?php

namespace Controllers;

use App\Controller;

class LegalController extends Controller

{
    /**

     * Méthode pour afficher la page mentions légales

     */

    public function legal_notice()

    {

        // Charger la vue home.php

        $this->render('legal_notice');

    }



    /**

     * Méthode pour afficher la page politique de confidentionalité

     */

    public function privacy_policy()

    {

        // Charger la vue home.php

        $this->render('privacy_policy');

    }



    /**

     * Méthode pour afficher la page plan du site

     */

    public function site_map()
    {
        // Charger la vue home.php
        $this->render('site_map');
    }

}