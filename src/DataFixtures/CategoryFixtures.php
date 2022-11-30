<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $translationRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $category1 = new Category();
        $category1->setTranslatableLocale('en');
        $category1->setTitle('Brand identity');
        $category1->setSlug('brand');
        // Translation
        $translationRepository->translate($category1, 'title', 'it', 'Identità aziendale');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setTranslatableLocale('en');
        $category2->setTitle('Digital design');
        $category2->setSlug('digital');
        // Translation
        $translationRepository->translate($category2, 'title', 'it', 'Progettazione digitale');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setTranslatableLocale('en');
        $category3->setTitle('Industrial design');
        $category3->setSlug('industrial');
        // Translation
        $translationRepository->translate($category3, 'title', 'it', 'Design industriale');
        $manager->persist($category3);

        $manager->flush();

        $this->addReference('category_identity', $category1);
        $this->addReference('category_digital', $category2);
        $this->addReference('category_industrial', $category3);
    }
}
