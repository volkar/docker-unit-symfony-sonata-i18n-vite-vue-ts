<?php

namespace App\Controller;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;
    }

    #[Route('/api/{locale}/getPage/{slug}', name: 'page', methods: ['GET'])]
    public function index($locale, $slug): Response
    {
        // Get default locale from services.yaml
        $defaultLocale = $this->getParameter('locale');

        // Get page repository
        $pageRepository = $this->entityManagerInterface->getRepository(Page::class);
        // Get current page from repository
        $page = $pageRepository->findOneBy(['slug' => $slug]);
        // Return page data
        if ($page) {

            if ($locale === $defaultLocale) {
                // Default locale
                return $this->json([
                    'id' => $page->getID(),
                    'slug' => $page->getSlug(),
                    'title' => $page->getTitle(),
                    'content' => $page->getContent(),
                ]);
            }

            // Translated content
            $translationRepository = $this->entityManagerInterface->getRepository('Gedmo\Translatable\Entity\Translation');
            $translations = $translationRepository->findTranslations($page);

            $translatedTitle = !empty($translations[$locale]['title']) ? $translations[$locale]['title'] : $page->getTitle();
            $translatedContent = !empty($translations[$locale]['content']) ? $translations[$locale]['content'] : $page->getContent();

            return $this->json([
                'id' => $page->getID(),
                'slug' => $page->getSlug(),
                'title' => $translatedTitle,
                'content' => $translatedContent,
            ]);
        }

        return $this->json([]);
    }
}
