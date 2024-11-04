<?php

namespace App\DataFixtures;

use App\Entity\Box;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BoxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //db setup for advent calendar
        for ($i = 1; $i <= 24; $i++) {
            $box = new Box();
            $box->setDescription("Vánoce, to úžasné období, kdy všichni předstírají, že se mají rádi, a utrácí peníze, které nemají, za dárky, které nikdo nechce. Krása rodinných setkání, kde se každý těší, až bude zase doma sám. Šťastné a veselé, že?");
            $box->setImageUrl("image.jpg");
            $box->setButtonText("Klikni na mě");
            $box->setButtonLink("https://example.com/link_$i");
            $box->setNumber($i);
            $manager->persist($box);
        }
        $manager->flush();
    }
}
