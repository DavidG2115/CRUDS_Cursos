<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    // #[Route('/', name: 'app_home')]
    #[Route('/{_locale}', name: 'app_home', requirements: ['_locale' => 'en|es'], defaults: ['_locale' => 'en'])]

    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
