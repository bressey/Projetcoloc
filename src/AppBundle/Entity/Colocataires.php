<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colocataires
 *
 * @ORM\Table(name="colocataires")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ColocatairesRepository")
 */
class Colocataires
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
     * @ORM\Column(name="Co_id", type="string", length=6, unique=true)
     */
    private $coId;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=30)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=30)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=1)
     */
    private $sexe;

    /**
     * @var int
     *
     * @ORM\Column(name="Compte", type="integer")
     */
    private $compte;

    /**
     * @var int
     *
     * @ORM\Column(name="Id_coloc", type="integer")
     */
    private $idColoc;


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
     * Set coId
     *
     * @param string $coId
     *
     * @return Colocataires
     */
    public function setCoId($coId)
    {
        $this->coId = $coId;

        return $this;
    }

    /**
     * Get coId
     *
     * @return string
     */
    public function getCoId()
    {
        return $this->coId;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Colocataires
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Colocataires
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Colocataires
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set compte
     *
     * @param integer $compte
     *
     * @return Colocataires
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return int
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set idColoc
     *
     * @param integer $idColoc
     *
     * @return Colocataires
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
}

