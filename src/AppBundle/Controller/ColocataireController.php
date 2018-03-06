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
	* @Route("/{_locale}/Co")
	*/
	class ColocataireController extends Controller
	{
		/**
		* @Route("/connect/",name="Co_connect")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function coConnect(Request $request){
			$Coloc=new Colocataires();
			$form = $this->createForm(ColocatairesType::class,$Coloc,[ 'action'=>$this->generateUrl('Co_connect'),]);
			$form->handleRequest($request);
			if(!$form->isSubmitted() || !$form->isValid()){
				return $this->render('co/connect.html.twig',['connect_co_form'=>$form->createView(),]);
			}
			$repository=$this->getDoctrine()->getRepository(Colocataires::class);
			$avert = $repository->find($Coloc.getId());
			if(null != $advert){
				throw new NotFoundHttpException("Le nom d'utilisateur d' ".$Coloc.getEmail()." n'existe pas.");
			}
			else{
				return $this->redirectToRoute('pageconnect');
			}
		}
	}
	