<?php

namespace App\Controller\Admin;

use App\Entity\CampaignProduct;
use App\Form\CampaignProductType;
use App\Repository\CampaignProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/campaign/product')]
final class CampaignProductController extends AbstractController
{
    #[Route(name: 'app_campaign_product_index', methods: ['GET'])]
    public function index(CampaignProductsRepository $campaignProductsRepository): Response
    {
        return $this->render('campaign_product/index.html.twig', [
            'campaign_products' => $campaignProductsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_campaign_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $campaignProduct = new CampaignProduct();
        $form = $this->createForm(CampaignProductType::class, $campaignProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($campaignProduct);
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign_product/new.html.twig', [
            'campaign_product' => $campaignProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_product_show', methods: ['GET'])]
    public function show(CampaignProduct $campaignProduct): Response
    {
        return $this->render('campaign_product/show.html.twig', [
            'campaign_product' => $campaignProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_campaign_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CampaignProductType::class, $campaignProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_campaign_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('campaign_product/edit.html.twig', [
            'campaign_product' => $campaignProduct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_campaign_product_delete', methods: ['POST'])]
    public function delete(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$campaignProduct->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($campaignProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_campaign_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
