<?php

namespace Esprit\TrocBundle\Controller;


use Esprit\TrocBundle\Entity\Vente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Esprit\TrocBundle\Entity\Wishlist;
use Esprit\TrocBundle\Entity\Panier;


/**
 * Wishlist controller.
 *
 * @Route("wishlist")
 */
class WishlistController extends Controller
{
    /**
     * Lists all produit entities.
     *
     * @Route("/", name="wishlist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $wishlists = $em->getRepository('EspritTrocBundle:Wishlist')
            ->findBy(array('idUser' => $this->get('security.token_storage')->getToken()->getUser()));

        return $this->render('wishlist/index.html.twig', array(
            'wishlists' => $wishlists,
        ));
    }



    /**
     * Creates a new vente entity.
     *
     * @Route("/{id}/{idR}/addToPanier", name="panier_add1")
     * @Method({"GET", "POST"})
     */
    public function addToPanierAction(Request $request,Vente $produit,$idR)
    {
        $panier = new Panier();
        $em = $this->getDoctrine()->getManager();
        $panier->setIdProduit($produit);
        $user =$this->container->get('security.token_storage')->getToken()->getUser();
        $id_user = $user->getId();
        $currentUser=$this->getDoctrine()->getRepository(User::class)->find($id_user);
        $panier->setIdUser($currentUser);
        $em->persist($panier);
        $em->flush();
               // $e = $this->getDoctrine()->getManager();
                 $w=$em->getRepository('EspritTrocBundle:Wishlist')->find($idR);
                 
         $em->remove($w);
         $em->flush();

        return $this->redirectToRoute('wishlist_index');
    }

}
