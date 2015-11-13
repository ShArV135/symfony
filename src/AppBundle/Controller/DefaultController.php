<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
		$cats = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('AppBundle:Default:index.html.twig', array(
            'cats' => $cats,
        ));
    }

	/**
	 * @Route("category_{id}", name="category")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function categoryAction(Request $request)
	{
		$category_id = $request->get('id');

		$categoryRepository = $this->getDoctrine()->getRepository('AppBundle:Category');

		$cat = $categoryRepository->find($category_id);
		$cats = $categoryRepository->findAll();

		if (!$cat) {
			throw $this->createNotFoundException('Раздела не существует');
		}

		$products = $this->getDoctrine()->getRepository('AppBundle:Product')->findByCategoryId($category_id);

		return $this->render('AppBundle:Default:category.html.twig', array(
			'parent_cat' => $cat,
			'cats' => $cats,
			'products' => $products,
		));
	}
}
