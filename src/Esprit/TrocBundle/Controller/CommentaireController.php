<?php
/**
 * Created by PhpStorm.
 * User: fadhel
 * Date: 30/11/2018
 * Time: 01:00
 */

namespace Esprit\TrocBundle\Controller;

use AppBundle\Entity\User;
use Esprit\TrocBundle\Entity\Commentaire;
use Esprit\TrocBundle\Entity\Echange;
use Esprit\TrocBundle\Entity\Vote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;



class CommentaireController extends Controller
{
    public function AddCommentaireAction($param,$c,$v){

        $vote = new Vote();
        $commentaire = new Commentaire();



        $user =$this->container->get('security.token_storage')->getToken()->getUser();
        $id_user= $user->getId();
        $currentUser=$this->getDoctrine()->getRepository(User::class)->find($id_user);
        $echangeInfos = $this->getDoctrine()->getRepository(Echange::class)->find($param);
        $voteInfos = $this->getDoctrine()->getRepository(Vote::class)->findOneBy(array('idEchange'=>$param,'idUser'=>$currentUser));

        if(null!=$id_user && null!=$echangeInfos ){

            if ($currentUser == $echangeInfos->getIdAnnonceur() && $v !='0'  ){

                $this->get('session')->getFlashBag()->add('notice','vous ne pouvez pas voter ta propre annonce !');

            }
            else{
                if (null!=$voteInfos){
                    $vote=$voteInfos;
                }

                $vote->setVote($v);



                $vote->setIdEchange($echangeInfos);
                $vote->setIdUser($echangeInfos->getIdAnnonceur());

                $em1 = $this->getDoctrine()->getManager();
                $em1->persist($vote);
                $em1->flush();


            }


                $commentaire->setContenu($c);
                $commentaire->setDate(new \DateTime());
                $commentaire->setIdEchange($echangeInfos);
                $commentaire->setIdUser($currentUser);

                $em = $this->getDoctrine()->getManager();
                $em->persist($commentaire);
                $em->flush();

            return $this->redirectToRoute( 'echange_by_id',array('id'=>$param));



        }
        else{
                $this->get('session')->getFlashBag()->add('notice','vous avez deja commente sur cette article ! ');
        }
        return $this->redirectToRoute( 'echange_by_id',array('id'=>$param));
    }

}