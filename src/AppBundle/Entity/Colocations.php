<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colocations
 *
 * @ORM\Table(name="colocations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColocationsRepository")
 */
class Colocations
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
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255)
     */
    private $adresse;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="Ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_pers", type="integer")
     */
    private $nbPers;
	
	 /**
     * @var int
     *
     * @ORM\Column(name="Nb_chambre", type="integer")
     */
    private $nbChambre;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length = 255)
     */
    private $type;
	


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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Colocations
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
	
	/**
     * Set ville
     *
     * @return string
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }
	
	/**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }
	
	

    /**
     * Set nbPers
     *
     * @param integer $nbPers
     *
     * @return Colocations
     */
    public function setNbPers($nbPers)
    {
        $this->nbPers = $nbPers;

        return $this;
    }

    /**
     * Get nbPers
     *
     * @return int
     */
    public function getNbPers()
    {
        return $this->nbPers;
    }
	
	/**
     * Set nbChambre
     *
     * @param integer $nbChambre
     *
     * @return Colocations
     */
    public function setNbChambre($nbChambre)
    {
        $this->nbChambre = $nbChambre;

        return $this;
    }

    /**
     * Get nbChambre
     *
     * @return int
     */
    public function getNbChambre()
    {
        return $this->nbChambre;
    }
	
	/**
     * Set type
     *
     * @param integer $type
     *
     * @return Colocations
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return String
     */
    public function getType()
    {
        return $this->type;
    }
}

