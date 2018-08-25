<?php

namespace App\Controller;

use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @param IdeaRepository $ideaRepository
     *
     * @return Response
     */
    public function index(IdeaRepository $ideaRepository)
    {
        return $this->render(
            'home/index.html.twig',
            ['ideas' => $ideaRepository->findBy([], ['creationDatetime' => 'DESC'])]
        );
    }
}
