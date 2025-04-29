<?php

namespace App\Controller;

use App\Entity\Session;
use App\Session\SessionObjectFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/session')]
class SessionController extends AbstractController
{
    public function __construct(
        private SessionObjectFactory $sessionObjectFactory
    ) {
    }

    #[Route('/retrieve', name: 'sessions_retrieve', methods: ['POST'])]
    public function retrieve(Request $request): JsonResponse
    {
        $input = $request->request->all();

        $sessionObject = $this->sessionObjectFactory->create($input);
        $sessionData = $sessionObject->retrieve();
        $sessionObject->prepare($sessionData);
        $data = $sessionObject->prepareViewFields();

        return $this->json($data);
    }

    #[Route('/store', name: 'sessions_store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $input = $request->request->all();

        $sessionObject = $this->sessionObjectFactory->create($input);
        $sessionObject->store($input);
        $data = $sessionObject->prepareViewFields();

        return $this->json($data);
    }

}
