<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
  /**
   * @Route("/default", name="default")
   */
  public function default()
  {
      return $this->render('base/index_nouveaute.html.twig');
  }
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('base/index.html.twig');
    }

    /**
     * @Route("/nouveaute", name="index_nouveaute")
     */
    public function index_nouveaute()
    {
        return $this->render('base/index_nouveaute.html.twig');
    }

    /**
     * @Route("/biographie", name="index_biographie")
     */
    public function index_biographie()
    {
        return $this->render('base/index_biographie.html.twig');
    }

    /**
     * @Route("/projets", name="projets")
     */
    public function projets()
    {
        return $this->render('base/projets.html.twig');
    }

    /**
     * @Route("/live", name="live")
     */
    public function live()
    {
        return $this->render('base/live.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        return $this->render('base/blog.html.twig');
    }

    /**
     * @Route("/agenda", name="agenda")
     */
    public function agenda()
    {
        return $this->render('base/agenda.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('base/contact.html.twig');
    }

    /**
     * @Route("/lecture_article", name="lecture_article")
     */
    public function lecture_article()
    {
        return $this->render('base/lecture_article.html.twig');
    }

    /**
     * @Route("/CMS", name="CMS")
     */
    public function CMS()
    {
        return $this->render('base/CMS.html.twig');
    }
}
