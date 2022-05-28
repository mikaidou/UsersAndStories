<?php

namespace App\DataFixtures;

use App\Entity\Stories;
use App\Entity\Users;
use App\Entity\Reviews;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;


class StoriesFixtures extends Fixture
{

    public const USER_REFERENCE = 'user-mika';

    public function __construct(SluggerInterface $slugger)
    {
       $this->slugger =$slugger;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $date = new \DateTimeImmutable('@'.strtotime('now'));

        $users = $manager->getRepository(Users::class)->findAll();
        shuffle($users);

        for ($i = 0; $i < 20; $i++) {

            $user = new Users();
            $story = new Stories();
            $review = new Reviews();

           $story->setUsers($user);
           $review->setUsers($user);

           $user->setUsername($faker->name);

          $array = array(
            "ROLE_USER" => 1,
            "ROLE_ADMIN" => 2,
            "ROLE_MODO" => 3
        );


        $user->setRole('admin');
            $manager->persist($user);

            $review->setStories($story);
            $review->setContent($faker->text);
            $review->setCreatedAt($date);
            $review->setIsValidated(1);

            $story->setTitle('titre '.$i);
            $story->setSlug($this->slugger->slug($story->getTitle()));
            $story->setContent($faker->realText(50));
            $story->setCreatedAt($date);

            $manager->persist($review);
            $manager->persist($story);
        }
    $manager->flush();
}
public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}