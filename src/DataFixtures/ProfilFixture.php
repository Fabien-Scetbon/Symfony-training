<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Profil;


class ProfilFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
            $profil = new Profil();
            $profil->setReseausocial(reseausocial: 'Facebook');
            $profil->setUrl(url: 'https://www.facebook.com/Jacky');

            $profil1 = new Profil();
            $profil1->setReseausocial(reseausocial: 'Twitter');
            $profil1->setUrl(url: 'https://www.twitter.com/Jacky');

            $profil2 = new Profil();
            $profil2->setReseausocial(reseausocial: 'LinkedIn');
            $profil2->setUrl(url: 'https://www.linkedin.com/Jacky');

            $profil3 = new Profil();
            $profil3->setReseausocial(reseausocial: 'Github');
            $profil3->setUrl(url: 'https://www.github.com/Jacky');

            $manager->persist($profil);
            $manager->persist($profil1);
            $manager->persist($profil2);
            $manager->persist($profil3);

        $manager->flush();
    }
}
