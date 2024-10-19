<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\UserFactory;
use App\Factory\AuthorFactory;
use App\Factory\EditorFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        // $product = new Product();
        // $manager->persist($product);

        AuthorFactory::createMany(50);
        EditorFactory::createMany(20);
        UserFactory::createMany(5);
        BookFactory::createMany(100);
        $manager->flush();
    }
}
