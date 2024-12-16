<?php

namespace App\Controller;

use App\Entity\Movie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'index_movie')]
    public function index(Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig',[
            'movie' => $movie
        ]);
    }
}
