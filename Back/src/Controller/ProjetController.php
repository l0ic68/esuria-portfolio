<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projet;
use App\Form\BlogType;
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

class ProjetController extends Controller
{
    /**
     * @Route("/projet", name="projet")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjetController.php',
        ]);
    }



    public function lecture_projet($titre, RegistryInterface $doctrine)
    {

        $project = $doctrine->getRepository(Projet::class)->findOneByTitre($titre);
        return $this->render('base/lecture_projet.html.twig',array(
            "project" => $project,
        ));

    }

    public function new_projet(RegistryInterface $doctrine,Request $request)
    {

        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid())
        {
            #$projet->setType($type);
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('cms-projet');
        }
        return $this->render('CMS/new_projet.html.twig',array(
            "form" => $form->createView(),
        ));

    }
    public function edit_projet(RegistryInterface $doctrine,Request $request,$id)
    {
        $projet = $doctrine->getRepository(Projet::class)->find($id);
        $form = $this->createForm(BlogType::class, $projet);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('cms-blog');
        }
        return $this->render('CMS/new_projet.html.twig',array(
            "form" => $form->createView(),
        ));

    }

    /**
     * @Route("/get-projet",name="getProjet")
     */

    public function getProjet(Request $request, RegistryInterface $doctrine)
    {
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $page = $contentDecode->page;
        $biens = $doctrine->getRepository(Projet::class)->myGetProjet($page);
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
     * @Route("/get-projet",name="getProjet")
     */

    public function getProjetBYType(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        $page = $contentDecode->page;
        $selection = $doctrine->getRepository(Projet::class)->myGetProjetByType($type,intval($page));
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
    public function searchProjet(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $search = $contentDecode->searchText;
        $projets = $doctrine->getRepository(Projet::class)->myProjetSearch($search);
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($projets, 'json');
        
        $response = new JsonResponse();
        $response->setData($jsonContent);
        // dump($response);
       
        return $response;
    }
    public function countProjet(Request $request, RegistryInterface $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        if($type != 'All')
            $count = $doctrine->getRepository(Projet::class)->myCountByTri($type);
        else
            $count = $doctrine->getRepository(Projet::class)->myCount();
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
