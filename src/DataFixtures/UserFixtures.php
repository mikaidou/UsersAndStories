<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class UserFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $user = new Users();
            $user->setUsername($faker->name);
            $user->setRole('admin');
            $manager->persist($user);
        }
    $manager->flush();
}
}