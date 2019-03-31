<?php
/**
 * Created by PhpStorm.
 * User: fadhel
 * Date: 30/11/2018
 * Time: 02:54
 */

namespace Esprit\TrocBundle\Controller;
use AppBundle\Entity\User;
use Esprit\TrocBundle\Entity\Echange;
use Esprit\TrocBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class VoteController extends Controller
{
    public function AddVoteAction(Request $request){

        $vote = new Vote();


        $user =$this->container->get('security.token_storage')->getToken()->getUser();
        $id_user= $user->getId();
        $currentUser=$this->getDoctrine()->getRepository(User::class)->find($id_user);
        $echInfos = $this->getDoctrine()->getRepository(Echange::class)->find($request->get('id'));
        $voteInfos = $this->getDoctrine()->getRepository(Vote::class)->findOneBy(array('idEchange'=>$request->get('id'),'idUser'=>$id_user));
        if($request ->getMethod() =="POST"){
            if (null!=$voteInfos){
                $vote=$voteInfos;
            }
            if(null!=$id_user && null!=$echInfos){
                $vote->setVote($request->get('vote'));
                $vote->setIdEchange($echInfos);
                $vote->setIdUser($currentUser);

                $em = $this->getDoctrine()->getManager();
                $em->persist($vote);
                $em->flush();
            }
        }
        return new Response($request->get('vote'));


    }


}