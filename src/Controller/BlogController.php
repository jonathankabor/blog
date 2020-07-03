<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @route ("/blog/new", name="blog_create")
     */
    public function create(){

        $article = new Article();

        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView()
        ]);
    }


    /**
     * @route("/blog/{id}", name="blog_show")
     */
    public function  show(Article $article) {

        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}


