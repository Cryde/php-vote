<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Idea;
use App\Form\CommentType;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends Controller
{
    /**
     * @Route("/ideas/latest", name="idea_latest")
     *
     * @param IdeaRepository $ideaRepository
     *
     * @return Response
     */
    public function latest(IdeaRepository $ideaRepository)
    {
        return $this->render(
            'idea/latest.html.twig',
            ['ideas' => $ideaRepository->findBy([], ['creationDatetime' => 'DESC'])]
        );
    }

    /**
     * @Route("/idea/{id}", name="idea_show")
     *
     * @param Request $request
     * @param Idea    $idea
     *
     * @return Response
     */
    public function show(Request $request, Idea $idea)
    {
        $comment = new Comment();
        $comment->setIdea($idea);
        $comment->setUser($this->getUser());

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        $isAuthenticate = $this->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isAuthenticate && $form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'idea_show',
                ['id' => $idea->getId(), '_fragment' => 'comment-' . $comment->getId()]
            );
        }

        return $this->render(
            'idea/show.html.twig',
            ['idea' => $idea, 'form' => $form->createView(), 'is_authenticate' => $isAuthenticate]
        );
    }
}
