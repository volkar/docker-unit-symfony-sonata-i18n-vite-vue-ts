<?php

namespace App\DataFixtures;

use App\Entity\SonataMediaMedia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\File;

class SonataMediaMediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file1 = new File('public/static/p1.jpg');
        $Media1 = new SonataMediaMedia();
        $Media1->setName('p1.jpg');
        $Media1->setContext('default');
        $Media1->setProviderName('sonata.media.provider.image');
        $Media1->setBinaryContent($file1);
        $manager->persist($Media1);

        $file2 = new File('public/static/p2.jpg');
        $Media2 = new SonataMediaMedia();
        $Media2->setName('p2.jpg');
        $Media2->setContext('default');
        $Media2->setProviderName('sonata.media.provider.image');
        $Media2->setBinaryContent($file2);
        $manager->persist($Media2);

        $file3 = new File('public/static/p3.jpg');
        $Media3 = new SonataMediaMedia();
        $Media3->setName('p3.jpg');
        $Media3->setContext('default');
        $Media3->setProviderName('sonata.media.provider.image');
        $Media3->setBinaryContent($file3);
        $manager->persist($Media3);

        $file4 = new File('public/static/p4.jpg');
        $Media4 = new SonataMediaMedia();
        $Media4->setName('p4.jpg');
        $Media4->setContext('default');
        $Media4->setProviderName('sonata.media.provider.image');
        $Media4->setBinaryContent($file4);
        $manager->persist($Media4);

        $manager->flush();

        $this->addReference('media_1', $Media1);
        $this->addReference('media_2', $Media2);
        $this->addReference('media_3', $Media3);
        $this->addReference('media_4', $Media4);
    }
}
