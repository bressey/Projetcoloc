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
		* @Route("/Coloc/", name="Ajoutcoloc")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		public function colocAjout(Request $request){
			$Coloc=new Colocations();
			$form = $this->createForm(ColocationsType::class,$Coloc,[ 'action'=>$this->generateUrl('Ajoutcoloc'),]);
			$form->handleRequest($request);
			if(!$form->isSubmitted() || !$form->isValid()){
				return $this->render('colocation/add.html.twig',['coloc_form'=>$form->createView(),]);
			}
			return $this->redirectToRoute('homepage');
		}
	}
	