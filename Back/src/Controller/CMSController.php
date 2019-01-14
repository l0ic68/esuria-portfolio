<?php

namespace App\Controller;

use App\Entity\Hobbies;
use App\Repository\HobbiesRepository;
use App\Form\HobbiesType;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
    /*   $Hobbies_01 = new Hobbies();
      $Hobbies_01->setType('Musique')
        ->setLink('https://youtu.be/63oAtzYeQpE');
      $em = $this->getDoctrine()->getManager();
      $em->persist($Hobbies_01);
      $em->flush(); */
      $Hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
      dump($Hobbies);
      $em = $this->getDoctrine()->getManager();
      $form = $this->createForm(HobbiesType::class, $Hobbies);
      return $this->render('cms_base/cms_hobbies.html.twig', ['Hobbies' => $Hobbies, 'form' => $form->createView()]);
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
    public function cms_blog()
    {
        return $this->render('cms_base/cms_blog.html.twig');
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
}
