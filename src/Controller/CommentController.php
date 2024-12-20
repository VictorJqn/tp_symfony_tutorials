<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Chapters;
use App\Repository\ChaptersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;



class CommentController extends AbstractController
{
    #[Route('/comment/create/{chapterId}', name: 'comment_create')]


    public function createComment(ChaptersRepository $chaptersRepository, int $chapterId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $chapter = $chaptersRepository->find($chapterId);

        if (!$chapter) {
            throw $this->createNotFoundException('Le chapitre n\'a pas été trouvé');
        }

        $comment = new Comments();
        $comment->setChapter($chapter);
        $comment->setAuthor($this->getUser());

        $content = $request->request->get('content');

        if ($content) {
            $comment->setContent($content);
            $comment->setPublishedAt(new \DateTimeImmutable());

            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_chapters_show', ['id' => $chapterId]);
    }
}
