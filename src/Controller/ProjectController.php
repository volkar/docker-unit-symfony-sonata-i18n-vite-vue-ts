<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\MediaBundle\Provider\Pool;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private $entityManagerInterface;
    private $mediaPool;

    public function __construct(EntityManagerInterface $entityManagerInterface, Pool $mediaPool)
    {
        $this->entityManagerInterface = $entityManagerInterface;
        $this->mediaPool = $mediaPool;
    }

    #[Route('/api/getProject/{id}', name: 'project', methods: ['GET'])]
    public function index($id): Response
    {
        // Get projects repository
        $projectRepository = $this->entityManagerInterface->getRepository(Project::class);
        // Get current project from repository
        $project = $projectRepository->find($id);

        $picture = $project->getPicture();
        $provider = $this->mediaPool->getProvider($picture->getProviderName());
        $publicUrl = $provider->generatePublicUrl($picture, 'default_large');

        // Return project's data
        return $this->json([
            'id' => $project->getID(),
            'title' => $project->getTitle(),
            'type_id' => $project->getType()->getID(),
            'type_slug' => $project->getType()->getSlug(),
            'picture' => $publicUrl,
            'content' => $project->getContent(),
        ]);
    }
}
