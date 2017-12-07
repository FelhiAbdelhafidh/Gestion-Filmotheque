<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Categorie;
use FilmBundle\Form\CategorieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller {

    /**
     * @Route("/categorie/ajout" ,name="ajout_cat_route")
     */
    public function AjoutAction(Request $request) {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('affich_cat_route');
        }

        return $this->render('FilmBundle:Categorie:ajout.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/categorie" ,name="affich_cat_route")
     */
    public function AfficheAction() {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('FilmBundle:Categorie')->findAll();
        return $this->render('FilmBundle:Categorie:affiche.html.twig', ['cats' => $categories]);
    }

    /**
     * @Route("/categorie/edit/{id}" ,name="edit_cat_route")
     */
    public function EditAction(Request $request,$id) {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();
        
        $categorie = $em->getRepository('FilmBundle:Categorie')->find($id);
        
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('affich_cat_route');
        }

        return $this->render('FilmBundle:Categorie:ajout.html.twig', ['form' => $form->createView()]);
    }
 /**
     * @Route("/categorie/supp/{id}" ,name="supp_cat_route")
     */
    public function SuppAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();
        $Acteur = $em->getRepository('FilmBundle:Categorie')->find($id);
        $em->remove($Acteur);
        $em->flush();
        return $this->redirectToRoute('affich_cat_route');
    }
}
