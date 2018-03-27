<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Colocataires;
use AppBundle\Entity\Colocations;
use Doctrine\ORM\Mapping as ORM;


/**
 * Demande
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DemandeRepository")
 */
class Demande
{
	 /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	 
	/**
     * @var Colocataires
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Colocataires")
	 * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Colocations
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Colocations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $colocation;
	
	 /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=10)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255)
     */
    private $comment;
	
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
     * Set User
     *
     * @return User
     */
    public function setUser(Colocataires $user)
    {
		$this->user = $user;
        return $this;
    }
	
	/**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
		
        return $this->user;
    }
	
	
	/**
     * Set Colocations
     *
     * @return Colocations
     */
    public function setColocation(Colocations $coloc)
    {
		$this->colocation = $coloc;
        return $this;
    }
	

	
	/**
     * Get Colocations
     *
     * @return Colocations
     */
    public function getColocation()
    {
        return $this->colocation;
    }
	
	
	 /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }
	
	/**
     * Set etat
     *
     * @return Demande
     */
    public function setEtat(String $etat)
    {
		$this->etat = $etat;
        return $this;
    }
	
	/**
     * Get comment
     *
     * @return String
     */
    public function GetComment()
    {
        return $this->comment;
    }
	
	
	/**
     * Set comment
     *
     * @return Demande
     */
    public function setComment(String $comment)
    {
		$this->comment = $comment;
        return $this;
    }

}
