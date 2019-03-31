<?php

namespace Esprit\TrocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@EspritTroc/Default/index.html.twig');
    }
}
