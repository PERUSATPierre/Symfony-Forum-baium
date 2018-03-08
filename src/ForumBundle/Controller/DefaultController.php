<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ForumBundle\Entity\Categorie;
use ForumBundle\Form\AddSubjectType;

class DefaultController extends Controller
{
    /**
     * @Route("/forum", name="home_forum")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = new Categorie;
        $addForm = $this->createForm(AddSubjectType::class, $categorie);

        if($request->IsMethod('POST'))
        {
            $addForm->handleRequest($request);
            if($addForm->IsValid())
            {
                $em->persist($categorie);
                $em->flush();
                return $this->redirectToRoute('home_forum');
            }
        }

        $subject = $em->getRepository("ForumBundle:Categorie")->findAll();
        return $this->render('@Forum/Default/index.html.twig', 
        array(
            'form'=>$addForm->createView(), 
            'subjects'=>$subject));
    }
    /**
     * @Route("/forum/suject/{id}", name="subject")
     */
    public function subject(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();
        $subject = $em->getRepository("ForumBundle:Categorie")->find($id);
        $title = $subject->getTitle();
        return $this->render('@Forum/Default/subject.html.twig', array('title'=>$title));
    }
}
