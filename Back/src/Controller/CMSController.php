<?php

namespace App\Controller;

use App\Entity\Hobbies;
use App\Entity\Article;
use App\Repository\HobbiesRepository;
use App\Service\FileUploader;
use App\Form\HobbiesType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class CMSController extends Controller
{
    /**
     * @Route("/cms", name="cms")
     */
    public function cms()
    {
        return $this->render('cms_base/cms_index.html.twig');
    }

    /**
     * @Route("/cms-projets", name="cms-projets")
     */
    public function cms_projets()
    {
        return $this->render('cms_base/cms_projets.html.twig');
    }


    /**
     * @Route("/cms-hobbies", name="cms-hobbies")
     */
    public function cms_hobbies(RegistryInterface $doctrine)
    {
      $Hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
      $album_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Album_Moment");
      $musique_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Musique_Moment");
      $album_fav = $doctrine->getRepository(Hobbies::class)->findByType("Album_fav");
      $groupe_fav = $doctrine->getRepository(Hobbies::class)->findByType("Groupe_fav");

      return $this->render('cms_base/cms_hobbies.html.twig', [
            'Hobbies' => $Hobbies,
            'album_moment' => $album_moment,
            'musique_moment' => $musique_moment,
            'album_fav' => $album_fav,
            'groupe_fav' => $groupe_fav,
            ]);
    }

    /**
     * @Route("/hobbies-new/{type}", name="hobbies-new")
    */
    public function new_hobbies(RegistryInterface $doctrine, Request $request,$type,FileUploader $fileUploader)
    {
        $hobbies = new Hobbies();
        $form = $this->createForm(HobbiesType::class, $hobbies);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid())
        {
             // $file stores the uploaded PDF file
            $file = $hobbies->getThumbnail();
            $fileName = $fileUploader->upload($file);
            $hobbies->setThumbnail($fileName);
            $hobbies->setType($type);
            $em->persist($hobbies);
            $em->flush();
            return $this->redirectToRoute('cms-hobbies');
        }

        return $this->render('cms_base/new_hobbies.html.twig', ['hobbies' => $hobbies, 'form' => $form->createView()]);
    }

    /**
     * @Route("/cms-hobbies/{id}", name="hobbies-show")
    //  * @Route("/cms-hobbies/{slug}-{id}", name="hobbies-show", requirements={"slug": "[a-z0-9\-]*"})
    */
    public function show($slug, $id, RegistryInterface $doctrine, Request $request)
    {
        $Hobbies = $doctrine->getRepository(Hobbies::class)->find($id);
        $Hobbies->setThumbnail(
            new File($this->getParameter('uploadDirectory').'/'.$Hobbies->getThumbnail())
        );
        $form = $this->createForm(HobbiesType::class, $Hobbies);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid())
        {
        //   $Hobbies->setFilename("test");
          $em->persist($Hobbies);
          $em->flush();
          return $this->redirectToRoute('cms-hobbies');
        }

        return $this->render('cms_base/show.html.twig', ['Hobbies' => $Hobbies, 'form' => $form->createView()]);
    }

    /**
     * @Route("/cms-live", name="cms-live")
     */
    public function cms_live()
    {
        return $this->render('cms_base/cms_live.html.twig');
    }

    /**
     * @Route("/cms-blog", name="cms-blog")
     */
    public function cms_blog(RegistryInterface $doctrine)
    {
	$articles = $doctrine->getRepository(Article::class)->findAll(); 
        return $this->render('cms_base/cms_blog.html.twig',[
	"articles" => $articles,
	]);
    }

    /**
     * @Route("/article-delete/{id}", name="article-delete")
     */
    public function delete_article(RegistryInterface $doctrine,$id)
    {
	$em  = $this->getDoctrine()->getManager();
	$article = $doctrine->getRepository(Article::class)->find($id);
	$em->remove($article);
	$em->flush(); 
        return $this->redirectToRoute("cms-blog");
    }

    /**
     * @Route("/cms-agenda", name="cms-agenda")
     */
    public function cms_agenda()
    {
        return $this->render('cms_base/cms_agenda.html.twig');
    }

    /**
     * @Route("/cms-contact", name="cms-contact")
     */
    public function cms_contact()
    {
        return $this->render('cms_base/cms_contact.html.twig');
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
