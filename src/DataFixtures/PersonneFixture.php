<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PersonneFixture extends Fixture    // erreurs mais ça marche
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create( locale: 'fr_FR');  // on peut changer de pays pour adapter les fakers

        for ($i=0; $i<100; $i++) {
            $personne = new Personne();
            $personne->setFirstname( $faker->firstname );
            $personne->setLastname( $faker->lastname );
            $personne->setAge( $faker->numberBetween(18, 65));

            $manager->persist($personne);
        }

        $manager->flush();
    }
}
