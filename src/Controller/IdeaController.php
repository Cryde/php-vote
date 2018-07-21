<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @param Idea $idea
     *
     * @return Response
     */
    public function show(Idea $idea)
    {
        return $this->render('idea/show.html.twig', ['idea' => $idea,]);
    }
}
