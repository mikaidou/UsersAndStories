<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource()]
#[ApiFilter(SearchFilter::class, properties: [
    'username'=> SearchFilter::STRATEGY_PARTIAL,
])]
#[ApiFilter(OrderFilter::class, properties: ['username' => 'ASC']

)]
#[ORM\Entity(repositoryClass: UsersRepository::class)]
#[UniqueEntity('username')]

class Users
{
   use RessourceId;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(max: 20)]
    #[Assert\NotBlank]

    private $username;

    #[ORM\Column(type: 'string', length: 255)]
    private $role;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Stories::class)]
    private Collection $stories;

    #[ORM\OneToMany(mappedBy: 'Users', targetEntity: Reviews::class, orphanRemoval: true)]
    private Collection $reviews;

    public function __construct()
    {
        $this->stories = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Stories>
     */
    public function getStories(): Collection
    {
        return $this->stories;
    }

    public function addStory(Stories $story): self
    {
        if (!$this->stories->contains($story)) {
            $this->stories[] = $story;
            $story->setUsers($this);
        }

        return $this;
    }

    public function removeStory(Stories $story): self
    {
        if ($this->stories->removeElement($story)) {
            // set the owning side to null (unless already changed)
            if ($story->getUsers() === $this) {
                $story->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setUsers($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUsers() === $this) {
                $review->setUsers(null);
            }
        }

        return $this;
    }
}
