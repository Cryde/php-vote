<?php

namespace App\Controller;

use App\Repository\IdeaRepository;
use App\Repository\VoteRepository;
use App\Services\Helper\VoteHelper;
use App\Services\IdeaStatusBadgeDefiner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @param IdeaRepository         $ideaRepository
     * @param IdeaStatusBadgeDefiner $ideaStatusBadgeDefiner
     * @param VoteRepository         $voteRepository
     * @param VoteHelper             $voteHelper
     *
     * @return Response
     */
    public function index(
        IdeaRepository $ideaRepository,
        IdeaStatusBadgeDefiner $ideaStatusBadgeDefiner,
        VoteRepository $voteRepository,
        VoteHelper $voteHelper
    ) {
        $ideas            = $ideaRepository->findBy([], ['creationDatetime' => 'DESC']);
        $currentUserVotes = $voteRepository->findBy(['user' => $this->getUser(), 'idea' => $ideas]);

        return $this->render(
            'home/index.html.twig', [
                'ideas'              => $ideas,
                'badge_definer'      => $ideaStatusBadgeDefiner,
                'current_user_votes' => $voteHelper->toArrayWithIdeaIdAsKey($currentUserVotes),
                'is_authenticate'    => $this->isGranted('IS_AUTHENTICATED_REMEMBERED')
            ]
        );
    }
}
