<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoticesController extends AbstractController
{
    #[Route('/notices', name: 'notices')]
    public function index(): Response
    {
        $notices = ['ksiazka', 'grzyb', 'robak'];

        return $this->render('index.html.twig', ['notices' => $notices]);
    }

}
