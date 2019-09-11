<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\BlogType;
use App\Form\CommentType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\File\File;


class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }


    /**
     * @Route("/lecture-article/{path}", name="lecture-article")
     */
    public function lecture_article($path, RegistryInterface $doctrine, Request $request)
    {
        $article = $doctrine->getRepository(Article::class)->findOneByPath($path);
        $comment = new Commentaire();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $article->addCommentaire($comment);
            $em->persist($comment);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('lecture-article', ["path" => $path]);
        }
        return $this->render('base/lecture_article.html.twig', array(
            "article" => $article,
            'form' => $form->createView()
        ));
    }

    public function new_article(RegistryInterface $doctrine, Request $request)
    {

        $article = new Article();
        $form = $this->createForm(BlogType::class, $article);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            #$article->setType($type);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('cms-blog');
        }
        return $this->render('CMS/new_article.html.twig', array(
            "form" => $form->createView(),
            "commentaires" => false,
        ));
    }

    public function edit_article(RegistryInterface $doctrine, Request $request, $id)
    {
        $article = $doctrine->getRepository(Article::class)->find($id);
        $article->getImage()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $article->getImage()->getFilename()));
        $form = $this->createForm(BlogType::class, $article);
        $saveImage = $article->getImage()->getFilename();

        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getImage()->getFilename() == null)
                $data->getImage()->setFilename($saveImage);
            #$article->setType($type);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('cms-blog');
        }
        return $this->render('CMS/new_article.html.twig', array(
            "form" => $form->createView(),
            "commentaires" => $article->getCommentaires()
        ));
    }

    /**
     * @Route("/get-article",name="getArticle")
     */

    public function getArticle(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $page = $contentDecode->page;
        $biens = $doctrine->getRepository(Article::class)->myGetArticle($page);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($biens, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
    }
    /**
     * @Route("/get-article",name="getArticle")
     */

    public function getArticleBYType(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        $page = $contentDecode->page;
        if ($type == "All") {
            $selection = $doctrine->getRepository(Article::class)->myGetArticle(intval($page));
        } else {
            $selection = $doctrine->getRepository(Article::class)->myGetArticleByType($type, intval($page));
        }
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($selection, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
    }
    public function searchArticle(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $search = $contentDecode->searchText;
        $articles = $doctrine->getRepository(Article::class)->myArticleSearch($search);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($articles, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
    }
    public function countArticle(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        if ($type != 'All')
            $count = $doctrine->getRepository(Article::class)->myCountByTri($type);
        else
            $count = $doctrine->getRepository(Article::class)->myCount();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($count, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);

        return $response;
    }


    /**
     * @Route("/new-comment/{id}", name="new-comment")
     */
    public function new_comment(RegistryInterface $doctrine, Request $request, $id)
    {
        $comment = new Commentaire();
        $article = $doctrine->getRepository(Article::class)->find($id);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $article->addCommentaire($comment);
            $em->persist($comment);
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/delete-comment/{id}", name="delete-comment")
     */
    public function delete_comment($id, RegistryInterface $doctrine, Request $request)
    {
        $comment = $doctrine->getRepository(Commentaire::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        //  $em->remove($timeline);
        $em->remove($comment);
        $em->flush();
        return $this->redirectToRoute('edit-article', ["id" => $comment->getArticle()->getId()]);
    }
}
