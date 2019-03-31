<?php

namespace Esprit\TrocBundle\Controller;
use Esprit\TrocBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class NotificationController extends Controller
{
    function AllNotificationJsonAction(Request $request){
        $output = [];
        $plein_text = $request->get('plein_text');
        $repository = $this->getDoctrine()->getRepository(Notification::class);
        $results=$repository->createQueryBuilder('a')
            ->where("a.idUser = '$plein_text'")
            ->getQuery()->getArrayResult();

        if($results!= null || !empty($results)){
            foreach ($results as $notif){
               $o = '<li> <a href="#">
                    <strong>'.$notif["subject"].'</strong><br />
                    <small><em>'.$notif["text"].'</em></small></a></li><li class="divider"></li>';
                array_push($output , $o);



            }
        }
        else{
            $output = '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
        }
        $count = $repository->createQueryBuilder('v')
            ->where("v.status = '0'")
            ->andWhere("v.idUser ='$plein_text'")
            ->select('count(v.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        return new JsonResponse($data);
    }

    function UpdateNotificationJsonAction(Request $request){

        $notifInf = $this->getDoctrine()->getRepository(Notification::class)->findAll();
        foreach ($notifInf as $notif){
            $notif->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();
        }
        return new JsonResponse("update");

    }


}