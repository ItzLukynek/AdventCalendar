<?php

namespace App\DataFixtures;

use App\Entity\Settings;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SettingsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //db setup for default settings of the page
        $settings = new Settings();

        $settings->setAuth(true);
        $settings->setBgImageUrl('tree.jpg');
        $settings->setTitle('Adventní kalendář');
        $settings->setMainSettings(true);

        $manager->persist($settings);
        $manager->flush();
    }
}
