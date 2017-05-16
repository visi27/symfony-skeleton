<?php

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(
            __DIR__.'/fixtures.yml',
            $manager,
            [
                'providers' => [$this],
            ]
        );
    }

    public function category()
    {
        $category = [
            'News',
            'How To',
            'Community',
            'Fun Facts',
            'Trivia',
            'Sport',
            'Q&A',
            'FAQ',
            'Technology'
        ];

        $key = array_rand($category);

        return $category[$key];
    }
}