<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Projects;
use App\Entity\Image;
use App\Entity\Skill;
use App\Entity\Biographie;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for($i = 1;$i < 100; $i++){
            $img = new Image();
            $img->setAlt("article" . $i);
            $img->setFilename("gta5.jpeg");
            $img->setPath("uploads/Thumnail/gta5.jpeg");
            $article = new Article();
            $article->setTitre('Article titre '. $i);
            $article->setTexte('Lorem Ipsum text '. $i);
            $article->setDescription('Lorem Ipsum text '. $i);
            $article->setType(self::getRandomSelection());
            $article->setPath('article-titre-'.$i);
            $article->setImage($img);
            $manager->persist($article);
            $manager->persist($img);
        }
        for($i = 1;$i < 100; $i++){
            $projet = new Projects();
            $projet->setTitre('Projet titre '. $i);
            $projet->setTexte('Lorem Ipsum text '. $i);
            $projet->setType(self::getRandomSelection());
            $projet->setPath('projet-titre-'.$i);
            $manager->persist($projet);
        }
        $skill = new Skill();
        $skill->setName("Expérience Utilisateur");
        $skill->setIcone("fal fa-sitemap");
        $manager->persist($skill);
        $skill = new Skill();
        $skill->setName("Interface Utilisateur");
        $skill->setIcone("fal fa-paint-brush");
        $manager->persist($skill);
        $skill = new Skill();
        $skill->setName("HTML5 / CSS3");
        $skill->setIcone("fab fa-html5");
        $manager->persist($skill);
        $skill = new Skill();
        $skill->setName("Réseaux Sociaux");
        $skill->setIcone("fal fa-share-alt");
        $manager->persist($skill);
        $skill = new Skill();
        $skill->setName("Audiovisuel");
        $skill->setIcone("fal fa-video");
        $manager->persist($skill);
        $skill = new Skill();
        $skill->setName("Hardware");
        $skill->setIcone("fal fa-cog");
        $manager->persist($skill);

        $bio = new Biographie();
        $bio->setNom("Klein");
        $bio->setPrenom("thomas");
        $bio->setPresentation("Bonjour thomas");
        $bio->setParcours("Bonjour thomas");
        $bio->setAge(21);
        $bio->setTaille(21);
        $bio->setLieu("Moselle");
        $bio->setLangues("Moselle");
        $bio->setPolitique("Moselle");


        // $bio->setCompetence("Bonjour thomas");
        $bio->setPrenom("fal fa-sitemap");
        $manager->persist($bio);


        $manager->flush();
    }

    public static function getRandomSelection()
    {
        $rand = random_int(0,3);
        $selection= ['realisation','ecriture','personnel','professionnel'];
        return $selection[$rand];

    }
}
