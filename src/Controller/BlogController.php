<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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
     * @route ("/", name="home")
     */
    public function home() {
        return $this->render('blog/home.html.twig', [
            'title' => "Bienvenue dans ce blog !",
            'age' => 32
        ]);
    }

    /**
     * @route ("/blog/new",methods="GET|POST", name="blog_create")
     */

    public function create(){

        $article = new Article();

        $request = Request::createFromGlobals();

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $article->setCreatedAt(new \DateTime());

            if (!empty($manager)) {
                $manager->persist($article);
                $manager->flush();

                return $this->redirectToRoute('blog_show',
                    ['id'=> $article->getId
                    ()]);
            }


        }

            return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()]);
    }


    /**
     * @route("/blog/{id}", methods="GET|POST", name="blog_show")
     */
    public function  show(Article $article) {

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}


