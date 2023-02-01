<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class UserFixture extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {
        
    }
    public function load(ObjectManager $manager): void
    {
        $admin1 = new User();
        $admin1->setEmail(email:'admin1@gmail.com');

        $admin2 = new User();
        $admin2->setEmail(email:'admin2@gmail.com');

        $manager->flush();
    }
}
