<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
        ->getRepository("BlogBundle:News");

       $news = $repository->showNews();

        return $this->render('@Blog/Default/index.html.twig', array('news'=>$news));
    }
}
