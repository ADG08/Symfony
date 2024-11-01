<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\Entity\Movie;
use App\Entity\Playlist;
use App\Entity\PlaylistMedia;
use App\Entity\Serie;
use App\Entity\Subscription;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const MAX_USERS = 10;
    public const MAX_PLAYLISTS_PER_USER = 5;
    public const MAX_SUBSCRIPTIONS = 3;
    public const MAX_MEDIA = 100;
    public const MAX_MEDIA_PER_PLAYLIST = 3;

    public function load(ObjectManager $manager): void
    {
        $users = [];
        $medias = [];
        $playlists = [];

        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $users[] = $this->createUser($i, $manager);

            for ($j = 0; $j < random_int(1, self::MAX_PLAYLISTS_PER_USER); $j++)
                $playlists[] = $this->createPlaylist($j,$users[$i], $manager);
        }

        $this->createMediaAndLinkToPlaylists($manager, $playlists);
        $this->createSubscriptions($manager, $users[array_rand($users)]);

        $manager->flush();
    }

    private function createUser(int $i, ObjectManager $manager): User
    {
        $user = new User();
        $user->setEmail("test{$i}@example{$i}.com");
        $user->setUsername("test{$i}");
        $user->setPassword('password');
        $manager->persist($user);
        return $user;
    }

        private function createPlaylist(int $j, User $user, ObjectManager $manager): Playlist
    {
        $playlist = new Playlist();
        $playlist->setName("Ma playlist #{$j}");
        $playlist->setCreatedAt(new \DateTimeImmutable());
        $playlist->setUpdatedAt(new \DateTimeImmutable());
        $playlist->setCreator($user);
        $manager->persist($playlist);
        return $playlist;
    }

    private function createMediaAndLinkToPlaylists(ObjectManager $manager, array $playlists): void
    {
        for ($j = 0; $j < self::MAX_MEDIA; $j++) {
            $media = $this->createMedia($j, $manager);

            for ($l = 0; $l < random_int(1, self::MAX_MEDIA_PER_PLAYLIST); $l++) {
                $this->linkMediaToPlaylist($media, $playlists, $manager);
            }
        }
    }

    private function createMedia(int $j, ObjectManager $manager): Media
    {
        $media = random_int(0, 1) === 0 ? new Movie() : new Serie();
        $media->setTitle("Film {$j}");
        $media->setLongDescription('Longue description');
        $media->setShortDescription( 'Short description');
        $media->setCoverImage('http://');
        $media->setReleaseDate(new \DateTime(datetime: "+7 days"));
        $manager->persist($media);
        return $media;
    }

    private function linkMediaToPlaylist(Media $media, array $playlists, ObjectManager $manager): void
    {
        $playlistMedia = new PlaylistMedia();
        $playlistMedia->setMedia($media);
        $playlistMedia->setAddedAt(new \DateTimeImmutable());
        $playlistMedia->setPlaylist($playlists[array_rand($playlists)]);
        $manager->persist($playlistMedia);
    }

    private function createSubscriptions(ObjectManager $manager, User $randomUser): void
    {
        for ($m = 0; $m < self::MAX_SUBSCRIPTIONS; $m++) {
            $abonnement = new Subscription();
            $abonnement->setDuration(10 * ($m + 1));
            $abonnement->setName('Abonnement 10 jours');
            $abonnement->setPrice(50);
            $manager->persist($abonnement);
            $randomUser->setCurrentSubscription(currentSubscription: $abonnement);
        }
    }
}
