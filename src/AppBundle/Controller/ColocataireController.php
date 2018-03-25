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
	use AppBundle\Entity\Activite;
	use AppBundle\Entity\Demande;
	

	


	
	
	
	/**
	* @Route("/{_locale}")
	*/
	class ColocataireController extends Controller
	{
		/**
		* @Route("/connect/",name="Co_connect")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function coConnect(Request $request){
			if(!isset($_POST['valide'])){
				$Coloc=new Colocataires();
				$form = $this->createForm(ColocatairesType::class,$Coloc,[ 'action'=>$this->generateUrl('Co_connect'),]);
				$form->handleRequest($request);
				if(!$form->isSubmitted() || !$form->isValid()){
					return $this->render('co/connect.html.twig',['connect_co_form'=>$form->createView(),]);
				}
			}
			else{
				$connect=false;
				$id=0;
				$Coloc=new Colocataires();
				$form = $this->createForm(ColocatairesType::class,$Coloc,[ 'action'=>$this->generateUrl('Co_connect'),]);
				$form->handleRequest($request);
				$repository=$this->getDoctrine()->getRepository(Colocataires::class);
				$colocs=$repository->findAll();
				foreach($colocs as $coloc){
					if($coloc.getEmail()==$Coloc.getEmail() and $coloc.getPassword() == $Coloc.getPassword()){
						$connect=true;
						$id=$coloc.getId();
					}
				}
				if($connect){
					return $this->redirectToRoute('homepageconnect',$id);
				}
				else{
					return $this->redirectToRoute('homepage');
				}
				
			}
		}
		
		
		/**
		*@Route("/profil/",name="monProfil")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function monProfil(Request $request){
			
			$repository=$this->getDoctrine()->getRepository(Colocataires::class);
			
			$id = $this->getUser();
			$find = $repository->find($id);
			if( null != $find){
				return $this->render('profil/profil.html.twig',['profil'=>$find,'theme' =>$_SESSION['theme'] ,]);
			}
			
			return $this->redirectToRoute('homepage');
		
		
		}
		
		
		/**
		* @Route("/editProfil/", name="editProfil")
		*/
		
		public function editProfil(Request $request)
		{
			if(!isset($_POST['Valider'])){
				
								
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Mon profil", $this->get("router")->generate("monProfil"));
				$breadcrumbs->addItem("Editer");
				
				$user = $this->getUser();
				
				
				$form = $this->createForm(ColocatairesType::class,$user);
				$form->handleRequest($request);
				if(!$form->isSubmitted() || !$form->isValid()){
					return $this->render('profil/editProfil.html.twig',['user'=>$user, 'edit_profil_form'=>$form->createView(),'theme' =>$_SESSION['theme'] ,]);
				}

			}
			else{
				$user = $this->getUser();
				$form = $this->createForm(ColocatairesType::class,$user);
				$form->handleRequest($request);
				$em=$this->getDoctrine()->getManager();
				$em->flush();				
				unset($_POST);
				return $this->redirectToRoute('homepage');
			}
		}
	}
	