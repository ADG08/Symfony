<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlaylistController extends AbstractController
{
    #[Route('/playlist', name: 'show_playlist')]
    public function index(MediaRepository $mediaRepository, PlaylistRepository $playlistRepository): Response
    {

        $medias = $mediaRepository->findAll();
        $playlists = $playlistRepository->findAll();

        return $this->render('movie/lists.html.twig', [
            'medias' => $medias,
            'playlists' => $playlists
        ]);
    }
}
