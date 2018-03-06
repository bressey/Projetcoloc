<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActiviteRepository")
 */
class Activite
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
     * @ORM\Column(name="Id_pers_prop", type="string", length=6)
     */
    private $idPersProp;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=4000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=40)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_coloc", type="integer")
     */
    private $idColoc;

    /**
     * @var int
     *
     * @ORM\Column(name="Cout", type="integer")
     */
    private $cout;

    /**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=20)
     */
    private $statut;


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
     * Set idPersProp
     *
     * @param string $idPersProp
     *
     * @return Activite
     */
    public function setIdPersProp($idPersProp)
    {
        $this->idPersProp = $idPersProp;

        return $this;
    }

    /**
     * Get idPersProp
     *
     * @return string
     */
    public function getIdPersProp()
    {
        return $this->idPersProp;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Activite
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Activite
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
     * Set idColoc
     *
     * @param integer $idColoc
     *
     * @return Activite
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
     * Set cout
     *
     * @param integer $cout
     *
     * @return Activite
     */
    public function setCout($cout)
    {
        $this->cout = $cout;

        return $this;
    }

    /**
     * Get cout
     *
     * @return int
     */
    public function getCout()
    {
        return $this->cout;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Activite
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }
}

