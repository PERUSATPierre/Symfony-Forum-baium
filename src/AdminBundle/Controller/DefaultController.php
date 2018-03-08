<?php

namespace AdminBundle\Controller;

use BlogBundle\Form\NewsType;
use BlogBundle\Form\NewsEditType;
use BlogBundle\Form\NewsDeleteType;
use BlogBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="home-admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        return $this->render('@Admin/Default/index.html.twig');
    }
    /**
     * @Route("/admin/blog", name="admin-blog")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function listNews()
    {
        //recuperation de la liste des news
        $em = $this->getDoctrine()->getManager();

        $listNews = $em->getRepository('BlogBundle:News')->findAll();

        return $this->render('@Admin/Default/contentNews.html.twig', array('listNews'=>$listNews));
    }
    /**
     * @Route("/admin/blog/add", name="news-add")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addNewsAction(Request $request)//create
    {
        //on ouvre la connection a sql pour l'enregistrement des données en BDD
        $em = $this->getDoctrine()->getManager();
        //on creer un objet de News pour la creation des champs du formulaire
        $news = new News();
        //je creer le formulaire
        $addForm = $this->createForm(NewsType::class, $news);
        //si la method recu est POST 
        if($request->IsMethod('POST'))
        {
            $addForm->handleRequest($request);
            //si le formulaire est valide
            if($addForm->isValid())
            {
                //on effectue l'upload
                $image = $news->getImage();
                $imageName=$this->generateUniqueFileName().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('upload_directory'),
                    $imageName
                );
                $news->setImage($imageName);

                //recuperation de l'utilisateur courant 
                $currentUser = $this->get('security.token_storage')->getToken()->getUser();
                $news->setAuthor($currentUser);

                //insertion en base de donnée
                $em->persist($news);
                $em->flush();
                $request->getSession()->getFlashBag()->add('add', 'message ajouté avec succés');
                //redirection vers la route qui porte le nom news-add
                return $this->redirectToRoute('news-add');
            }
        }
        return $this->render('@Admin/Default/addNews.html.twig', 
        array('form'=>$addForm->createView()));
    }
    /**
    * @Route("/admin/blog/edit/{id}", name="news-edit")
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function editNewsAction(Request $request, $id)//update
    {
        $em = $this->getDoctrine()->getManager();
        //on execute la requete sql qui va chercher la news qui popssede cet ID $id
        $news = $em->getRepository('BlogBundle:News')->find($id);
        //ici on cree le formulaire
        $editForm = $this->createForm(NewsEditType::class, $news);
        
        if($request->isMethod('PUT'))
        {
            $previousImage = $news->getImage();
            $editForm->handleRequest($request);
            if($editForm->isValid())
            {
                //on fait se travail sur l'image pour que le systeme garde l'image qui est deja dans la bdd
                //je verifie que le champs du formulaire est different de null ['image '] est le nom de l'input dans NewsType
                if($editForm['image']->getData() == null)
                {
                    //si il est vide je set le champs avec la nouvelle valeur
                    $news->setImage($previousImage);
                }
                else
                {
                    //sinon je refait un upload
                    $image = $news->getImage();
                    //on rename l'image pour qu'elle ai un nom unique
                    $imageName=$this->generateUniqueFileName().'.'.$image->guessExtension();
                    //ici on fait le move upload de l'image
                    $image->move(
                    $this->getParameter('upload_directory'),
                    $imageName
                    );
                    $news->setImage($imageName);
                }
                //j'insere en BDD 
                $em->flush();
                
                $request->getSession()->getFlashBag()->add('success', 'Actualité modifié');
            }
        }
        //je renvoi le formulaire a la vue
        return $this->render('@Admin/Default/editNews.html.twig', 
        array('form'=>$editForm->createView()));
    }
    /**
     * @Route("/admin/blog/delete/{id}", name ="delete")
     *
     */
    public function deleteNews(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('BlogBundle:News')->find($id);
        $em->remove($news);
        $em->flush();
      
        $request->getSession()->getFlashbag()->add('news', 'Actualité bien supprimée');
      
        return $this->redirectToRoute('admin-blog');
    }
    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
