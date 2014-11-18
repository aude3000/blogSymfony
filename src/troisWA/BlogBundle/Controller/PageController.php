<?php

namespace troisWA\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//Symfony\Component\HttpFoundation\Response = NameSpace qui est contenu dans le dossier Vendor/symfony//symfony/src
//on ne reprend que la partie du chemin à partir du dossier src (exclu)dossier src (exclu)

class PageController extends Controller
{
    public function indexAction()
    {
        $renderedView = $this->render('troisWABlogBundle:Page:home.html.twig');
        return $renderedView;
    }

    public function contactAction()
    {
        $renderedView = $this->render('troisWABlogBundle:Page:contact.html.twig');
        return $renderedView;
    }
}

