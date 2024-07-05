<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UxliveController extends AbstractController
{
    #[Route('/uxlive', name: 'app_uxlive')]
    public function index(): Response
    {
        return $this->render('uxlive/index.html.twig', [
            'controller_name' => 'UxliveController',
        ]);
    }
}
