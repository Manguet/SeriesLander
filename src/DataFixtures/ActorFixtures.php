<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln' => [
            'program' => [
                "program_0",
                "program_5",
            ]
        ],
        'Norman Reedus' => [
            'program' => [
                "program_0",
            ],
        ],
        'Lauren Cohan' => [
            'program' => [
                "program_0",
                ],
        ],
        'Danai Gurira' => [
            'program' => [
                "program_0",
                ],
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $actorName => $data) {
            $actor = new Actor();
            $actor->setName($actorName);
            foreach ($data['program'] as $movie) {
                $actor->addProgram($this->getReference($movie));
            }
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}