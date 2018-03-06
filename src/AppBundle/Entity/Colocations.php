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
     * @var int
     *
     * @ORM\Column(name="Id_coloc", type="integer", unique=true)
     */
    private $idColoc;

    /**
     * @var string
     *
     * @ORM\Column(name="Adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var int
     *
     * @ORM\Column(name="Nb_pers", type="integer")
     */
    private $nbPers;


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
     * Set idColoc
     *
     * @param integer $idColoc
     *
     * @return Colocations
     */
    public function setIdColoc($idColoc)
    {
        $this->idColoc = $idColoc;

        return $this;
    }

    /**
     * Get idColoc
     *
     * @return int
     */
    public function getIdColoc()
    {
        return $this->idColoc;
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
}

