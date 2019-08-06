<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Hobbies;
use App\Entity\Biographie;
use App\Entity\Timeline;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;


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
     * @Route("/", name="accueil")
     */
    public function index(RegistryInterface $doctrine)
    {
        $bio = $doctrine->getRepository(Biographie::class)->myFindFirst();

        return $this->render('base/index.html.twig', array(
            "bio" => $bio
        ));
    }

    /**
     * @Route("/get-timeline",name="getTimeline")
     */

    public function getTimeline(Request $request, RegistryInterface $doctrine)
    {
        $timeline = $doctrine->getRepository(Timeline::class)->myFindByOrder();
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        // Add Circular reference handler
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($timeline, 'json');

        $response = new JsonResponse();
        $response->setData($jsonContent);
        return $response;
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
     * @Route("/hobbies", name="hobbies")
     */
    public function hobbies(RegistryInterface $doctrine)
    {
        $hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
        $album_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Album_Moment");
        $musique_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Musique_Moment");
        $album_fav = $doctrine->getRepository(Hobbies::class)->findByType("Album_fav");
        $groupe_fav = $doctrine->getRepository(Hobbies::class)->findByType("Groupe_fav");
        return $this->render('base/hobbies_musique.html.twig', [
            "hobbies" => $hobbies,
            "album_moment" => $album_moment,
            "musique_moment" => $musique_moment,
        ]);
    }

    /**
     * @Route("/hobbies-jeux", name="hobbiesJeux")
     */
    public function hobbiesJeux(RegistryInterface $doctrine)
    {
        $hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
        $jeu_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Jeux_Moment");
        return $this->render('base/hobbies_jeux.html.twig', [
            "hobbies" => $hobbies,
            "jeu_moment" => $jeu_moment,
        ]);
    }

    /**
     * @Route("/hobbies-film", name="hobbiesFilm")
     */
    public function hobbiesFilm(RegistryInterface $doctrine)
    {
        $hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
        $film_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Film_Moment");
        $serie_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Serie_Moment");
        $anime_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Anime_Moment");
        return $this->render('base/hobbies_film.html.twig', [
            "hobbies" => $hobbies,
            "film_moment" => $film_moment,
            "serie_moment" => $serie_moment,
            "anime_moment" => $anime_moment,
        ]);
    }

    /**
     * @Route("/hobbies-livre", name="hobbiesLivre")
     */
    public function hobbiesLivre(RegistryInterface $doctrine)
    {
        $hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
        $livre_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Livre_Moment");
        $bd_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("BD_Moment");
        $manga_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Manga_Moment");
        return $this->render('base/hobbies_livre.html.twig', [
            "hobbies" => $hobbies,
            "livre_moment" => $livre_moment,
            "bd_moment" => $bd_moment,
            "manga_moment" => $manga_moment,
        ]);
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
     * @Route("/CMS", name="CMS")
     */
    public function CMS()
    {
        return $this->render('base/CMS.html.twig');
    }
}
