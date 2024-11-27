<?php

declare(strict_types=1);

namespace App\Controller\Other;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/category/{id}', name: 'page_categories')]
    public function category(Category $category) : Response
    {
        return $this->render('other/category.html.twig', [
            'category' => $category
        ]);
    }

    #[Route(path: '/discover', name: 'page_discover')]
    public function discover(EntityManagerInterface $entityManager, CategoryRepository $categorieRepository) : Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('other/discover.html.twig', [
            'categories' => $categories
        ]);
    }
}
