<?php

namespace Esprit\TrocBundle\Controller;

use AppBundle\Entity\User;
use ClassesWithParents\E;
use Esprit\TrocBundle\Entity\Reservation;
use Esprit\TrocBundle\Entity\LigenResrvation;
use Esprit\TrocBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SwiftmailerBundle;

class ReservationController extends Controller
{

    public function annulAllAction($id)
    {


        $em = $this->getDoctrine()->getManager();
        $lreservations = new LigenResrvation();
        $lreservations = $em->getRepository('EspritTrocBundle:LigenResrvation')->find($id);
        $q = $lreservations->getQuantite();
        $id = $lreservations->getEvent()->getId();
        $event = $em->getRepository('EspritTrocBundle:Event')->find($id);
        $n = $event->getNombreplace() + $q;
        $event->setNombreplace($n);
        $em->remove($lreservations);
        $event->setVisibi(true);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('reservation_indexuser');

    }

    public function annuloneAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $lreservations = new LigenResrvation();

        $event = new Event();
        $event->setVisibi(true);
        $lreservations = $em->getRepository('EspritTrocBundle:LigenResrvation')->find($id);
        if($lreservations->getQuantite() == 1){
            $id = $lreservations->getEvent()->getId();
            $event = $em->getRepository('EspritTrocBundle:Event')->find($id);


            $n = $event->getNombreplace() + 1;
            $event->setNombreplace($n);
          $em->remove($lreservations);
            $event->setVisibi(true);
            $this->getDoctrine()->getManager()->flush();
        }else {
            $q = $lreservations->getQuantite() - 1;
            $lreservations->setQuantite($q);
            $id = $lreservations->getEvent()->getId();
            $event = $em->getRepository('EspritTrocBundle:Event')->find($id);
            $n = $event->getNombreplace() + 1;
            $event->setVisibi(true);
            $event->setNombreplace($n);
            $this->getDoctrine()->getManager()->flush();
        }
        //var_dump($id);
        return $this->redirectToRoute('reservation_indexuser');

    }


    public function indexuserAction()
    {

        $user =$this->getUser();
        if($user) {
            $em = $this->getDoctrine()->getManager();

            $reservations = $em->getRepository('EspritTrocBundle:Reservation')->findOneBy(array('user' => $user));
            $lreservations = $em->getRepository('EspritTrocBundle:LigenResrvation')->findBy(array('reservation' => $reservations));

            return $this->render('reservation/indexuser.html.twig', array(
                'reservations' => $lreservations,
            ));
        }else {
            return $this->redirectToRoute('fos_user_security_login');

        }
    }
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('EspritTrocBundle:Event')->find($id);
        $Lreservations = $em->getRepository('EspritTrocBundle:LigenResrvation')->findBy(array('event'=>$event));

        return $this->render('reservation/index.html.twig', array(
            'reservations' => $Lreservations,
        ));
    }

    public function newAction($id)
    {


        $event = new Event();
        $em = $this->getDoctrine()->getManager();
        $user =$this->getUser();
        $event = $em->getRepository('EspritTrocBundle:Event')->find($id);
        if($user) {
            $res = $em->getRepository('EspritTrocBundle:Reservation')->findOneBy(array('user' => $user));
            if ($res) {
                $ligres = new LigenResrvation();
                $ligres = $em->getRepository('EspritTrocBundle:LigenResrvation')->findOneBy(array('reservation' => $res , 'event'=>$event));
    if ($ligres) {
        $q = $ligres->getQuantite() + 1;
        $ligres->setQuantite($q);
        $ligres->setReservation($res);
        $n = $event->getNombreplace() - 1;
        $event->setNombreplace($n);
        if($n == 0){
            $event->setVisibi(false);
        }
        $this->getDoctrine()->getManager()->flush();
    } else {
      //var_dump($event);

        $ligres = new LigenResrvation();
        $ligres->setEvent($event);
        $ligres->setQuantite(1);
        $ligres->setReservation($res);
        $em->persist($ligres);
        $n = $event->getNombreplace() - 1;
        $event->setNombreplace($n);
        if($n == 0){
            $event->setVisibi(false);
        }
        $this->getDoctrine()->getManager()->flush();
        $em->flush();
    }
            } else {
                $reservation = new Reservation();
                $reservation->setUser($user);
                    $em->persist($reservation);
                    $em->flush();
                $ligres = new LigenResrvation();
                $ligres->setEvent($event);
                $ligres->setReservation($res);

                $ligres->setQuantite(1);
                $em->persist($ligres);
                $em->flush();
                $n = $event->getNombreplace() - 1 ;
                $event->setNombreplace($n);
                if($n == 0){
                    $event->setVisibi(false);
                }
                $this->getDoctrine()->getManager()->flush();
            }
        }
        else{
            return $this->redirectToRoute('fos_user_security_login');
        }
        return $this->sendMailAction($user);
    }


    public function showAction(Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);

        return $this->render('reservation/show.html.twig', array(
            'reservation' => $reservation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction(Request $request, Reservation $reservation)
    {
        $deleteForm = $this->createDeleteForm($reservation);
        $editForm = $this->createForm('Esprit\TrocBundle\Form\ReservationType', $reservation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_edit', array('id' => $reservation->getId()));
        }

        return $this->render('reservation/edit.html.twig', array(
            'reservation' => $reservation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function deleteAction(Request $request, Reservation $reservation)
    {
        $form = $this->createDeleteForm($reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reservation);
            $em->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }

    private function createDeleteForm(Reservation $reservation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reservation_delete', array('id' => $reservation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function sendMailAction($user)
    {


            $Subject = "Reservation TrocEvent";
            $email = $user->getEmail();
            $message = "Merci pour votre confiance et votre reservation est  enregistrée avec succée";

            $mailer = $this->container->get('mailer');
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 597 , 'ssl')
                ->setUsername('cyrine.jouini@esprit.tn')
                ->setPassword('sirine.jouini4');
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance('Test')
                ->setSubject($Subject)
                ->setFrom('cyrine.jouini@esprit.tn')
                ->setTo($email)
                ->setBody($message);
            $this->get('mailer')->send($message);
        return $this->redirectToRoute('reservation_indexuser');
    }
}
