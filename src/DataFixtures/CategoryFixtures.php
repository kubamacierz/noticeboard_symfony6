<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();

        $category->setCategoryName('rozrywka');

        $manager->persist($category);

        $category2 = new Category();

        $category2->setCategoryName('pojazdy');

        $manager->persist($category2);
        $manager->flush();

        $this->addReference('category_1', $category);
        $this->addReference('category_2', $category2);

    }
}

