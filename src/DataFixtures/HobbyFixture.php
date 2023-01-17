<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Hobby;


class HobbyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $datas = [
            "VTT",
            "Yoga",
            "Fitness",
            "Lecture",
            "Voyages",
            "Timbres",
            "Cinéma",
            "Shopping",
            "Cuisine",
            "Photo",
            "Balades"
        ];

        for ($i=0; $i<count($datas); $i++) {
            $hobby = new Hobby();
            $hobby->setDesignation($datas[$i]);
            $manager->persist($hobby);
        }

        $manager->flush();
    }
}
