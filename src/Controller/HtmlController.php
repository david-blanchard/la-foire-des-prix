<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HtmlController extends AbstractController
{
    #[Route('/html')]
    public function index(): Response
    {
        return $this->render('html/index.html.twig');
    }

    #[Route('/html/first')]
    public function first(): Response
    {
        return $this->render('html/first.html.twig');
    }

    #[Route('/html/second')]
    public function second(): Response
    {
        return $this->render('html/second.html.twig');
    }

    #[Route('/html/third')]
    public function third(): Response
    {
        return $this->render('html/third.html.twig');
    }
}
