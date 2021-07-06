<?php

namespace App\Controller;

/**Entity necessary in order to make the page work */

use App\Entity\Hobbies;
use App\Entity\Biographie;
use App\Entity\Article;
use App\Entity\Image;
use App\Entity\Timeline;
use App\Entity\Event;
use App\Entity\SmallEvent;
use App\Entity\Projects;
use App\Entity\Technologies;
use App\Entity\Skill;
use App\Repository\HobbiesRepository;
use App\Service\FileUploader;
use App\Form\HobbiesType;
use App\Form\EventType;
use App\Form\SmallEventType;
use App\Form\SkillType;
use App\Form\BiographieType;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Persistence\ManagerRegistry;
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
    public function cms(ManagerRegistry $doctrine, Request $request)
    {
        $bio = $doctrine->getRepository(Biographie::class)->myFindFirst();
        $skills = $doctrine->getRepository(Skill::class)->FindAll();
        $form = $this->createForm(BiographieType::class, $bio);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            #$article->setType($type);
            $em->persist($bio);
            $em->flush();
            return $this->redirectToRoute('cms');
        }
        return $this->render('cms_base/cms_index.html.twig', array(
            "form" => $form->createView(),
            "skills" => $skills,

        ));
    }

    /**
     * @Route("/cms-projets", name="cms-projets")
     */
    public function cms_projets()
    {
        $em = $this->getDoctrine()->getManager();
        $projects = $em->getRepository(Projects::class)->findAll();
        $technologies = $em->getRepository(Technologies::class)->findAll();
        return $this->render('cms_base/cms_projets.html.twig', ["projects" => $projects,"technologies" => $technologies]);
    }


    /**
     * @Route("/cms-hobbies", name="cms-hobbies")
     */
    public function cms_hobbies(ManagerRegistry $doctrine)
    {
        $Hobbies = $doctrine->getRepository(Hobbies::class)->findAll();
        $album_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Album_Moment");
        $musique_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Musique_Moment");
        $jeu_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Jeux_Moment");
        $film_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Film_Moment");
        $serie_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Serie_Moment");
        $anime_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Anime_Moment");
        $livre_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Livre_Moment");
        $bd_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("BD_Moment");
        $manga_moment = $doctrine->getRepository(Hobbies::class)->findOneByType("Manga_Moment");
        $album_fav = $doctrine->getRepository(Hobbies::class)->findByType("Album_fav");
        $groupe_fav = $doctrine->getRepository(Hobbies::class)->findByType("Groupe_fav");

        return $this->render('cms_base/cms_hobbies.html.twig', [
            'Hobbies' => $Hobbies,
            'album_moment' => $album_moment,
            'musique_moment' => $musique_moment,
            'jeu_moment' => $jeu_moment,
            'film_moment' => $film_moment,
            'serie_moment' => $serie_moment,
            'anime_moment' => $anime_moment,
            'livre_moment' => $livre_moment,
            'bd_moment' => $bd_moment,
            'manga_moment' => $manga_moment,
            'album_fav' => $album_fav,
            'groupe_fav' => $groupe_fav,
        ]);
    }

    /**
     * @Route("/hobbies-new/{type}", name="hobbies-new")
     */
    public function new_hobbies(ManagerRegistry $doctrine, Request $request, $type, FileUploader $fileUploader)
    {
        $hobbie = new Hobbies();
        $image = new Image();
        $form = $this->createForm(HobbiesType::class, $hobbie);
        // $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $hobbie->setType($type);
            $em->persist($hobbie);
            $em->flush();
            return $this->redirectToRoute('cms-hobbies');
        }
        return $this->render('cms_base/new_hobbies.html.twig', ['hobbie' => $hobbie, 'form' => $form->createView()]);
    }

    /**
     * @Route("/new-event", name="new-event")
     */
    public function new_event(ManagerRegistry $doctrine, Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit-small-event/{id}", name="edit-small-event")
     */
    public function edit_smallEvent($id,ManagerRegistry $doctrine, Request $request)
    {
        $smallEvent = $doctrine->getRepository(SmallEvent::class)->find($id);
        $form = $this->createForm(SmallEventType::class, $smallEvent);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($smallEvent);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/delete-small-event/{id}", name="delete-small-event")
     */
     public function delete_smallEvent(ManagerRegistry $doctrine, Request $request, $id)
     {
         $smallEvent = $doctrine->getRepository(smallEvent::class)->find($id);
        //  $timeline = $doctrine->getRepository(Timeline::class)->findOneBySmallEvent(["id" => $id]);
         $em = $this->getDoctrine()->getManager();
        //  $em->remove($timeline);
         $em->remove($smallEvent);
         $em->flush();
         return $this->redirectToRoute('cms');
     }

    /**
     * @Route("/edit-event/{id}", name="edit-event")
     */
    public function edit_event($id,ManagerRegistry $doctrine, Request $request)
    {
        $event = $doctrine->getRepository(Event::class)->find($id);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/delete-event/{id}", name="delete-event")
     */
     public function delete_event(ManagerRegistry $doctrine, Request $request, $id)
     {
         $event = $doctrine->getRepository(Event::class)->find($id);
         $timeline = $doctrine->getRepository(Timeline::class)->findOneByEvent(["id" => $id]);
         $em = $this->getDoctrine()->getManager();
         foreach ($timeline->getSmallEvent() as $value)
         {
            $em->remove($value);
         }
         $em->remove($timeline);
         $em->remove($event);
         $em->flush();
         return $this->redirectToRoute('cms');
     }

    /**
     * @Route("/new-smallEvent/{id}", name="new-smallEvent")
     */
    public function new_smallEvent(ManagerRegistry $doctrine, Request $request, $id)
    {
        $smallEvent = new SmallEvent();
        $event = $doctrine->getRepository(Event::class)->findOneById($id);
        $form = $this->createForm(SmallEventType::class, $smallEvent);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $event->addSmallEvent($smallEvent);
            $em->persist($event);
            $em->persist($smallEvent);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("/new-skill", name="new-skill")
     */
    public function new_skill(ManagerRegistry $doctrine, Request $request)
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit-skill/{id}", name="edit-skill")
     */
    public function edit_skill(ManagerRegistry $doctrine, Request $request, $id)
    {
        $skill = $doctrine->getRepository(Skill::class)->find($id);
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($skill);
            $em->flush();
            return $this->redirectToRoute('cms');
        }

        return $this->render('cms_base/new_skill.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/delete-skill/{id}", name="delete-skill")
     */
    public function delete_skill(ManagerRegistry $doctrine, Request $request, $id)
    {
        $skill = $doctrine->getRepository(Skill::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($skill);
        $em->flush();
        return $this->redirectToRoute('cms');
    }

    /**
     * @Route("/hobbies-delete/{slug}-{id}", name="hobbies-delete", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function delete_hobbies(ManagerRegistry $doctrine, Request $request, $id)
    {
        $Hobbies = $doctrine->getRepository(Hobbies::class)->find($id);
        $em = $this->getDoctrine()->getManager();

        $em->remove($Hobbies);
        $em->flush();
        return $this->redirectToRoute('cms-hobbies');
    }

    /**
     * @Route("/upload-image", name="upload-image")
     */
    public function upload_image(ManagerRegistry $doctrine, Request $request)
    {
        if (isset($_FILES['upload']['name'])) {
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = rand() . '.' . $extension;
            // chmod('../../upload', 0777);
            $allowed_extension = array("jpg", "gif", "png");
            if (in_array($extension, $allowed_extension)) {
                move_uploaded_file($file, "../public/upload/" . $new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $url = '/upload/' . $new_image_name;
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
            }
            return new Response(200);
        }
    }

    /**
     * @Route("/cms-hobbies/{slug}-{id}", name="hobbies-show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show($slug, $id, ManagerRegistry $doctrine, Request $request)
    {
        $hobbie = $doctrine->getRepository(Hobbies::class)->find($id);
        $hobbie->getImage()->setFilename(new File($this->getParameter('uploadDirectory') . '/' . $hobbie->getImage()->getFilename()));
        $form = $this->createForm(HobbiesType::class, $hobbie);
        $saveHobbie = $hobbie->getImage()->getFilename();
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if ($data->getImage()->getFilename() == null)
                $data->getImage()->setFilename($saveHobbie);
            //   $Hobbies->setFilename("test");
            $em->persist($hobbie);
            $em->flush();
            return $this->redirectToRoute('cms-hobbies');
        }

        return $this->render('cms_base/show.html.twig', ['hobbie' => $hobbie, 'form' => $form->createView()]);
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
    public function cms_blog(ManagerRegistry $doctrine)
    {
        $articles = $doctrine->getRepository(Article::class)->myfindByNotAgenda();
        return $this->render('cms_base/cms_blog.html.twig', [
            "articles" => $articles,
        ]);
    }

    /**
     * @Route("/article-delete/{id}", name="article-delete")
     */
    public function delete_article(ManagerRegistry $doctrine, $id)
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
    public function cms_agenda(ManagerRegistry $doctrine)
    {
        $pastAgenda = $doctrine->getRepository(Article::class)->findPastAgenda();

        $futureAgenda = $doctrine->getRepository(Article::class)->findFutureAgenda();

        return $this->render('cms_base/cms_agenda.html.twig',[
            "pastAgenda" => $pastAgenda,
            "futureAgenda" => $futureAgenda,
        ]);
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
