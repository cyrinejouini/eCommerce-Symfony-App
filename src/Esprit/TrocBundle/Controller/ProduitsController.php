<?php

namespace Esprit\TrocBundle\Controller;

use Esprit\TrocBundle\Entity\Produits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Esprit\TrocBundle\Entity\Wishlist;

use Esprit\TrocBundle\Entity\Panier;

/**
 * Produit controller.
 *
 * @Route("produits")
 */
class ProduitsController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="produits_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('EspritTrocBundle:Produits')->findAll();

        return $this->render('produits/index.html.twig', array(
            'produits' => $produits,
        ));
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/new", name="produits_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produit = new Produits();
        $form = $this->createForm('Esprit\TrocBundle\Form\ProduitsType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produits_show', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('produits/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{idProduit}", name="produits_show")
     * @Method("GET")
     */
    public function showAction(Produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produits/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{idProduit}/edit", name="produits_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produits $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('Esprit\TrocBundle\Form\ProduitsType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produits_edit', array('idProduit' => $produit->getIdproduit()));
        }

        return $this->render('produits/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     * @Route("/{idProduit}", name="produits_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produits $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produits_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produits $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produits $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produits_delete', array('idProduit' => $produit->getIdproduit())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Creates a new produit entity.
     *
     * @Route("/{idProduit}/addToWishlist", name="wishlist_add")
     * @Method({"GET", "POST"})
     */
    public function addToWishlistAction(Request $request,Produits $produit)
    {
        $wishlist = new Wishlist();
        $em = $this->getDoctrine()->getManager();
        $wishlist->setIdProduit($produit);
        $wishlist->setIdUser($this->get('security.token_storage')->getToken()->getUser());
            $em->persist($wishlist);
            $em->flush();

        return $this->redirectToRoute('produits_index');
    }

    /**
     * Creates a new produit entity.
     *
     * @Route("/{idProduit}/addToPanier", name="panier_add")
     * @Method({"GET", "POST"})
     */
    public function addToPanierAction(Request $request,Produits $produit)
    {
        $panier = new Panier();
        $em = $this->getDoctrine()->getManager();
        $panier->setIdProduit($produit);
        $panier->setIdUser($this->get('security.token_storage')->getToken()->getUser());
        $em->persist($panier);
        $em->flush();

        return $this->redirectToRoute('produits_index');
    }


}
