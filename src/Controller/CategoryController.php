<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Repository\MovieRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route(path: '/category')]
    public function index(CategoryRepository $categorieRepository) : Response
    {
        $categories = $categorieRepository->findAll();
    
        return $this->render('discover.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route(path: '/category/{id}', name: 'category_show')]
    public function category(Category $category, MovieRepository $movieRepo) : Response
    {
        $movies = $movieRepo->findAll();

        return $this->render('category.html.twig', [
            'category' => $category,
            'movies' => $movies
        ]);
    }
}
