<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Acteur;
use FilmBundle\Form\ActeurType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ActeurController extends Controller {

    /**
     * @Route("/acteur/ajout" ,name="ajout_act_route")
     */
    public function AjoutAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $acteur = new Acteur();
        $form = $this->createForm(ActeurType::class, $acteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($acteur);
            $em->flush();
            return $this->redirectToRoute('affich_act_route');
        }

        return $this->render('FilmBundle:Acteur:edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/acteurs" ,name="affich_act_route")
     */
    public function AfficheAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $acteurs = $em->getRepository('FilmBundle:Acteur')->findAll();
        return $this->render('FilmBundle:Acteur:affiche.html.twig', ['acts' => $acteurs]);
    }

    /**
     * @Route("/acteur/modif/{id}" ,name="modif_act_route")
     */
    public function ModifAction($id, Request $request) {
        $message = 'Modifier Acteur';
        $em = $this->getDoctrine()->getManager();
        $Acteur = $em->getRepository('FilmBundle:Acteur')->find($id);

        //synchronisation acteur/formulair
        $form = $this->createForm(ActeurType::class, $Acteur);
        //recuperer donnes
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em->flush();
                return $this->redirectToRoute('affich_act_route');
                $message = 'succes modif';
            }
        }
        return $this->render('FilmBundle:Acteur:edit.html.twig', ['form' => $form->createView(), 'msg' => $message]);
    }

    /**
     * @Route("/acteur/supp/{id}" ,name="supp_act_route")
     */
    public function SuppAction($id, Request $request) {

        $em = $this->getDoctrine()->getManager();
        $Acteur = $em->getRepository('FilmBundle:Acteur')->find($id);
        $em->remove($Acteur);
        $em->flush();
        return $this->redirectToRoute('affich_act_route');
    }

}
