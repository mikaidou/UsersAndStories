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

    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
        'Use Numbers',
        'Include the Word Guide',
        'Create a Curiosity Gap',
        'Titles That Solve a Problem',
        'Avoidance of Pain',
        'Promise Change',
        'Use Fear of Failure',
        'Use Negatives',
        'Use The Unusual Insight',
        'Make Bold Statements',
        'Make a Prediction',
        'Offer Help',
        'Use FOMO',
        'Use Secrets Of The Experts',
        'How To Do This Without Doing That',
        'Be Controversial',
        'Things I Wish I Had Known',
        'I Did It and So Can You',
        "Things You Didn't Know",
        'Start With The Word "Why"',
    ];

    public function __construct(SluggerInterface $slugger)
    {
       $this->slugger =$slugger;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $date = new \DateTimeImmutable('@'.strtotime('now'));

        $dateModified = new \DateTimeImmutable('@'.strtotime('2000-01-01'));


        for ($i = 0; $i < 20; $i++) {

            $user = new Users();
            $story = new Stories();
            $review = new Reviews();

           $story->setUsers($user);
           $review->setUsers($user);

           $user->setUsername($faker->name);

        /*  $array = array(
            "ROLE_USER" => 1,
            "ROLE_ADMIN" => 2,
            "ROLE_MODO" => 3
        );*/


        $user->setRole('admin');
            $manager->persist($user);

            $review->setStories($story);
            $review->setContent($faker->text);
            $review->setCreatedAt($date);
            $review->setModifiedOn($dateModified);
            $review->setIsValidated(1);

            $story->setTitle($faker->randomElement(self::$articleTitles));
            $story->setSlug($this->slugger->slug($story->getTitle()));
            $story->setContent($faker->realText(50));
            $story->setCreatedAt($date);
            $story->setModifiedOn($dateModified);

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