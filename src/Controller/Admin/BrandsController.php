<?php

namespace App\Controller\Admin;

use App\Entity\Brand;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/brands')]
class BrandsController extends AbstractController
{
    #[Route(name: 'admin_brands_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user || !in_array(User::ADMIN_ROLE, $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }

        $query = $entityManager->getRepository(Brand::class)->createQueryBuilder('b')->getQuery();
        $brands = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('admin/brands/index.html.twig', [
            'brands' => $brands,
        ]);
    }

    #[Route('/create', name: 'admin_brands_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $brandName = (string)$request->request->get('name');

            $brand = new Brand();
            $brand->setName($brandName);

            $entityManager->persist($brand);
            $entityManager->flush();

            return $this->redirectToRoute('admin_brands_index');
        }

        return $this->render('admin/brands/create.html.twig');
    }

    #[Route('/admin/brands/{id}/edit', name: 'admin_brands_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $brandName = (string)$request->request->get('name');
            $brand->setName($brandName);

            $entityManager->flush();

            return $this->redirectToRoute('admin_brands_index');
        }

        return $this->render('admin/brands/edit.html.twig', [
            'brand' => $brand,
        ]);
    }

    #[Route('/admin/brands/{id}/delete', name: 'admin_brands_delete', methods: ['POST'])]
    public function delete(Request $request, Brand $brand, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $brand->getId(), (string)$request->request->get('_token'))) {
            $entityManager->remove($brand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_brands_index');
    }

    //    public function store(Request $request)
    //    {
    //        // Validation des données
    //        $validated = $request->validate([
    //            'name' => 'required|string|max:255|unique:brands,name',
    //        ]);
    //
    //        // Création de la marque
    //        Brands::create($validated);
    //
    //        return redirect()->route('brands.index');
    //    }
}
