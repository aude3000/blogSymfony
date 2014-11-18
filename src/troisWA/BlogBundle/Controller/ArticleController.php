<?php

namespace troisWA\BlogBundle\Controller;

// use éducatif :
// use Symfony\Component\HttpFoundation\Response;
//Symfony\Component\HttpFoundation\Response = NameSpace qui est contenu dans le dossier Vendor/symfony//symfony/src
//on ne reprend que la partie du chemin à partir du dossier src (exclu)

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use troisWA\BlogBundle\Form\ArticleType;
use troisWA\BlogBundle\Entity\Article;

//Symfony\Component\HttpFoundation\Request = NameSpace qui est contenu dans le dossier Vendor/symfony//symfony/src
//on ne reprend que la partie du chemin à partir du dossier src (exclu)

class ArticleController extends Controller
{
    /* fonction listAction() éducative
    public function listAction()
    {
        $response = new Response("Page liste d'articles");
        // la methode "_construct() reçoit 3 paramètres optionnels --> "Page liste d'articles" s'associe avec le paramètre "$content
        return $response;
    }
    */
    public function listAction()
    {
        /* Cas tableau d'articles vide */
        //$articlesList = [];


        /* éducatif
        $articlesList =
            [
               0 => [
                   "articleId" => 24,
                   "titre" => "les loons de google",
                   "contenu" => "Google vient de dévoiler son tout dernier projet de recherche et développement, qui consiste à fournir un accès Internet dans les endroits mal ou non desservis, en s’appuyant sur un réseau de ballons naviguant en haute altitude.Google vient de dévoiler son tout dernier projet de recherche et développement, qui consiste à fournir un accès Internet dans les endroits mal ou non desservis, en s’appuyant sur un réseau de ballons naviguant en haute altitude."
               ],
            1 =>[
                "articleId" => 28,
                "titre" => "3WA",
                "contenu" => "la 3WA se développe autant géographiquement qu'en diversification de ses offres de formation"
               ],
                2 => [
                "articleId" => 35,
                "titre" => 'la vague',
                "contenu" => "La Vague (Die Welle) est un film allemand réalisé par Dennis Gansel en 2008 et très librement inspiré de - La Troisième Vague -, étude expérimentale d'un régime autocratique, menée par le professeur d’histoire Ron Jones avec des élèves de première du lycée Cubberley à Palo Alto (Californie) pendant la première semaine d’avril 1967."
            ],
       ];
        */
        $entityRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('troisWABlogBundle:Article')
        ;

        // utilisation de $entityRepository car on fait un insert dans la BDD
        // la methode findAll() renvoie un tableau à 2 dimensions avec la liste des articles
       // $articlesList = $entityRepository->findAll();

        //utilisation de la fonction créée dans "ArticleRepository.php pour lister les articles par dates descendantes
        $articlesList = $entityRepository->listByDateDesc();

        $renderedView = $this->render('troisWABlogBundle:Article:listeArticles.html.twig', array('articlesList' => $articlesList));
        return $renderedView;
    }

    /* fonction showAction() éducative
    public function showAction($articleId)
    {
        //$response = new Response("Page de l' article : " . $articleId);

        $response = new Response("<html><body><h1>Article : " . $articleId . "</h1></body></html>");
        // le fait d'utiliser la balise fermante </body> fait apparaitre le "profiler" en bas de l'écran : barre d'outils (développée en javascript)
        // voir http://symfony.com/fr/doc/current/cookbook/testing/profiling.html pour s'approprier cet outil profiler
        // la methode "_construct() reçoit 3 paramètres optionnels --> "Page d'un article" s'associe avec le paramètre "$content
       //return $response;
    }
    */
    public function showAction($articleId)
    {

        $entityRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('troisWABlogBundle:Article')
        ;
        // ce chainage de fonction ci-dessus correspond presque à l'instruction "$entityRepository = new ArticleRepository()
        // création d'un fonction de façon dynamique
        $articleObject = $entityRepository->findOneByArticleId($articleId);
        //print_r($articleObject);

        // Vérifier si l'article d'Id $articleId existe
        //if(is_null($articleObject) (autre écriture pour le "if"
        if(!$articleObject)
        {throw $this->createNotFoundException("l'article n° " . $articleId . " demandé n'est pas disponible.");
        }

        //la fonction "render" a pour objectif d'aller récupérer des view, donc on n'a pas besoin de préciser le dossier "view" dans "troisWABlogBundle"
        //"Article" correspond au dossier "Article" dans "view"
        //"article.html.twig" est le fichier qui contient le code html à afficher
        // on veut afficher l'article créé
        //on fait un chainage de fonctions car toutes s'applique à la variable "$entityRepository" objet de type ArticleRepository

        //pour extraire l'Id de l'article
        //$renderedView = $this->render('troisWABlogBundle:Article:article.html.twig', array('articleId' => $articleId));

        //pour extraire l'article
        $renderedView = $this->render('troisWABlogBundle:Article:article.html.twig', array(
            'article' => $articleObject));

        return $renderedView;




    }





}

