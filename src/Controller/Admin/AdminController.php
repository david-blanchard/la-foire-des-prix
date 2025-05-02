<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    #[Route(name: 'admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {

//        if(!$this->security->isGranted(AdminVoter::ADMIN_ROLE, $event)) {
//            return new Response('Access denied', 403);
//        }
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
