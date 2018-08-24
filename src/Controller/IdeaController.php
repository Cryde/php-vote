<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Idea;
use App\Entity\User;
use App\Form\CommentType;
use App\Form\IdeaType;
use App\Repository\IdeaRepository;
use App\Repository\VoteRepository;
use App\Services\Helper\CommentHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param Request        $request
     * @param Idea           $idea
     * @param VoteRepository $voteRepository
     * @param CommentHelper  $commentHelper
     *
     * @return RedirectResponse|Response
     */
    public function show(Request $request, Idea $idea, VoteRepository $voteRepository, CommentHelper $commentHelper)
    {
        $comment = new Comment();
        $comment->setIdea($idea);
        $comment->setUser($this->getUser());
        $comment->setContent("Join the discussion...\n\nThis is **markdown** ! ");

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        $isAuthenticate = $this->isGranted('IS_AUTHENTICATED_REMEMBERED');

        $currentUserVote = $voteRepository->findOneBy(['user' => $this->getUser(), 'idea' => $idea]);

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
            [
                'idea'              => $idea,
                'comments'          => $idea->getComments(),
                'comment_votes'     => $commentHelper->getFormattedVoteByUser($idea->getComments(), $this->getUser()),
                'form'              => $form->createView(),
                'is_authenticate'   => $isAuthenticate,
                'current_user_vote' => $currentUserVote,
            ]
        );
    }

    /**
     * @Route("/idea/{id}/edit", name="idea_edit")
     *
     * @param Request $request
     * @param Idea    $idea
     *
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Idea $idea)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        if ($idea->getUser()->getId() !== $this->getUser()->getId()) {
            return $this->redirectToRoute('idea_show', ['id' => $idea->getId()]);
        }

        $form = $this->createForm(IdeaType::class, $idea);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idea->setUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($idea);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('idea_show', ['id' => $idea->getId()]);
        }

        return $this->render('idea/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/ideas/user", name="ideas_by_user")
     *
     * @return Response
     */
    public function listByUser()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        /** @var User $user */
        $user = $this->getUser();

        return $this->render(
            'idea/user_ideas.html.twig',
            ['ideas' => $user->getIdeas()]
        );
    }
}
