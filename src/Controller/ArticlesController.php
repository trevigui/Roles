<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesCrudType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="app_articles")
     */
    public function index(ArticlesRepository  $repo): Response
    {
        $articles = $repo->findAll();
        return $this->render('articles/articles.html.twig', [
            //'controller_name' => 'EventsController',
            "articles" => $articles,
        ]);
    }

    /**
     * @Route("/article/{id}", name="app_article")
     */
    public function ficheArticle($id, ArticlesRepository $repo): Response
    {
        $article = $repo->find($id);
        return $this->render('articles/article.html.twig', [
            // 'controller_name' => 'ArticlesController',
            "article" => $article,
        ]);
    }

    /**
     * @Route("/article/create", name="app_createArticle", methods= {"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $crud = new Articles(); #entity
        $form = $this->createForm(ArticlesCrudType::class, $crud); #creation du formulaire grace au CrudType qui est un formBuilderCrud::class pour utiliser le formulaire de la class entityCrud
        $form->handleRequest($request); #applique les requête pour les appliquer au formulaire afin d'associer chaque champs aux colonnes correspondante de la table articles
        if ($form->isSubmitted() && $form->isValid()) {
            //ici on enregistre dans la base de données si le formulaire est bien rempli
            $sendDatabase = $this->getDoctrine()->getManager();
            $sendDatabase->persist($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Soumission réussi !!');

            return $this->redirectToRoute("app_articles"); #redirection vers la page d'accueil

        }

        return $this->render('articles/createArticle.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/article/delete/{id}", name="app_deleteArticle", methods= {"GET", "POST"})
     */
    public function delete($id, Request $request): Response
    {
        $crud = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        $form = $this->createForm(ArticlesCrudType::class, $crud); #creation du formulaire grace au CrudType qui est un formBuilderCrud::class pour utiliser le formulaire de la class entityCrud
        $form->handleRequest($request); #applique les requête pour les appliquer au formulaire afin d'associer chaque champs aux colonnes correspondante de la table articles
        if ($form->isSubmitted() && $form->isValid()) {
            //ici on enregistre dans la base de données si le formulaire est bien rempli
            $sendDatabase = $this->getDoctrine()->getManager();
            $sendDatabase->remove($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Suppression réussi !!');

            return $this->redirectToRoute("app_articles"); #redirection vers la page d'accueil

        }

        return $this->render('articles/deleteArticle.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/article/update/{id}", name="app_updateArticle", methods= {"GET", "POST"})
     */
    public function update($id, Request $request): Response
    {
        $crud = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        $form = $this->createForm(ArticlesCrudType::class, $crud); #creation du formulaire grace au CrudType qui est un formBuilderCrud::class pour utiliser le formulaire de la class entityCrud
        $form->handleRequest($request); #applique les requête pour les appliquer au formulaire afin d'associer chaque champs aux colonnes correspondante de la table articles
        if ($form->isSubmitted() && $form->isValid()) {
            //ici on enregistre dans la base de données si le formulaire est bien rempli
            $sendDatabase = $this->getDoctrine()->getManager();
            $sendDatabase->persist($crud);
            $sendDatabase->flush();

            $this->addFlash('notice', 'Modification réussi !!');

            return $this->redirectToRoute("app_articles"); #redirection vers la page d'accueil

        }

        return $this->render('articles/updateArticle.html.twig', [
            'controller_name' => 'MainController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/accueil", name="accueil", methods= {"GET", "POST"})
     */
    public function accueil(): Response
    {
        return $this->render('accueil.html.twig', []);
    }
}
