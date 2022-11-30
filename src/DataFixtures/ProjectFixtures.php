<?php

namespace App\DataFixtures;

use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $translationRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $project1 = new Project();
        $project1->setTranslatableLocale('en');
        $project1->setTitle('Identity project');
        $project1->setCategory($this->getReference('category_identity'));
        $project1->setContent('Description');
        $project1->setPicture($this->getReference('media_1'));
        // Translation
        $translationRepository->translate($project1, 'title', 'it', 'Progetto di identità');
        $translationRepository->translate($project1, 'content', 'it', 'Descrizione');
        $manager->persist($project1);

        $project2 = new Project();
        $project2->setTranslatableLocale('en');
        $project2->setTitle('Second identity project');
        $project2->setCategory($this->getReference('category_identity'));
        $project2->setContent('Description');
        $project2->setPicture($this->getReference('media_2'));
        // Translation
        $translationRepository->translate($project2, 'title', 'it', 'Secondo progetto di identità');
        $translationRepository->translate($project2, 'content', 'it', 'Descrizione');
        $manager->persist($project2);

        $project3 = new Project();
        $project3->setTranslatableLocale('en');
        $project3->setTitle('Digital project');
        $project3->setCategory($this->getReference('category_digital'));
        $project3->setContent('Description');
        $project3->setPicture($this->getReference('media_3'));
        // Translation
        $translationRepository->translate($project3, 'title', 'it', 'Progetto digitale');
        $translationRepository->translate($project3, 'content', 'it', 'Descrizione');
        $manager->persist($project3);


        $project4 = new Project();
        $project4->setTranslatableLocale('en');
        $project4->setTitle('Industrial project');
        $project4->setCategory($this->getReference('category_industrial'));
        $project4->setContent('Description');
        $project4->setPicture($this->getReference('media_4'));
        // Translation
        $translationRepository->translate($project4, 'title', 'it', 'Progetto industriale');
        $translationRepository->translate($project4, 'content', 'it', 'Descrizione');
        $manager->persist($project4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
            SonataMediaMediaFixtures::class,
        ];
    }
}
