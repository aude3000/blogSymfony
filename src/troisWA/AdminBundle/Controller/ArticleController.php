<?php

namespace troisWA\AdminBundle\Controller;

// pour utiliser les services "Controller" :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// pour hériter des classes créées dans BlogBundle :
use troisWA\BlogBundle\Form\ArticleType;
use troisWA\BlogBundle\Entity\Article;

class ArticleController extends Controller
{
    public function addAction(Request $request)
    {
        // appel du service Doctrine
        $doctrine = $this->getDoctrine();
        // ou "$doctrine = $this->get('doctrine')" en écriture longue

        // $doctrine permet de faire appel au service entityManager
        // c'est le service entityManager qui permet d'enregistrer dans la base de données
        $entityManager = $doctrine->getManager();
        // $entityManager permet d'aller chercher le repository (l'équivalent du "articleManager" en php) qui permettra de manipuler dans la base de données
        $entityRepository = $entityManager->getRepository("troisWABlogBundle:Article");
        // Puis on va chercher le service 'form.factory' (service factory de form) pour créer un formulaire
        $formFactory = $this->get('form.factory');
        // et on applique la méthode "create" à cet objet $formFactory pour créer un formulaire
        // ArticleType() est le modèle du formulaire pour lequel il faut ajouter un "use" approprié (là : "troisWA\BlogBundle\Form\ArticleType"
        // Article est le modèle d'origine pour lequel il faut ajouter un "use" approprié (là "troisWA\BlogBundle\Entity\Article')
        // création juste de l'objet, du squelette du formulaire
        // création d'un article vide (= sans valeur à par la date qui est chargée automatiquement)
        //repmlissage automatique de $articleObject par "bidding"
        $articleObject = new Article();
        //print_r($articleObject);
        $form = $formFactory->create(new ArticleType(), $articleObject);
        //print_r($form);
        // intégration dans le "squelette" $form du HTML pour créer la vue
        $formArticle = $form->createView();
        // le $request contient le tableau $_POST qui reçoit des éléments quand click sur le bouton "save" du formulaire
        // si tout est OK on l'envoie dans le repository $entityRepository
        if($form->handleRequest($request)->isValid() === true)
        {
            //print_r($articleObject);
            // la methode persist fait que $entityManager va à partir de là être gérée par Doctrine (c'est ce qui permet que Doctrine surveille cet objet) : la requete n'est pas encore exécutée
            //ça veut dire :
            /* Garde cette entité en mémoire, tu l'enregistreras au prochain flush()*/
            $entityManager->persist($articleObject);
            //la methode flush() dit à Doctrine d'exécuter effectivement la requette pour sauvegarder les entités qu'on lui a dit de persister juste avant
            //ça veut dire :
            /*Ouvre une transaction et enregistre toutes les entités qui t'ont été données depuis le dernier flush(). */
            $entityManager->flush();
            //Pour transformer le string tout en majuscule
            $articleObject->setArticleTitle(strtoupper($articleObject->getArticleTitle()));

        }

        // puis on crée l'objet $renderedView pour la construction du formulaire ET la restitution du formulaire
        $renderedView = $this->render('troisWAAdminBundle:Article:form.html.twig', array(
            "articleForm"=>$formArticle
        ));
        // le retour à envoyer au kernel qui l'envoie au client
        return $renderedView;
    }

    public function deleteAction($articleId)
    {
        // EntityManager gère : ajout, modification, suppression dans la BDD
        //EntityRepository gère : sélection ("select") dans la BDD

        // appel au service Doctrine puis au service EntityManager
        $entityManager = $this
            ->getDoctrine()
            ->getManager();

        // on fait une requete EntityRepository car "select"
        // appel au service EntityRepository
        $entityRepository = $entityManager->getRepository('troisWABlogBundle:Article');
        // récupération de l'article d'Id "articleId" dans l'objet $articleObject à partir du repository ((donc à l'aide de Doctrine, donc implicitement surveillé par Doctrine)
        $articleObject = $entityRepository->find($articleId);
        //print_r($articleObject);
        // tester l'existance de l'article d'Id articleId
        if(!$articleObject)
        {
            // envoyer (= lancer) une erreur (aussi nommée "exception") avec la fonction "throw" qui peut être couplé avec la fonction catch" et générer avec "createNotFoundException"une erreur 404 qui est envoyé au client et pour laquelle il faut fiare une mise en forme en environnement de production
            throw $this->createNotFoundException("l'article n° " . $articleId . " n'est pas disponible dans la base de sonnées.");
        }

        //récupérer l'entityManager (car action de suppression) et lui appliquer la methode "remove" pour indiquer à Doctrine que je souhaite supprimer cet entrée
        $entityManager->remove($articleObject);
        //Pas besoin d'utiliser la methode "persist" pour l'objet $articleObject car déjà surveillé par Doctrine
        //execution effective de la requete avec la methode flush()
        $entityManager->flush();
        //puis rediriger vers la liste des articles
        return $this->redirect($this->generateUrl('twa_bb_articles'));
}
}