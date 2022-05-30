<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StoriesRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: StoriesRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['read:collection']],
    itemOperations: [
        'get','put','delete' => [
            'normalization_context' => ['groups' => ['read:collection',
             'read:item']]
        ]

    ]
)]
#[UniqueEntity('title')]

class Stories
{
    use RessourceId;
    use Timestampable;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collection'])]
    #[Assert\NotBlank]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:collection'])]
    private $slug;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['read:item'])]
    #[Assert\NotBlank]
    private $content;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'stories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $users;

    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy:'stories')]
    private $reviews;

    public function __construct()
    {
      $this->createdAt =new \DateTimeImmutable();
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

}
