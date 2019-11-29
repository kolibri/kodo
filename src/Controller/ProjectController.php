<?php

declare(strict_types=1);

namespace App\Controller;

use App\Project\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    private $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /** @Route("/{name}") */
    public function project(string $name): Response
    {
        $project = $this->projectRepository->getProject($name);

        return $this->render('project/project.html.twig', ['project' => $project]);
    }

    /** @Route("/") */
    public function overview(): Response
    {
        return $this->render('project/overview.html.twig');
    }

    public function list(): Response
    {
        $projects = $this->projectRepository->getAllNames();

        return $this->render('project/list.html.twig', ['projects' => $projects]);
    }
}
