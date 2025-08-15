<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use App\Form\CampaignType;
use App\Repository\CampaignRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/campaign')]
final class CampaignController extends AbstractController
{
    #[Route(name: 'admin_campaign_index', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('admin/campaign/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/new', name: 'admin_campaign_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaign = new Campaign();
        if ($request->isMethod('POST')) {
            $campaign = new Campaign();
            $campaign->setName((string) $request->request->get('name'));
            $campaign->setStartsAt(new \DateTimeImmutable(date("Y-m-d H:i:s", (int) strtotime((string) $request->request->get('starts_at')))));
            $campaign->setEndsAt(new \DateTimeImmutable(date("Y-m-d H:i:s", (int) strtotime((string) $request->request->get('ends_at')))));
            $campaign->setDiscount((int) $request->request->get('discount'));

            $entityManager->persist($campaign);
            $entityManager->flush();

            return $this->redirectToRoute('admin_campaign_index', [
                'success' => 'La campagne a bien été enregistré !',
            ]);
        }

        return $this->render('admin/campaign/new.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @throws \DateMalformedStringException
     */
    #[Route('/{id}/edit', name: 'admin_campaign_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Campaign $campaign,
        EntityManagerInterface $entityManager
    ): Response {
        if ($request->isMethod('POST')) {
            $campaign->setName((string) $request->request->get('name'));
            $campaign->setStartsAt(new \DateTimeImmutable(date("Y-m-d H:i:s", (int) strtotime((string) $request->request->get('starts_at')))));
            $campaign->setEndsAt(new \DateTimeImmutable(date("Y-m-d H:i:s", (int) strtotime((string)$request->request->get('ends_at')))));
            $campaign->setDiscount((int) $request->request->get('discount'));

            $entityManager->flush();

            return $this->redirectToRoute('admin_campaign_index', [
                'success' => 'La campagne a bien été mise à jour !',
            ]);
        }

        return $this->render('admin/campaign/edit.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{id}', name: 'admin_campaign_delete', methods: ['POST'])]
    public function delete(Request $request, Campaign $campaign, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $campaign->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($campaign);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_campaign_index', [], Response::HTTP_SEE_OTHER);
    }
}
