<?php

namespace App\Controller;

use App\Repository\SubjectRepository;
use App\Repository\TutorialRepository;
use App\Repository\ChaptersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_index')]
    #[IsGranted(attribute: 'ROLE_admin')] 

    
    public function index(
        SubjectRepository $subjectRepository,
        TutorialRepository $tutorialRepository,
        ChaptersRepository $chapterRepository
    ): Response
    {
        return $this->render('admin/index.html.twig', [
            'subjects' => $subjectRepository->findAll(),
            'tutorials' => $tutorialRepository->findAll(),
            'chapters' => $chapterRepository->findAll(),
        ]);
    }
}
