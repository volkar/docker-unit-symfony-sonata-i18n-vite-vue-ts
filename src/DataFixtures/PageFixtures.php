<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $translationRepository = $manager->getRepository('Gedmo\\Translatable\\Entity\\Translation');

        $Page1 = new Page();
        $Page1->setTranslatableLocale('en');
        $Page1->setTitle('Index');
        $Page1->setSlug('index');
        $Page1->setContent('<p><strong>SPA @ <a href="https://vitejs.dev" target="_blank">Vite</a>/<a href="https://vuejs.org" target="_blank">Vue</a> & <a href="https://pinia.vuejs.org" target="_blank">Pinia</a><br>++<a href="https://symfony.com" target="_blank">Symfony</a></strong></p>');
        // Translation
        $translationRepository->translate($Page1, 'title', 'it', 'Indice');
        $translationRepository->translate($Page1, 'content', 'it', '<p><strong>SPA @ <a href="https://vitejs.dev" target="_blank">Vite</a>/<a href="https://vuejs.org" target="_blank">Vue</a> & <a href="https://pinia.vuejs.org" target="_blank">Pinia</a><br>++<a href="https://symfony.com" target="_blank">Symfony</a></strong></p>');
        $manager->persist($Page1);

        $Page2 = new Page();
        $Page2->setTranslatableLocale('en');
        $Page2->setTitle('About');
        $Page2->setSlug('about');
        $Page2->setContent('<p>GitHub <a href="https://github.com/volkar/docker-symfony-sonata-i18n-vite-vue-ts" target="blank">volkar/docker-symfony-sonata-i18n-vite-vue-ts</a><br>by <a href="https://volkar.ru" target="blank">Sergey Volkar</a></p>');
        // Translation
        $translationRepository->translate($Page2, 'title', 'it', 'Informazioni');
        $translationRepository->translate($Page2, 'content', 'it', '<p>GitHub <a href="https://github.com/volkar/docker-symfony-sonata-i18n-vite-vue-ts" target="blank">volkar/docker-symfony-sonata-i18n-vite-vue-ts</a><br>di <a href="https://volkar.ru" target="blank">Sergey Volkar</a></p>');
        $manager->persist($Page2);

        $manager->flush();

    }
}
