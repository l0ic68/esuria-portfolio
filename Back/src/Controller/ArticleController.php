<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
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



    public function lecture_article($titre, RegistryInterface $doctrine)
    {

        $article = $doctrine->getRepository(Article::class)->findOneByPath($titre);
        return $this->render('base/lecture_article.html.twig',array(
            "article" => $article,
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
        // print($content);
        $contentDecode = json_decode($content);
        // $id = $contentDecode->id;
        $page = $contentDecode->page;
       // dump($contentDecode);
        // $dateCreation = $contentDecode->dateCreation;
        // $dateCreation = new \Datetime($dateCreation);
      //  dump($dateCreation->format("Y/m/d h:m:s"));
        // $result = date('Y-m-d H:i:s',$dateCreation->timestamp);
        $biens = $doctrine->getRepository(Article::class)->myGetArticle($page);
        // for($i = 0; $i<sizeof($biens) ;$i++)
        // {
        //     $biens[$i]['dateCreation'] = $biens[$i]['dateCreation']->format("Y/m/d H:i:s");
        //     $biens[$i]["prixDeVente"] =   $biens[$i][1];
        //     unset( $biens[$i][1]);
        //     $biens[$i]["titre"] =   $biens[$i][2];
        //     unset( $biens[$i][2]);
        //     $biens[$i]["surfaceHabitable"] =   $biens[$i][3];
        //     unset( $biens[$i][3]);
        //     $biens[$i]["ville"] =   $biens[$i][4];
        //     unset( $biens[$i][4]);
        //     $biens[$i]["adresse"] =   $biens[$i][5];
        //     unset( $biens[$i][5]);
        //     $biens[$i]["nbreChambre"] =   $biens[$i][6];
        //     unset( $biens[$i][6]);
        //     $biens[$i]["nbreSalleDeBain"] =   $biens[$i][7];
        //     unset( $biens[$i][7]);
        //     // dump($bien);
        //     // $bien["dateCreation"] = $bien["dateCreation"]->format("Y/m/d h:m:s");
        // }
        // var_dump($biens);
       // $message = $doctrine->getRepository(Message::class)->findByConversation($convo,array('dateEnvoi' => 'desc'),10,10);
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
        $selection = $doctrine->getRepository(Article::class)->myGetArticleByType($type,intval($page));
        // for($i = 0; $i<sizeof($biens) ;$i++)
        // {
        //     $biens[$i]['dateCreation'] = $biens[$i]['dateCreation']->format("Y/m/d H:i:s");
        //     $biens[$i]["prixDeVente"] =   $biens[$i][1];
        //     unset( $biens[$i][1]);
        //     $biens[$i]["titre"] =   $biens[$i][2];
        //     unset( $biens[$i][2]);
        //     $biens[$i]["surfaceHabitable"] =   $biens[$i][3];
        //     unset( $biens[$i][3]);
        //     $biens[$i]["ville"] =   $biens[$i][4];
        //     unset( $biens[$i][4]);
        //     $biens[$i]["adresse"] =   $biens[$i][5];
        //     unset( $biens[$i][5]);
        //     $biens[$i]["nbreChambre"] =   $biens[$i][6];
        //     unset( $biens[$i][6]);
        //     $biens[$i]["nbreSalleDeBain"] =   $biens[$i][7];
        //     unset( $biens[$i][7]);
        //     // dump($bien);
        //     // $bien["dateCreation"] = $bien["dateCreation"]->format("Y/m/d h:m:s");
        // }
        // var_dump($biens);
       // $message = $doctrine->getRepository(Message::class)->findByConversation($convo,array('dateEnvoi' => 'desc'),10,10);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
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
        if($type != 'All')
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
}
