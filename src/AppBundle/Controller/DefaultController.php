<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('base_admin.html.twig');

        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            return $this->render( 'base.html.twig');
        }
        else {
            return $this->render( 'base.html.twig');
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/", name="admin_page")
     */
    public function adminPageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render( 'base_admin.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/", name="client_page")
     */
    public function clientPageAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render( 'base_admin.html.twig');
    }

    /**
     * @Route("/user", name="user_info")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showUserAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('base_admin.html.twig');

        }
        if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            // replace this example code with whatever you need
            return $this->render('base.html.twig');
        }
    }
}
