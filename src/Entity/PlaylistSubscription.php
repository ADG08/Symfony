<?php

namespace App\Entity;

use App\Repository\PlaylistSubscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistSubscriptionRepository::class)]
class PlaylistSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $subscriptedAt = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'playlistSubscription')]
    private Collection $subscriber;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'playlistSubscription')]
    private Collection $playlist;

    public function __construct()
    {
        $this->subscriber = new ArrayCollection();
        $this->playlist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptedAt(): ?\DateTimeInterface
    {
        return $this->subscriptedAt;
    }

    public function setSubscriptedAt(\DateTimeInterface $subscriptedAt): static
    {
        $this->subscriptedAt = $subscriptedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getSubscriber(): Collection
    {
        return $this->subscriber;
    }

    public function addSubscriber(User $subscriber): static
    {
        if (!$this->subscriber->contains($subscriber)) {
            $this->subscriber->add($subscriber);
            $subscriber->setPlaylistSubscription($this);
        }

        return $this;
    }

    public function removeSubscriber(User $subscriber): static
    {
        if ($this->subscriber->removeElement($subscriber)) {
            // set the owning side to null (unless already changed)
            if ($subscriber->getPlaylistSubscription() === $this) {
                $subscriber->setPlaylistSubscription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylist(): Collection
    {
        return $this->playlist;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlist->contains($playlist)) {
            $this->playlist->add($playlist);
            $playlist->setPlaylistSubscription($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlist->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getPlaylistSubscription() === $this) {
                $playlist->setPlaylistSubscription(null);
            }
        }

        return $this;
    }
}
