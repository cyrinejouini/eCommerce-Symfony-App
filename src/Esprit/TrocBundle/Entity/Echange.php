<?php

namespace Esprit\TrocBundle\Entity;

use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Echange
 *
 * @ORM\Table(name="echange", indexes={@ORM\Index(name="FK_Echange_id_categorie_afficher", columns={"id_categorie_afficher"})})
 * @ORM\Entity(repositoryClass="Esprit\TrocBundle\Repository\EchangeRepository")
 */
class Echange
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout", type="date")
     */
    private $dateAjout;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_afficher", type="string", length=255)
     */
    private $titreAfficher;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_demande", type="string", length=255)
     */
    private $titreDemande;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categorie_afficher", referencedColumnName="id")
     * })
     */
    private $categorieAfficher;

    /**
     * @var string
     *
     * @ORM\Column(name="Emplacement", type="string", length=255)
     */
    private $emplacement;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $photo;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_annonceur", referencedColumnName="id")
     * })
     */
    private $idAnnonceur;


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
     * Set dateAjout
     *
     * @param \DateTime $dateAjout
     *
     * @return Echange
     */
    public function setDateAjout($dateAjout)
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * Get dateAjout
     *
     * @return \DateTime
     */
    public function getDateAjout()
    {
        return $this->dateAjout;
    }

    /**
     * Set titreAfficher
     *
     * @param string $titreAfficher
     *
     * @return Echange
     */
    public function setTitreAfficher($titreAfficher)
    {
        $this->titreAfficher = $titreAfficher;

        return $this;
    }

    /**
     * Get titreAfficher
     *
     * @return string
     */
    public function getTitreAfficher()
    {
        return $this->titreAfficher;
    }

    /**
     * Set titreDemande
     *
     * @param string $titreDemande
     *
     * @return Echange
     */
    public function setTitreDemande($titreDemande)
    {
        $this->titreDemande = $titreDemande;

        return $this;
    }

    /**
     * Get titreDemande
     *
     * @return string
     */
    public function getTitreDemande()
    {
        return $this->titreDemande;
    }

    /**
     * Set categorieAfficher
     *
     * @param string $categorieAfficher
     *
     * @return Echange
     */
    public function setCategorieAfficher($categorieAfficher)
    {
        $this->categorieAfficher = $categorieAfficher;

        return $this;
    }

    /**
     * Get categorieAfficher
     *
     * @return string
     */
    public function getCategorieAfficher()
    {
        return $this->categorieAfficher;
    }


    /**
     * Set emplacement
     *
     * @param string $emplacement
     *
     * @return Echange
     */
    public function setEmplacement($emplacement)
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * Get emplacement
     *
     * @return string
     */
    public function getEmplacement()
    {
        return $this->emplacement;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Echange
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
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * Set idAnnonceur
     *
     * @param integer $idAnnonceur
     *
     * @return Echange
     */
    public function setIdUser($idAnnonceur)
    {
        $this->idAnnonceur = $idAnnonceur;

        return $this;
    }

    /**
     * Get idAnnonceur
     *
     * @return int
     */
    public function getIdAnnonceur()
    {
        return $this->idAnnonceur;
    }


}

