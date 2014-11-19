<?php

namespace troisWA\AdminBundle\Controller;

#Pour utiliser les services "Controller"
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PageController extends Controller
{
    /* fonction listAction() éducative
    public function listAction()
    {
        $response = new Response("Page liste d'articles");
        // la methode "_construct() reçoit 3 paramètres optionnels --> "Page liste d'articles" s'associe avec le paramètre "$content
        return $response;
    }
    */
    public function dashboardAction()
    {

        $entityRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('troisWABlogBundle:Article')
        ;

        // utilisation de $entityRepository car on fait un insert dans la BDD
        // la methode findAll() renvoie un tableau à 2 dimensions avec la liste des articles
        // $articlesList = $entityRepository->findAll();

        //utilisation de la fonction créée dans "ArticleRepository.php pour lister les articles par dates descendantes
        //$articlesList = $entityRepository->listByDateDesc();
        // utilisation de la methode findAll() pour pouvoir afficher la catégorie ajouté après
        $articlesList = $entityRepository->findAll();
        $renderedView = $this->render('troisWAAdminBundle:Page:dashboard.html.twig', array('articlesList' => $articlesList));
        return $renderedView;
    }
}

