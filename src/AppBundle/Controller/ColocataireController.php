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
		*@Route("/profil/",name="monProfil")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function monProfil(Request $request)
		{
			
			
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			
			// Pass "_demo" route name without any parameters
			$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
			$breadcrumbs->addItem("Mon Profil");
				
			
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
		
		/**
		*@Route("/Administrateur/",name="administrateur")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function administrateur(Request $request)
		{
			
			if($this->getUser()==null or !( in_array('ROLE_ADMIN', $this->getUser()->getRoles()))){
				return $this->render('accesDenied/index.html.twig',['theme'=>$_SESSION['theme'],]);
			}
			else
			{
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Administrateur");
					
				
				$repository=$this->getDoctrine()->getRepository(Colocataires::class);
				
				
				$coloc = $repository->findAll();
				if( null != $coloc){
					return $this->render('profil/admin.html.twig',['profil'=>$coloc,'theme' =>$_SESSION['theme'] ,]);
				}
				
				return $this->redirectToRoute('homepage');
			
			}
		}
		
		/**
		*@Route("/DeleteUser/{id}",requirements={"id": "\d+"}, name="deleteUser"),name="administrateur")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function deleteUser(Colocataires $user, Request $request)
		{
			if(!( in_array('ROLE_ADMIN', $this->getUser()->getRoles()))){
				return $this->render('accesDenied/index.html.twig',['theme'=>$_SESSION['theme'],]);
			}
			else
			{
				
				$user->setEnabled(false);
				$em=$this->getDoctrine()->getManager();
				$em->persist($user);
				$em->flush();
				
				
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				
				// Pass "_demo" route name without any parameters
				$breadcrumbs->addItem("Homepage", $this->get("router")->generate("homepage"));
				$breadcrumbs->addItem("Administrateur");
					
				
				$repository=$this->getDoctrine()->getRepository(Colocataires::class);
				
				
				$coloc = $repository->findAll();
				$col = Array();
				foreach($coloc as $c){
					if($c->isEnabled() == true){
					$col[]=$c;
					}
				}
				if( null != $coloc){
					return $this->render('profil/admin.html.twig',['profil'=>$col,'theme' =>$_SESSION['theme'] ,]);
				}
				
				return $this->redirectToRoute('homepage');
			}
		
		
		}
	}
	