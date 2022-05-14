<?php

namespace App\DataFixtures;

use App\Entity\Section;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class StudentSectionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_EN');

        $section1 = new Section();
        $section1->setDesignation("CyberSecurity");
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setDesignation("Web Development");
        $manager->persist($section2);

        $section3 = new Section();
        $section3->setDesignation("Mobile Development");
        $manager->persist($section3);

        $section4 = new Section();
        $section4->setDesignation("IoT");
        $manager->persist($section4);

        //Students with a section
        for ($i=0;$i<20;$i++){
            $student = new Student();
            $student->setNom($faker->lastName);
            $student->setPrenom($faker->firstName);
            if ($i%4 == 0){
                $student->setSection($section1);
            }elseif ($i%4 == 1){
                $student->setSection($section2);
            }elseif ($i%4 == 2){
                $student->setSection($section3);
            }else{
                $student->setSection($section4);
            }
            $manager->persist($student);
        }

        //Student without a section
        for ($j=0;$j<10;$j++){
            $NStudent = new Student();
            $NStudent->setNom($faker->lastName);
            $NStudent->setPrenom($faker->firstName);
            $manager->persist($NStudent);
        }
        $manager->flush();
    }
}
