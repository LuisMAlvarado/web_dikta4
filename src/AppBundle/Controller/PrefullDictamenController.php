<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PrefullDictamen;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Prefulldictaman controller.
 *
 * @Route("prefulldictamen")
 */
class PrefullDictamenController extends Controller
{
    /**
     * Lists all prefullDictaman entities.
     *
     * @Route("/", name="prefulldictamen_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prefullDictamenes = $em->getRepository('AppBundle:PrefullDictamen')->findAll();

        return $this->render('prefulldictamen/index.html.twig', array(
            'prefullDictamenes' => $prefullDictamenes,
        ));
    }

    /**
     * Creates a new prefullDictamen entity.
     *
     * @Route("/new", name="prefulldictamen_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $prefullDictamen = new Prefulldictamen();
        $form = $this->createForm('AppBundle\Form\PrefullDictamenType', $prefullDictamen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($prefullDictamen);
            $em->flush();

            return $this->redirectToRoute('prefulldictamen_show', array('id' => $prefullDictamen->getId()));
        }

        return $this->render('prefulldictamen/new.html.twig', array(
            'prefullDictaman' => $prefullDictamen,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a prefullDictaman entity.
     *
     * @Route("/{id}", name="prefulldictamen_show")
     * @Method("GET")
     */
    public function showAction(PrefullDictamen $prefullDictamen)
    {
        $deleteForm = $this->createDeleteForm($prefullDictamen);

        return $this->render('prefulldictamen/show.html.twig', array(
            'prefullDictamen' => $prefullDictamen,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing prefullDictaman entity.
     *
     * @Route("/{id}/edit", name="prefulldictamen_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PrefullDictamen $prefullDictamen)
    {
        $deleteForm = $this->createDeleteForm($prefullDictamen);
        $editForm = $this->createForm('AppBundle\Form\PrefullDictamenType', $prefullDictamen);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prefulldictamen_show', array('id' => $prefullDictamen->getId()));
           // return $this->redirectToRoute('prefulldictamen_edit', array('id' => $prefullDictaman->getId()));
        }

        return $this->render('prefulldictamen/edit.html.twig', array(
            'prefullDictamen' => $prefullDictamen,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a prefullDictaman entity.
     *
     * @Route("/{id}", name="prefulldictamen_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PrefullDictamen $prefullDictaman)
    {
        $form = $this->createDeleteForm($prefullDictaman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prefullDictaman);
            $em->flush();
        }

        return $this->redirectToRoute('prefulldictamen_index');
    }

    /**
     * Creates a form to delete a prefullDictaman entity.
     *
     * @param PrefullDictamen $prefullDictaman The prefullDictaman entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PrefullDictamen $prefullDictaman)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prefulldictamen_delete', array('id' => $prefullDictaman->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
