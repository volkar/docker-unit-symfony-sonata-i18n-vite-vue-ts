<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $entityManagerInterface;
    private $mediaPool;

    public function __construct(EntityManagerInterface $entityManagerInterface, Pool $mediaPool)
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->mediaPool = $mediaPool;
    }

    #[Route('/api/{locale}/getCategory/{slug}', name: 'getCategory', methods: ['GET'])]
    public function getCategory($locale, $slug): Response
    {
        // Get default locale from services.yaml
        $defaultLocale = $this->getParameter('locale');

        // Get category repository
        $categoryRepository = $this->entityManagerInterface->getRepository(Category::class);
        // Get current category from repository
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        // Return project's data
        if ($category) {

            if ($locale === $defaultLocale) {
                // Default locale

                // Get projects of current category
                $docProjects = $category->getProjects();
                $projects = [];
                foreach($docProjects as $dp) {
                    $currentProject = [];
                    $currentProject['id'] = $dp->getId();
                    $picture = $dp->getPicture();
                    $provider = $this->mediaPool->getProvider($picture->getProviderName());
                    $publicUrl = $provider->generatePublicUrl($picture, 'default_small');
                    $currentProject['picture'] = $publicUrl;
                    $currentProject['title'] = $dp->getTitle();
                    $currentProject['content'] = $dp->getContent();
                    $projects[] = $currentProject;
                }
                return $this->json([
                    'id' => $category->getID(),
                    'slug' => $category->getSlug(),
                    'title' => $category->getTitle(),
                    'projects' => $projects,
                    'projects_count' => count($docProjects),
                ]);
            }
            // Translated content
            $translationRepository = $this->entityManagerInterface->getRepository('Gedmo\Translatable\Entity\Translation');

            // Get projects of current category
            $docProjects = $category->getProjects();
            $projects = [];
            foreach($docProjects as $dp) {
                $currentProject = [];
                $currentProject['id'] = $dp->getId();
                $picture = $dp->getPicture();
                $provider = $this->mediaPool->getProvider($picture->getProviderName());
                $publicUrl = $provider->generatePublicUrl($picture, 'default_small');

                $projectTranslations = $translationRepository->findTranslations($dp);
                $translatedProjectTitle = !empty($projectTranslations[$locale]['title']) ? $projectTranslations[$locale]['title'] : $dp->getTitle();
                $translatedProjectContent = !empty($projectTranslations[$locale]['content']) ? $projectTranslations[$locale]['content'] : $dp->getContent();

                $currentProject['picture'] = $publicUrl;
                $currentProject['title'] = $translatedProjectTitle;
                $currentProject['content'] = $translatedProjectContent;
                $projects[] = $currentProject;
            }

            $translations = $translationRepository->findTranslations($category);
            $translatedTitle = !empty($translations[$locale]['title']) ? $translations[$locale]['title'] : $category->getTitle();

            return $this->json([
                'id' => $category->getID(),
                'slug' => $category->getSlug(),
                'title' => $translatedTitle,
                'projects' => $projects,
                'projects_count' => count($docProjects),
            ]);
        }

        return $this->json([]);
    }

    #[Route('/api/{locale}/getCategories', name: 'getCategories', methods: ['GET'])]
    public function getCategories($locale): Response
    {
        // Get default locale from services.yaml
        $defaultLocale = $this->getParameter('locale');

        // Get category repository
        $categoryRepository = $this->entityManagerInterface->getRepository(Category::class);
        // Get all categories from repository
        $categories = $categoryRepository->findAll();

        $finalArrayOfCategories = [];

        if ($locale === $defaultLocale) {
            // Default locale
            foreach ($categories as $category) {
                $finalArrayOfCategories[] = [
                    'id' => $category->getID(),
                    'slug' => $category->getSlug(),
                    'title' => $category->getTitle(),
                    'projects_count' => count($category->getProjects()),
                ];
            }
        } else {
            // Translated content
            $translationRepository = $this->entityManagerInterface->getRepository('Gedmo\Translatable\Entity\Translation');

            foreach ($categories as $category) {

                $translations = $translationRepository->findTranslations($category);
                $translatedTitle = !empty($translations[$locale]['title']) ? $translations[$locale]['title'] : $category->getTitle();

                $finalArrayOfCategories[] = [
                    'id' => $category->getID(),
                    'slug' => $category->getSlug(),
                    'title' => $translatedTitle,
                    'projects_count' => count($category->getProjects()),
                ];
            }
        }

        // Return project's data
        return $this->json($finalArrayOfCategories);
    }
}
