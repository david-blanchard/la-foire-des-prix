<?php

namespace App\Controller;

use App\Entity\CampaignProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampaignProductsController extends AbstractController
{
    /**
     * @Route("/campaign-products", name="campaign_products_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $campaignProducts = $entityManager->getRepository(CampaignProduct::class)->findAll();

        return $this->render('campaign_products/index.html.twig', [
            'campaignProducts' => $campaignProducts,
        ]);
    }

    /**
     * @Route("/campaign-products/create", name="campaign_products_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');

            $campaignProduct = new CampaignProduct();
            $campaignProduct->setName($name);

            $entityManager->persist($campaignProduct);
            $entityManager->flush();

            return $this->redirectToRoute('campaign_products_index');
        }

        return $this->render('campaign_products/create.html.twig');
    }

    /**
     * @Route("/campaign-products/{id}", name="campaign_products_show", methods={"GET"})
     */
    public function show(CampaignProduct $campaignProduct): Response
    {
        return $this->render('campaign_products/show.html.twig', [
            'campaignProduct' => $campaignProduct,
        ]);
    }

    /**
     * @Route("/campaign-products/{id}/edit", name="campaign_products_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $name = $request->request->get('name');
            $campaignProduct->setName($name);

            $entityManager->flush();

            return $this->redirectToRoute('campaign_products_index');
        }

        return $this->render('campaign_products/edit.html.twig', [
            'campaignProduct' => $campaignProduct,
        ]);
    }

    /**
     * @Route("/campaign-products/{id}/delete", name="campaign_products_delete", methods={"POST"})
     */
    public function delete(Request $request, CampaignProduct $campaignProduct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $campaignProduct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($campaignProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('campaign_products_index');
    }
}