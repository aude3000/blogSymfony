<?php

namespace troisWA\AdminBundle\Controller;

// pour utiliser les services "Controller" :
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// pour hériter des classes créées dans BlogBundle :
use troisWA\BlogBundle\Form\CategoryType;
use troisWA\BlogBundle\Entity\Category;

class CategoryController extends Controller
{
    public function listAction()
    {
        $entityRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('troisWABlogBundle:Category')
        ;

        $categoriesList = $entityRepository->findAll();

        $renderedView = $this->render('troisWAAdminBundle:category:categories.html.twig', array(
            'categoriesList' => $categoriesList
        ));

        return $renderedView;
    }

    public function addAction(Request $request)
    {
        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $categoryObject = new Category();
        $categoryForm = new CategoryType();

        $formObject = $this
            ->get('form.factory')
            ->create($categoryForm, $categoryObject)
        ;

        if ($formObject->handleRequest($request)->isValid())
        {
            $entityManager->persist($categoryObject);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('twa_ab_category_add'));
        }

        $formView = $formObject->createView();

        $renderedView = $this->render('troisWAAdminBundle:category:form.html.twig', array(
            'categoryForm' => $formView
        ));

        return $renderedView;
    }

    public function editAction($categoryId, Request $request)
    {
        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $entityRepository = $entityManager->getRepository('troisWABlogBundle:Category');

        $categoryObject = $entityRepository->find($categoryId);

        if (!$categoryObject)
        {
            throw $this->createNotFoundException('Non trouvé: id=' . $categoryId . '.');
        }

        $categoryForm = new CategoryType();

        $formObject = $this
            ->get('form.factory')
            ->create($categoryForm, $categoryObject);

        if ($formObject->handleRequest($request)->isValid())
        {
            $entityManager->persist($categoryObject);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('twa_ab_category_edit'));
        }

        $formView = $formObject->createView();

        $renderedView = $this->render('troisWAAdminBundle:category:form.html.twig', array(
            'categoryForm' => $formView
        ));

        return $renderedView;
    }

    public function deleteAction($categoryId)
    {
        $entityManager = $this
            ->getDoctrine()
            ->getManager()
        ;

        $entityRepository = $entityManager->getRepository('troisWABlogBundle:Category');

        $categoryObject = $entityRepository->find($categoryId);

        if (!$categoryObject)
        {
            throw $this->createNotFoundException('Non trouvé: id=' . $categoryId . '.');
        }

        $entityManager->remove($categoryObject);
        $entityManager->flush();

        return $this->redirect($this->generateUrl('twa_ab_categories'));
    }
}