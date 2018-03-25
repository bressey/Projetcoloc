<?php

	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use AppBundle\Form\ColocatairesType;
	use AppBundle\Form\ColocationsType;
	use AppBundle\Form\DemandeType;
	use AppBundle\Form\ActiviteType;
	use AppBundle\Entity\Colocataires;
	use AppBundle\Entity\Colocations;
	use AppBundle\Entity\Demande;

	/**
	* @Route("/{_locale}")
	*/
	class DemandeController extends Controller
	{	
		/**
		* @Route("/",name="homepage")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		// public function indexAction(Request $request)
		// {}
		
		/**
		* @Route("/Demande/{id}",requirements={"id": "\d+"}, name="AjoutDemande")
		*/
		public function demandeAjout(Colocations $coloc, Request $request)
		{
			if(!isset($_POST['Ajout'])){
				$demande=new Demande();
				$form = $this->createForm(DemandeType::class,$demande);
				$form->handleRequest($request);
				if(!$form->isSubmitted() || !$form->isValid()){
					return $this->render('demande/add.html.twig',['demande_form'=>$form->createView(),'theme' =>$_SESSION['theme'] ]);
				}
			}
			else{
				$demande=new Demande();
				
				$form = $this->createForm(DemandeType::class,$demande);
				$form->handleRequest($request);
				$demande->setUser($this->getUser());
				$demande->setColocation($coloc);
				$demande->setEtat('Attente');
				
				$em=$this->getDoctrine()->getManager();
				$em->persist($demande);
				$em->flush();
				unset($_POST);
				return $this->redirectToRoute('homepage');
			}
		}
		
		
		// /**
		// * @Route("/edit/{id}",requirements={"id": "\d+"}, name="editDemande")
		// */
		
		// public function updateDemande(Demande $demande,Request $request)
		// {}
		
		// /**
		// *@Route("/show/{id}",requirements={"id": "\d+"}, name="showDemande")
		// */
		 // public function showDemande(Demande $demande,Request $request)
		// {}
		
		
		// /**
		// * @Route("/delete/{id}", requirements={"id": "\d+"}, name="deleteDemande")
		// */
		// public function deleteDemande(Demande $demande,Request $request)
		// {}
		
		
	}
