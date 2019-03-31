<?php

namespace Esprit\TrocBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 * @ORM\Table(name="event")
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nom",type="string")
     *
     */


    private $nom;

    /**
     * @var string
     * @ORM\Column(name="description",type="string")
     *
     */
    private $description;


    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @ORM\Column(name="image" , nullable=true)
     *  @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */

    private $image;

    /**
     * @var \DateTime
     * @ORM\Column(name="date",type="date")
     */
    private $date;

    /**
     * @var int
     * @ORM\Column(name="nombreplace",type="integer")

     */
    private $nombreplace;
    /**
     * @var int
     * @ORM\Column(name="visibi",type="boolean")

     */
    private $visibi;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Event
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Event
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set nombreplace
     *
     * @param integer $nombreplace
     *
     * @return Event
     */
    public function setNombreplace($nombreplace)
    {
        $this->nombreplace = $nombreplace;

        return $this;
    }

    /**
     * Get nombreplace
     *
     * @return int
     */
    public function getNombreplace()
    {
        return $this->nombreplace;
    }

    /**
     * @return int
     */
    public function getVisibi()
    {
        return $this->visibi;
    }

    /**
     * @param int $visibi
     */
    public function setVisibi($visibi)
    {
        $this->visibi = $visibi;
    }

}

