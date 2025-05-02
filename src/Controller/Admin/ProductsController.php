<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductsController extends AbstractController
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly BrandRepository $brandRepository
    ) {
    }

    #[Route('/admin/products', name: 'admin_products_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $query = $this->productRepository->createQueryBuilder('p')->getQuery();
        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('admin/products/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/products/create', name: 'admin_products_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $product = new Product();
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setMoreInfo($request->request->get('more_infos'));
            $product->setPrice($request->request->get('price'));
            $product->setBrand($this->brandRepository->find($request->request->get('brand')));

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_products_index')->with('success', "Le produit a bien été enregistré");
        }

        $brands = $this->brandRepository->findAll();

        return $this->render('admin/products/create.html.twig', [
            'brands' => $brands,
        ]);
    }

    #[Route('/admin/products/{id}/edit', name: 'admin_products_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setDescription($request->request->get('description'));
            $product->setMoreInfo($request->request->get('more_infos'));
            $product->setPrice($request->request->get('price'));
            $product->setBrand($this->brandRepository->find($request->request->get('brand')));

            $entityManager->flush();

            return $this->redirectToRoute('admin_products_index')->with('success', "Le produit a bien été mis à jour");
        }

        $brands = $this->brandRepository->findAll();

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'brands' => $brands,
        ]);
    }

    #[Route('/admin/products/{id}/delete', name: 'admin_products_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_products_index')->with('success', "Le produit a bien été supprimé");
    }
}
