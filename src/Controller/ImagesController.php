<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    /**
     * @Route("/admin/images", name="admin_images_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Check if the user is authenticated and has the admin role
        if (!$user || !in_array(User::ADMIN_ROLE, $user->getRoles())) {
            return $this->redirectToRoute('app_login');
        }

        // Fetch images and paginate
        $query = $entityManager->getRepository(Image::class)->createQueryBuilder('i')->getQuery();
        $images = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Current page number
            20 // Items per page
        );

        return $this->render('admin/images/index.html.twig', [
            'images' => $images,
        ]);
    }

    /**
     * @Route("/admin/images/create", name="admin_images_create", methods={"GET", "POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $url = $request->request->get('url');
            $alt = $request->request->get('alt');
            $title = $request->request->get('title');

            $image = new Image();
            $image->setUrl($url);
            $image->setAlt($alt);
            $image->setTitle($title);

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('admin_images_index');
        }

        return $this->render('admin/images/create.html.twig');
    }

    /**
     * @Route("/admin/images/{id}/edit", name="admin_images_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $url = $request->request->get('url');
            $alt = $request->request->get('alt');
            $title = $request->request->get('title');

            $image->setUrl($url);
            $image->setAlt($alt);
            $image->setTitle($title);

            $entityManager->flush();

            return $this->redirectToRoute('admin_images_index');
        }

        return $this->render('admin/images/edit.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/admin/images/{id}/delete", name="admin_images_delete", methods={"POST"})
     */
    public function delete(Request $request, Image $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_images_index');
    }
}