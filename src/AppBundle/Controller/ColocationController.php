<?php
	
	namespace AppBundle\Controller;

	use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use AppBundle\Form\ColocatairesType;
	use AppBundle\Form\ColocationsType;
	use AppBundle\Form\DemandeType;
	use AppBundle\Entity\Colocataires;
	use AppBundle\Entity\Colocations;
	use AppBundle\Entity\Demande;

	/**
	* @Route("/{_locale}")
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
			if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			

			if(!isset($_POST['recherche']))
			{
				$repository=$this->getDoctrine()->getRepository(Colocations::class);
				$Coloc=$repository->findAll();
				
				
				dump($Coloc);
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
			
					
					return $this->render('colocation/index.html.twig',array('colocations'=>$Coloc, 'theme' =>$_SESSION['theme'] ));
				
				
				
			}
			else
			{
				
				$repository = $this->getDoctrine()
                   ->getManager()
                   ->getRepository(Colocations::class);
				   
				   
												
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Recherche");  
				   
				$Coloc_pers = $repository->findAll();
				if(( $_POST['prixMax'])=="NULL" AND ( $_POST['prixMin'])=="NULL"){ 
					if(!empty($_POST['ville'])){
						if(( $_POST['nbPers'])!="NULL"){

							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( ['type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );

							}
							else{
								$Coloc_pers = $repository->findBy( [ 'ville' =>$_POST['ville'] ] );

							}
							
							$pers = $_POST['nbPers'];
							$personne = Array();
							if( $pers == 6){
								
								foreach($Coloc_pers as $c){
									if($c->getNbPers() >= 6){
										$personne[] = $c;
									}
								}
							}else{
								foreach($Coloc_pers as $c){
									if($c->getNbPers() == $pers){
										$personne[] = $c;
									}
								}
							}
							
							$Coloc_pers = $personne;
						}
						else{
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );
							}else{
								$Coloc_pers = $repository->findBy( [ 'ville' =>$_POST['ville']  ] );
							}
						}
					}else{
						if(( $_POST['nbPers'])!="NULL"){
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( ['type' => $_POST['type']] );
							}else{
								$Coloc_pers = $repository->findAll();
							}
							$pers = $_POST['nbPers'];
							$personne = Array();
							if( $pers == 6){
								
								foreach($Coloc_pers as $c){
									if($c->getNbPers() >= 6){
										$personne[] = $c;
									}
								}
							}else{
								foreach($Coloc_pers as $c){
									if($c->getNbPers() == $pers){
										$personne[] = $c;
									}
								}
							}
							
							$Coloc_pers = $personne;
						}
						else{
							if(($_POST['type'])!="NULL"){
								$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type']] );
							}
						}
					}
				}else{
					if( ($_POST['prixMin'])=="NULL"){
						$prixMin = 0;
					}else{
						$prixMin = $_POST['prixMin'];
					}
					
					if( ($_POST['prixMax'])=="NULL"){
						$prixMax = 0;
					}else{
						$prixMax = $_POST['prixMax'];
					}
					
					if(!empty($_POST['ville'])){
						if(( $_POST['nbPers'])!="NULL"){
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type'], 'ville' =>$_POST['ville']  ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}
								else{
									$Coloc_pers = $repository->findBy( [ 'ville' =>$_POST['ville'] ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}
								$pers = $_POST['nbPers'];
							$personne = Array();
							if( $pers == 6){
								
								foreach($Coloc_pers as $c){
									if($c->getNbPers() >= 6){
										$personne[] = $c;
									}
								}
							}else{
								foreach($Coloc_pers as $c){
									if($c->getNbPers() == $pers){
										$personne[] = $c;
									}
								}
							}
							
							$Coloc_pers = $personne;
							}else{
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type'], 'ville' =>$_POST['ville']] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}else{
									$Coloc_pers = $repository->findBy( ['ville' =>$_POST['ville'] ] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}
							}
					}else{
						
						
							
							if(( $_POST['nbPers'])!="NULL"){
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( ['type' => $_POST['type']] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}
								else{
									$Coloc_pers = $repository->findAll();
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}
								$pers = $_POST['nbPers'];
								$personne = Array();
								if( $pers == 6){
									
									foreach($Coloc_pers as $c){
										if($c->getNbPers() >= 6){
											$personne[] = $c;
										}
									}
								}else{
									foreach($Coloc_pers as $c){
										if($c->getNbPers() == $pers){
											$personne[] = $c;
										}
									}
								}
								
								$Coloc_pers = $personne;
							}
							else{
								if(($_POST['type'])!="NULL"){
									$Coloc_pers = $repository->findBy( [ 'type' => $_POST['type']] );
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);
								}else{
									$Coloc_pers = $repository->findAll();
									$Coloc_pers = $this->prixInf($Coloc_pers, $prixMax, $prixMin);

								}
							}
						
					}
				}
				dump($Coloc_pers);

				return $this->render('colocation/index.html.twig',array('colocations'=>$Coloc_pers, 'theme' =>$_SESSION['theme'] ));
			}
		}
		
		
		function prixInf(Array $Coloc, $prixMax, $prixMin)
		{
			$price = Array();
			foreach($Coloc as $c){
				if($prixMax > $prixMin){
					if($c->getPrix() <= $prixMax AND $c->getPrix() >= $prixMin){
						 $price[]= $c;
					}
					
				}else{
					if($prixMax == $prixMin){
						if($c->getPrix() == $prixMax OR $prixMin == 0){
							 $price[]= $c;
						}
					
					}else{
						if($c->getPrix() >= $prixMin){
							$price[]= $c;
						}
					}
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
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Ajout colocation", $this->get("router")->generate("Ajoutcoloc"));
 				
				
				$Coloc=new Colocations();				
				$form = $this->createForm(ColocationsType::class,$Coloc,[ 'action'=>$this->generateUrl('Ajoutcoloc'),]);
 				$form->handleRequest($request);
 				if(!$form->isSubmitted() || !$form->isValid()){
 					return $this->render('colocation/add.html.twig',['coloc_form'=>$form->createView(),'theme'=>$_SESSION['theme'],]);
 				}
			}
			else{
				$Coloc=new Colocations();
				$form = $this->createForm(ColocationsType::class,$Coloc,[ 'action'=>$this->generateUrl('Ajoutcoloc')]);
				$form->handleRequest($request);
				$Coloc->setUser($this->getUser());
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
			if($Coloc->getUser() != $this->getUser()){
				return $this->render('accesDenied/index.html.twig',['theme'=>$_SESSION['theme'],]);
			}
			else
			{
				if(!isset($_POST['Valider'])){
					
									
					$breadcrumbs = $this->get("white_october_breadcrumbs");
					
					// Pass "_demo" route name without any parameters
					$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
					$breadcrumbs->addItem("Mes annonces", $this->get("router")->generate("mesAnnonces"));
					$breadcrumbs->addItem("Editer");
					
					$form = $this->createForm(ColocationsType::class,$Coloc);
					$form->handleRequest($request);
					if(!$form->isSubmitted() || !$form->isValid()){
						return $this->render('colocation/edit.html.twig',['coloc'=>$Coloc, 'edit_coloc_form'=>$form->createView(),'theme'=>$_SESSION['theme'],]);
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
		}
		
		/**
		*@Route("/show/{id}",requirements={"id": "\d+"}, name="showColoc")
		*/
		 public function showAction(Colocations $Coloc,Request $request)
		{
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			
			// Pass "_demo" route name without any parameters
			$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
			$breadcrumbs->addItem("Detail");
			
				
			$repository=$this->getDoctrine()->getRepository(Colocations::class);
			$id = $Coloc->getId();
			$find = $repository->find($id);
			if( null != $find){
				
				return $this->render('colocation/show.html.twig',['colocations'=>$Coloc,'theme' =>$_SESSION['theme'], 'coloc'=>$id ]);
				
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
		
		/**
		* @Route("/mes annonces", name="mesAnnonces")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function mesAnnonces(Request $request){
			if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			if(!isset($_POST['mesAnnonces'])){
				$repository=$this->getDoctrine()->getRepository(Colocations::class);
				$Coloc=$repository->findAll();
				dump($Coloc);

				$Coloc= $repository->findBy( [ 'user' =>$this->getUser()  ] );
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Mes annonces", $this->get("router")->generate("mesAnnonces"));
				
				return $this->render('annonce/mesAnnonces.html.twig',['colocations'=>$Coloc,'theme' =>$_SESSION['theme'] ]);
			}
		}
	
			
	}
	