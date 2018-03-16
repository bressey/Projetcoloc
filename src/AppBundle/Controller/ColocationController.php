<?php
	
	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use AppBundle\Form\ColocatairesType;
	use AppBundle\Form\ColocationsType;
	use AppBundle\Form\ActiviteType;
	use AppBundle\Entity\Colocataires;
	use AppBundle\Entity\Colocations;
	use AppBundle\Entity\Activite;

	
	
	
	/**
	* @Route("/{_locale}/Colocation")
	*/
	class ColocationController extends Controller
	{	
		/**
		* @Route("/",name="homepage")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function indexAction(Request $request)
		{
			if(!isset($_POST['recherche']))
			{
				$repository=$this->getDoctrine()->getRepository(Colocations::class);
				$Coloc=$repository->findAll();
				dump($Coloc);
				
				return $this->render('colocation/index.html.twig',['colocations'=>$Coloc]);
			}else
			{
				$repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository(Colocations::class);
				if(( $_POST['prix'])=="NULL"){ 
					if(!empty($_POST['ville'])){
						if(( $_POST['nbPers'])!="NULL"){
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );
							}
							else{
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'ville' =>$_POST['ville'] ] );
							}
						}
						else{
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );
							}else{
								$Coloc_pers = $repository->findBy( ['ville' =>$_POST['ville']  ] );
							}
						}
					}else{
						if(( $_POST['nbPers'])!="NULL"){
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'type' => $_POST['type']] );
							}
							else{
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'] ] );
							}
						}
						else{
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type']] );
							}
						}
					}
				}else{
					if(!empty($_POST['ville'])){
						if(( $_POST['nbPers'])!="NULL"){
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
								}
								else{
									$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'ville' =>$_POST['ville'] ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
								}
							}else{
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type'], 'ville' =>$_POST['ville']] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
								}else{
									$Coloc_pers = $repository->findBy( ['ville' =>$_POST['ville'] ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
								}
							}
					}else{
						if(( $_POST['nbPers'])!="NULL"){
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'], 'type' => $_POST['type']] );
								$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
							}
							else{
								$Coloc_pers = $repository->findBy( ['nbPers' => $_POST['nbPers'] ] );
								$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
							}
						}
						else{
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type']] );
								$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);
							}else{
								$Coloc_pers = $repository->findAll();
								$Coloc_pers = $this->prixInf($Coloc_pers, $_POST['prixMax'], $_POST['prixMin']);

							}
						}
					}
				}
			
				
				return $this->render('colocation/index.html.twig',['colocations'=>$Coloc_pers]);
			}
		}
		
		
		function prixInf(Array $Coloc, String $prixMax, String $prixMin)
		{
			$price = Array();
			foreach($Coloc as $c){
				if($c->getPrix() <= $prixMax AND $c->getPrix() >= $prixMin){
					 $price[]= $c;
				}
				
			}
			return $price;
		}
		
		
		/**
		* @Route("/Coloc/", name="Ajoutcoloc")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function colocAjout(Request $request){
			if(!isset($_POST['Ajout'])){
 				$Coloc=new Colocations();
				$form = $this->createForm(ColocationsType::class,$Coloc,[ 'action'=>$this->generateUrl('Ajoutcoloc'),]);
 				$form->handleRequest($request);
 				if(!$form->isSubmitted() || !$form->isValid()){
 					return $this->render('colocation/add.html.twig',['coloc_form'=>$form->createView(),]);
 				}
			}
			else{
				$Coloc=new Colocations();
				$form = $this->createForm(ColocationsType::class,$Coloc,[ 'action'=>$this->generateUrl('Ajoutcoloc')]);
				$form->handleRequest($request);
				$em=$this->getDoctrine()->getManager();
				$em->persist($Coloc);
				$em->flush();
				unset($_POST);
				return $this->redirectToRoute('homepage');
			}
		}
		
		/**
		* @Route("/edit/{id}",requirements={"id": "\d+"}, name="editColoc")
		*/
		
		public function updateAction(Colocations $Coloc,Request $request)
		{
			if(!isset($_POST['Valider'])){
				$form = $this->createForm(ColocationsType::class,$Coloc);
				$form->handleRequest($request);
				if(!$form->isSubmitted() || !$form->isValid()){
					return $this->render('colocation/edit.html.twig',['coloc'=>$Coloc, 'edit_coloc_form'=>$form->createView(),]);
				}
			}
			else{
				$form = $this->createForm(ColocationsType::class,$Coloc);
				$form->handleRequest($request);
				$em=$this->getDoctrine()->getManager();
				$em->flush();
				unset($_POST);
				return $this->redirectToRoute('homepage');
			}
		}
		
		/**
		*@Route("/show/{id}",requirements={"id": "\d+"}, name="showColoc")
		*/
		 public function showAction(Colocations $Coloc,Request $request)
		{
			$repository=$this->getDoctrine()->getRepository(Colocations::class);
			$id = $Coloc->getId();
			$find = $repository->find($id);
			if( null != $find){
				return $this->render('colocation/show.html.twig',['colocations'=>$Coloc,]);
			}
			
			return $this->redirectToRoute('homepage');
		}
		
		/**
		* @Route("/delete/{id}", requirements={"id": "\d+"}, name="deleteColoc")
		*/
		public function deleteAction(Colocations $Coloc,Request $request)
		{
			$em=$this->getDoctrine()->getManager();
			$em->remove($Coloc);
			$em->flush();
			
			return $this->redirectToRoute('homepage');
		}
		
		
		
		
		
			
			
	}
	