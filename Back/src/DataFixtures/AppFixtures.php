<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1;$i < 100; $i++){
            $article = new Article();
            $article->setTitre('Article titre '. $i);
            $article->setTexte('Lorem Ipsum text '. $i);
            $article->setType(self::getRandomSelection());
            $manager->persist($article);
        }

        $manager->flush();
    }

    public static function getRandomSelection()
    {
        $rand = random_int(0,3);
        $selection= ['realisation','ecriture','personnel','professionel'];
        return $selection[$rand];

    }
}
