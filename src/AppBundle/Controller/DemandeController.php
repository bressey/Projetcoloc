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
		* @Route("/mesColocataires/",name="mesColocataires")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function mesColocataires(Request $request)
		{
					if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			
			//Pass "_demo" route name without any parameters
			$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
			$breadcrumbs->addItem("Mes colocataires", $this->get("router")->generate("mesColocataires"));
			
			$repository=$this->getDoctrine()->getRepository(Demande::class);
			$recu= $repository->findAll();
			$demande=Array();
			foreach($recu as $r){
				if($r->getColocation()->getUser() == $this->getUser() AND $r->getEtat() == 'Accepter' ){
					$demande[] = $r;
				}
			}
			

			
			return $this->render('demande/mesColocataires.html.twig',['accepter'=>$demande,'theme' =>$_SESSION['theme'] ]);
			
			
		}
		
		/**
		* @Route("/Demande/{id}",requirements={"id": "\d+"}, name="AjoutDemande")
		*/
		public function demandeAjout(Colocations $coloc, Request $request)
		{
					if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			$breadcrumbs = $this->get("white_october_breadcrumbs");
				
			// Pass "_demo" route name without any parameters
			$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
			$url = "/Developpement%20web/Projet/Projetcoloc/web/app_dev.php/fr/show/".$coloc->getId();
			$breadcrumbs->addItem("Detail", $url);
			$breadcrumbs->addItem("Demande");
			
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
		
		
		/**
		* @Route("/Accepter/{id}",requirements={"id": "\d+"}, name="accepteDemande")
		*/
		
		public function updateDemande(Demande $demande,Request $request)
		{
			if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			$repository=$this->getDoctrine()->getRepository(Demande::class);
			$id = $demande->getId();
			$find = $repository->find($id);
			
			if( null != $find){
				
				$demande->setEtat("Accepter");
				
	
				$form = $this->createForm(DemandeType::class,$demande);
				$form->handleRequest($request);
				$em=$this->getDoctrine()->getManager();
				$em->flush();				
				
				
				$Coloc = Array();
				$Demande= $repository->findBy( [ 'user' =>$this->getUser()  ] );
				foreach($Demande as $d){
					if($d->getEtat() == 'Attente' ){
						$Coloc[] = $d->getColocation();
					}
				}
				
				$recu= $repository->findAll();
				$demandeRec=Array();
				foreach($recu as $r){
					if($r->getColocation()->getUser() == $this->getUser() AND $r->getEtat() == 'Attente' ){
						$demandeRec[] = $r;
					}
				}
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				//Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Mes annonces", $this->get("router")->generate("mesAnnonces"));
				
				return $this->render('demande/mesDemandes.html.twig',['colocations'=>$Coloc,'recus'=>$demandeRec,'theme' =>$_SESSION['theme'] ]);
				
				
			}else{
			
				return $this->redirectToRoute('homepage');
			}
		}
		
		/**
		*@Route("/MesDemandes/",name="mesDemandes")
		*/
		 public function mesDemandes(Request $request)
		{
			if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			if(!isset($_POST['mesDemandes'])){
				$repository=$this->getDoctrine()->getRepository(Demande::class);
				
				
				
				$Coloc = Array();
				$Demande= $repository->findBy( [ 'user' =>$this->getUser()  ] );
				foreach($Demande as $d){
					if($d->getEtat() == 'Attente' ){
						$Coloc[] = $d->getColocation();
					}
				}
				
				$recu= $repository->findAll();
				$demandeRec=Array();
				foreach($recu as $r){
					if($r->getColocation()->getUser() == $this->getUser() AND $r->getEtat() == 'Attente' ){
						$demandeRec[] = $r;
					}
				}
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Mes annonces", $this->get("router")->generate("mesAnnonces"));
				
				return $this->render('demande/mesDemandes.html.twig',['colocations'=>$Coloc,'recus'=>$demandeRec,'theme' =>$_SESSION['theme'] ]);
			}
		}
		
		
		/**
		* @Route("/refuser/{id}", requirements={"id": "\d+"}, name="deleteDemande")
		*/
		public function deleteDemande(Demande $demande,Request $request)
		{
			$repository=$this->getDoctrine()->getRepository(Demande::class);
			$id = $demande->getId();
			$find = $repository->find($id);
			
			if( null != $find){
				$em=$this->getDoctrine()->getManager();
				$em->remove($demande);
				$em->flush();
	
				
				$Coloc = Array();
				$Demande= $repository->findBy( [ 'user' =>$this->getUser()  ] );
				foreach($Demande as $d){
					if($d->getEtat() == 'Attente'){
						$Coloc[] = $d->getColocation();
					}
				}
				
				$recu= $repository->findAll();
				$demandeRec=Array();
				foreach($recu as $r){
					if($r->getColocation()->getUser() == $this->getUser() AND $r->getEtat() == 'Attente'){
						$demandeRec[] = $r;
					}
				}
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				//Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Mes annonces", $this->get("router")->generate("mesAnnonces"));
				
				return $this->render('demande/mesDemandes.html.twig',['colocations'=>$Coloc,'recus'=>$demandeRec,'theme' =>$_SESSION['theme'] ]);
				
				
			}else{
			
				return $this->redirectToRoute('homepage');
			}
			
		}
		
		
	}
