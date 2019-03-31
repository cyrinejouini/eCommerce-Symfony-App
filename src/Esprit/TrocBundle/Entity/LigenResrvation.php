<?php

namespace Esprit\TrocBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Esprit\TrocBundle\Entity;

/**
 * @ORM\Entity
 * @ORM\Table(name="lignereservation")
 */
class LigenResrvation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Esprit\TrocBundle\Entity\Event")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE" )
     */
    private $event;
    /**
     * @ORM\ManyToOne(targetEntity="Esprit\TrocBundle\Entity\Reservation")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $reservation;

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
    }

    /**
     * @var int
    * @ORM\Column(name="quantite",type="integer")

     */
    private $quantite;

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * @param mixed $reservation
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;
    }

}
