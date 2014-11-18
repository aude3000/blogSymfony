<?php

namespace troisWA\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
//Symfony\Component\HttpFoundation\Response = NameSpace qui est contenu dans le dossier Vendor/symfony//symfony/src
//on ne reprend que la partie du chemin à partir du dossier src (exclu)

class PageController
{
    public function indexAction()
    {
        $response = new Response("Page d'accueil");
        // la methode "_construct() reçoit 3 paramètres optionnels --> "Page d'accueil" s'associe avec le paramètre "$content
        return $response;
    }
}

