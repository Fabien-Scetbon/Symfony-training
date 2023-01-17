<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Job;


class JobFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $datas = [
            "Data scientist",
            "Medecin",
            "Policier",
            "Professeur",
            "Boulanger",
            "Agriculteur",
            "Dealer",
            "Livreur"
        ];

        for ($i=0; $i<count($datas); $i++) {
            $job = new Job();
            $job->setDesignation($datas[$i]);
            $manager->persist($job);
        }

        $manager->flush();
    }
}
