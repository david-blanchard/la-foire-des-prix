<?php

namespace App\Controller\Admin;

use App\Entity\Campaign;
use App\Entity\CampaignProduct;
use App\Repository\CampaignRepository;
use App\Repository\CampaignProductsRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/campaign/product')]
final class CampaignProductController extends AbstractController
{
    public function __construct(
        private readonly CampaignProductsRepository $campaignProductsRepository,
        private readonly ProductRepository          $productRepository,
    )
    {
    }

    #[Route(name: 'admin_campaign_product_index', methods: ['GET'])]
    public function index(CampaignRepository $campaignRepository): Response
    {
        return $this->render('admin/campaign_product/index.html.twig', [
            'campaigns' => $campaignRepository->findAll(),
        ]);
    }

    #[Route('/create/{id}', name: 'admin_campaign_product_create', methods: ['GET', 'POST'])]
    public function create(Campaign $campaign, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $productId = $request->request->get('product');
            $product = $this->productRepository->find($productId);

            $campaignProduct = new CampaignProduct();
            $campaignProduct->setCampaign($campaign);
            $campaignProduct->setProduct($product);

            $entityManager->persist($campaignProduct);
            $entityManager->flush();

            return $this->redirectToRoute('admin_campaign_product_create', [
                'id' => $campaign->getId(),
                'success' => 'Les produits ont bien été ajoutés à la campagne !',
            ]);
        }


//        $campaigns = [];
//        foreach ($allCampaignProducts as $item) {
//            if (!isset($campaigns[$item->getCampaign()->getId()])) {
//                $campaigns[$item->getCampaign()->getId()] = [];
//                $campaigns[$item->getCampaign()->getId()]['id'] = $item->getId();
//                $campaigns[$item->getCampaign()->getId()]['campaign'] = $item->getCampaign();
//                $campaigns[$item->getCampaign()->getId()]['products'] = [];
//            }
//            $campaigns[$item->getCampaign()->getId()]['products'][] = $item->getProduct();
//        }

        $associatedProducts = $this->campaignProductsRepository->findProductsByCampaignId((int)$campaign->getId());

        return $this->render('admin/campaign_product/create.html.twig', [
            'campaign' => $campaign,
            'assocProducts' => $associatedProducts,
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'admin_campaign_product_show', methods: ['GET'])]
    public function show(CampaignProduct $campaignProduct): Response
    {
        return $this->render('admin/campaign_product/show.html.twig', [
            'campaign_product' => $campaignProduct,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_campaign_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        return $this->render('admin/campaign_product/edit.html.twig', [
            'campaign_product' => $campaignProduct,
        ]);
    }

    #[Route('/{id}', name: 'admin_campaign_product_delete', methods: ['POST'])]
    public function delete(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $campaignProduct->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($campaignProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_campaign_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
