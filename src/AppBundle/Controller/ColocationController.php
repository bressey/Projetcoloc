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
				   
				
				$Coloc_pers=$repository->findAll();
				$Coloc = array();
				foreach($Coloc_pers as $c){
					if(($_POST['nbPers']!= "NULL") AND $_POST['nbPers']==$c->getNbPers()){
						if(!empty ($_POST['type']) AND ($_POST['type']==$c->getType())){
							$Coloc[]=$c;
						}
					
					}
					if(($_POST['nbPers']== "NULL")){
						if(!empty ($_POST['type']) AND ($_POST['type']==$c->getType())){
							$Coloc[]=$c;
						}
					
					}
					
					if(($_POST['type'] == "NULL")){
						if(($_POST['nbPers']!= "NULL") AND $_POST['nbPers']==$c->getNbPers()){
							$Coloc[]=$c;
						}
					
					}
					if(($_POST['type'] == "NULL") AND ($_POST['nbPers']== "NULL")){
						$Coloc[]=$c;
					}
				}
				dump($Coloc);
				
				
				
				return $this->render('colocation/index.html.twig',['colocations'=>$Coloc]);
			}
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
	