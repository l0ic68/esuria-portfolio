<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1;$i < 11; $i++){
        $article = new Article();
        $article->setTitre('Article titre '. $i);
        $article->setTexte('Lorem Ipsum text '. $i);
        $manager->persist($article);
    }

        $manager->flush();
    }
}
