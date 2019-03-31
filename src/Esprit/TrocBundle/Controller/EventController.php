<?php

namespace Esprit\TrocBundle\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Esprit\TrocBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class EventController extends Controller
{

    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
        //$defaultData = array();
       // $form = $this->createFormBuilder($defaultData)
          //  ->add('id', IntegerType::class)
          //  ->add('Rechercher', SubmitType::class)
         //   ->getForm();
       // $form->handleRequest($request);
       // if ($form->isValid()) {
          //  $data = $form->getData();
          //  $em = $this->getDoctrine()->getManager();

          //  $events = $em->getRepository('EspritTrocBundle:Event')->find($data);

          //  return $this->render('event/index.html.twig', array(
          //      'events' => $events,
       // }else{
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('EspritTrocBundle:Event')->findAll();

        return $this->render('event/index.html.twig', array(
            'events' => $events,
        ));
    }else{
            return $this->render( 'base.html.twig');
        }
    }
    public function indexfrontAction()
    {
        $em = $this->getDoctrine()->getManager();
             $vi = true;
        $events = $em->getRepository('EspritTrocBundle:Event')->findAll();

        return $this->render('event/indexfront.html.twig', array(
            'events' => $events,
        ));
    }

    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm('Esprit\TrocBundle\Form\EventType', $event);
        $form->handleRequest($request);
        $datetime = new \DateTime("now");

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

           if(( $event->getNombreplace()>0)&&($event->getDate()>$datetime)){
            $event->setVisibi(true);
            $file = $event->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $event->setImage($fileName);
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_index');
        }
        }

        return $this->render('event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }

    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event);

        return $this->render('event/show.html.twig', array(
            'event' => $event,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $datetime = new \DateTime("now");
        $event =  $em->getRepository('EspritTrocBundle:Event')->find($id);
        $image =$event->getImage();
        $editForm = $this->createForm('Esprit\TrocBundle\Form\EventTypeeedit', $event);
        $editForm->handleRequest($request);
        if(( $event->getNombreplace()>0)&&($event->getDate()>$datetime)){
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $event->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $fileName);
            $event->setImage($fileName);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }}

        return $this->render('event/edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView()

        ));
    }


    public function deleteAction($id)
    {
            $em = $this->getDoctrine()->getManager();
             $event = $em->getRepository('EspritTrocBundle:Event')->find($id);
            $em->remove($event);
            $em->flush();
        return $this->redirectToRoute('event_index');
    }


}
