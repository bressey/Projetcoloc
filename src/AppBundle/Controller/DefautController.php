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
	class DefautController extends Controller
	{	
		/**
		* @Route("/rss.xml", defaults={"page": "1", "_format"="xml"} ,name="fluxRSS")
		* @return \Symfony\Component\HttpFoundaztion\Response
		* @throws \LogicException
		*/
		function indexAction(Request $request)
		{
						if(!empty($_POST['style']) AND ($_POST['style'] != "NULL")){

				$_SESSION['theme'] = $_POST['style'];
				
			}else{
				if(!isset($_SESSION['theme'])){
					$_SESSION['theme'] = 'CSS.css';
				}
				
			}
			
			$repository=$this->getDoctrine()->getRepository(Colocations::class);
			$Coloc=$repository->findAll();
			
			return $this->render('RSS/index.xml.twig',array('colocations'=>$Coloc, 'theme' =>$_SESSION['theme'] ));
				
		}
	
	
	}