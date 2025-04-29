<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Repository\BrandRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductImagesController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private BrandRepository $brandRepository,
        private ImageRepository $imageRepository
    ) {
    }

    #[Route('/admin/product-images', name: 'admin_product_images_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user || !in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }

        $query = $entityManager->getRepository(Product::class)->createQueryBuilder('p')->getQuery();
        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/product_images/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/admin/product-images/create/{id}', name: 'admin_product_images_create', methods: ['GET', 'POST'])]
    public function create(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $imageId = $request->request->get('image');
            $image = $entityManager->getRepository(Image::class)->find($imageId);

            $productImage = new ProductImage();
            $productImage->setProduct($product);
            $productImage->setImage($image);

            $entityManager->persist($productImage);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_images_create', ['id' => $product->getId()]);
        }

        $brand = $this->brandRepository->find($product->getBrand());
        $associatedImages = $this->imageRepository->findBy(['product' => $product]);

        return $this->render('admin/product_images/create.html.twig', [
            'product' => $product,
            'brand' => $brand,
            'assocImages' => $associatedImages,
            'images' => $this->imageRepository->findAll(),
        ]);
    }

    #[Route('/admin/product-images/{id}/delete', name: 'admin_product_images_delete', methods: ['POST'])]
    public function delete(ProductImage $productImage, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $productImage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($productImage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_product_images_index');
    }
}
