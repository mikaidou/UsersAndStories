<?php

namespace App\DataFixtures;

use App\Entity\Reviews;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class ReviewsFixtures extends Fixture
{
    public const USER_REFERENCE = 'user-mika';


    public function load(ObjectManager $manager)
    {
        $date = new \DateTimeImmutable('@'.strtotime('now'));

        $faker = Faker\Factory::create();
        $users = $manager->getRepository(Users::class)->findAll();
        shuffle($users);
        for ($i = 0; $i < 20; $i++) {
            $review = new Reviews();
         //   $user = new Users();
           //   $review->setUsers($user);
         //     $this->addReference(self::USER_REFERENCE, $users);

              //$review->addReference($users);
          //  $review->setContent($faker->text);
           // $review->setCreatedAt($date);
            //$review->setIsValidated(1);
            //$manager->persist($review);
        }
    $manager->flush();
}
}