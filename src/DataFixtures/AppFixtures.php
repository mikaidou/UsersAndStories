<?php

namespace App\DataFixtures;

use App\Entity\Stories;
use App\Entity\Users;
use App\Entity\Reviews;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\String\Slugger\SluggerInterface;


class AppFixtures extends Fixture
{
  /**
    * @var \Symfony\Component\String\Slugger\SluggerInterface
    */
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
       $this->slugger =$slugger;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $date = new \DateTimeImmutable('@'.strtotime('now'));

        $dateModified = new \DateTimeImmutable('@'.strtotime('2000-01-01'));
        $arrayCategories = [
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

            for($j = 1; $j <= 10; $j++){
                $user = new Users();
                $story = new Stories();
                $review = new Reviews();

                $user->setUsername($faker->name);
                $user->setRole('admin');

                $story->setTitle($faker->randomElement($arrayCategories));
                $story->setContent($faker->realText(50));
                $story->setSlug($this->slugger->slug($story->getTitle()));
                $story->setUsers($user);

   
   
                
                $review->setStories($story);
                $review->setContent($faker->text);
                $review->setIsValidated(1);
                $review->setUsers($user);

            
                $user->setRole('admin');
                $manager->persist($review);
                $manager->persist($story);
                $manager->persist($user);

            }
            $manager->flush();
        }
    }
