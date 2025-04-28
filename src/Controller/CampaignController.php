<?php

namespace App\Controller;

use App\Entity\Campaign;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampaignController extends AbstractController
{
    /**
     * @Route("/campaigns", name="campaigns_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $campaigns = $entityManager->getRepository(Campaign::class)->findAll();

        return $this->render('campaigns/index.html.twig', [
            'campaigns' => $campaigns,
        ]);
    }

    /**
     * @Route("/campaigns/create", name="campaigns_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');

            $campaign = new Campaign();
            $campaign->setName($name);

            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('campaigns_index');
        }

        return $this->render('campaigns/create.html.twig');
    }

    /**
     * @Route("/campaigns/{id}", name="campaigns_show", methods={"GET"})
     */
    public function show(Campaign $campaign): Response
    {
        return $this->render('campaigns/show.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @Route("/campaigns/{id}/edit", name="campaigns_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $campaign->setName($name);

            $entityManager->flush();

            return $this->redirectToRoute('campaigns_index');
        }

        return $this->render('campaigns/edit.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @Route("/campaigns/{id}/delete", name="campaigns_delete", methods={"POST"})
     */
    public function delete(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $campaign->getId(), $request->request->get('_token'))) {
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('campaigns_index');
    }
}
