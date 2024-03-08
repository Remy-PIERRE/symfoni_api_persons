<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Category();
        $admin->setName('admin');
        $manager->persist($admin);

        $user = new Category();
        $user->setName('user');
        $manager->persist($user);

        $visitor = new Category();
        $visitor->setName('visitor');
        $manager->persist($visitor);

        $person_1 = new Person();
        $person_1->setFirstName('Rémy');
        $person_1->setLastName('Pierre');
        $person_1->setAge(37);
        $person_1->setCategory($admin);
        $manager->persist($person_1);

        $person_2 = new Person();
        $person_2->setFirstName('Justine');
        $person_2->setLastName('Pourteau');
        $person_2->setAge(25);
        $person_2->setCategory($user);
        $manager->persist($person_2);

        $person_3 = new Person();
        $person_3->setFirstName('Clémentine');
        $person_3->setLastName('Pierre-Pourteau');
        $person_3->setAge(1);
        $person_3->setCategory($visitor);
        $manager->persist($person_3);

        $manager->flush();
    }
}
