<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route ("/", name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig', [
            'title' => "Bienvenue dans ce blog !",
            'age' => 32
        ]);
    }

    /**
     * @Route ("/blog/new",methods={"GET", "POST"}, name="blog_create")
     * @Route ("/blog/{id}/edit", name="blog_edit")
     * @param EntityManagerInterface $manager
     * @param $article
     * @return Response
     */

    public function form(EntityManagerInterface $manager, Article $article = null): Response {

        if(!$article){
        $article = new Article();
        }

        $request = Request::createFromGlobals();

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId()){
            $article->setCreatedAt(new \DateTime());
            }


            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show',
                ['id'=> $article->getId
                ()]);

        }
        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null]);

    }


    /**
     * @Route("/blog/{id}", methods={"GET", "POST"}, name="blog_show")
     */
    public function  show(Article $article) {

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}


