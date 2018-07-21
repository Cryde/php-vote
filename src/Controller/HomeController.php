<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\IdeaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);

        $form->handleRequest($request);

        $isAuthenticate = $this->isGranted('IS_AUTHENTICATED_FULLY');

        if ($isAuthenticate && $form->isSubmitted() && $form->isValid()) {
            $idea->setUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($idea);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('idea_show', ['id' => $idea->getId()]);
        }

        return $this->render(
            'home/index.html.twig',
            ['form' => $form->createView(), 'is_authenticate' => $isAuthenticate]
        );
    }
}
