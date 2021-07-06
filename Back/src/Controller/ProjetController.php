<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projects;
use App\Entity\Technologies;
use App\Form\TechnologieType;
use App\Form\BlogType;
use App\Form\ProjectType;
use Doctrine\Persistence\ManagerRegistry;
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
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Cocur\Slugify\Slugify;


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


    /**
     * @Route("/gestion-projects", name="gestion_projects")
     */
    public function gestion_projets()
    {
        // replace this line with your own code!
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository(Projects::class)->findAll();
        return $this->render('base/projets_gestion.html.twig', array('projects' => $projects));
    }

    /**
     * @Route("/projet/{id}/{slug}", name="lecture-projet")
     */
    public function lecture_projet($slug,$id)
    {
        // replace this line with your own code!
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $next = $em->getRepository(Projects::class)->findOneByNext($project->getDate());
        $previous = $em->getRepository(Projects::class)->findOneByPrevious($project->getDate());
        $slug = new Slugify();
        if ($next != null) {
            $next["title"] = $slug->slugify($next["title"]);
        }
        if ($previous != null) {
            $previous["title"] = $slug->slugify($previous["title"]);
        }
        var_dump($previous);
        return $this->render('base/lecture_projet.html.twig', array(
            'project' => $project,
            'next'    => $next,
            'previous' => $previous,
        ));
    }

    /**
     * @Route("/new-projet", name="projet")
     */
    public function new_projet(ManagerRegistry $doctrine, Request $request)
    {
        $projet = new Projects();
        $form = $this->createForm(ProjectType::class, $projet);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            #$projet->setType($type);
            $em->persist($projet);
            $em->flush();
            return $this->redirectToRoute('cms-projets');
        }
        return $this->render('base/addProject.html.twig', array(
            "form" => $form->createView(),
        ));
    }
    /**
     * @Route("/edit-project/{id}", name="edit-project")
     */
    public function edit_project(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->find($id);
        $saveGallery = new ArrayCollection();
        $filenames = array();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($project->getGallery() as $img) {
            $img->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $img->getFilename()));
        }
        foreach ($project->getGallery() as $img) {
            $filenames[$img->getId()] = $img->getFilename();
            $saveGallery->add($img);
        }
        // var_dump($filenames);
        $project->getBanner()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $project->getBanner()->getFilename()));
        $project->getMiniature()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $project->getMiniature()->getFilename()));
        $form = $this->createForm(ProjectType::class, $project);
        $saveProject = $project->getBanner()->getFilename();
        $saveMiniature = $project->getMiniature()->getFilename();
        // 2) handle the submit (will only happen on POST)

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            foreach ($data->getGallery() as $img) {
                if ($img->getFilename() == null) {
                    if (!empty($filenames[$img->getId()])) {
                        $img->setFilename($filenames[$img->getId()]);
                    }
                }
            }
            if ($data->getBanner()->getFilename() == null)
                $data->getBanner()->setFilename($saveProject);
            if ($data->getMiniature()->getFilename() == null)
                $data->getMiniature()->setFilename($saveMiniature);
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute("cms-projets");
        }
        // replace this line with your own code!
        // return $this->redirectToRoute('projets');
        return $this->render('base/editProject.html.twig', [
            "form" => $form->createView(),
            "project" => $project,
        ]);
    }


    /**
     * @Route("/get-projet",name="getProjet")
     */

    public function getProjet(Request $request, ManagerRegistry $doctrine)
    {
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $page = $contentDecode->page;
        $biens = $doctrine->getRepository(Projects::class)->myGetProjet($page);
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

    public function getProjetBYType(Request $request, ManagerRegistry $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        $page = $contentDecode->page;
        $selection = $doctrine->getRepository(Projects::class)->myGetProjetByType($type, intval($page));
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
    public function searchProjet(Request $request, ManagerRegistry $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $search = $contentDecode->searchText;
        $projets = $doctrine->getRepository(Projects::class)->myProjetSearch($search);
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
    public function countProjet(Request $request, ManagerRegistry $doctrine)
    {
        $user1 = $this->getUser();
        $request_stack = $this->container->get('request_stack');
        $request = $request_stack->getCurrentRequest();
        $content = $request->getContent();
        $contentDecode = json_decode($content);
        $type = $contentDecode->selection;
        if ($type != 'All')
            $count = $doctrine->getRepository(Projects::class)->myCountByTri($type);
        else
            $count = $doctrine->getRepository(Projects::class)->myCount();
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
     * @Route("delete-projet/{id}",name="delete-project")
     */
    public function deleteProjets($id)
    {
        $em = $this->getDoctrine()->getManager();
        $project = $em->getRepository(Projects::class)->findOneBy(array('id' => $id));
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('cms-projets');
    }


    /**
     * @Route("/new-technologie", name="new-technologie")
     */
    public function new_technologie(Request $request)
    {
        $technologie = new Technologies();
        $form = $this->createForm(TechnologieType::class, $technologie);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($technologie);
            $em->flush();
            return $this->redirectToRoute('cms-projets');
        }
        // replace this line with your own code!
        // return $this->redirectToRoute('projets');
        return $this->render('base/addTechnologie.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("edit-technologie/{id}",name="edit-technologie")
     */
    public function editTechnologie(ManagerRegistry $doctrine, Request $request, $id)
    {
        $techno = $doctrine->getRepository(Technologies::class)->find($id);
        $form = $this->createForm(TechnologieType::class, $techno);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($techno);
            $em->flush();
            return $this->redirectToRoute('cms-projets');
        }
        return $this->render('base/addTechnologie.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("delete-technologie/{id}",name="delete-technologie")
     */
    public function deleteTechnologie($id)
    {
        $em = $this->getDoctrine()->getManager();
        $technologie = $em->getRepository(Technologies::class)->findOneBy(array('id' => $id));
        $em->remove($technologie);
        $em->flush();
        return $this->redirectToRoute('technologie_gestion');
    }
}
