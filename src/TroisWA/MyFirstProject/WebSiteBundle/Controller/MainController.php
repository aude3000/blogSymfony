<?php

namespace TroisWA\MyFirstProject\WebSiteBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
//Symfony\Component\HttpFoundation\Response = NameSpace qui est contenu dans le dossier Vendor/symfony//symfony/src
//on ne reprend que la partie du chemin à partir du dossier src (exclu)

class MainController
{
    public function helloAction()
    {
        $response = new Response("Hello le chat !");
        // la methode "_construct() reçoit 3 paramètres optionnels --> "Hello le chat !" s'associe avec le paramètre "$content
        return $response;
    }
}
