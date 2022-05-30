<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['read:collection']],
    itemOperations: [
        'get','put','delete' => [
            'normalization_context' => ['groups' => ['read:collection', 'read:item']]
        ]
    ]
)]
class Reviews
{
    use RessourceId;
    use Timestampable;

    #[ORM\Column(type: 'text')]
    #[Groups(['read:collection'])]
    #[Assert\NotBlank]
    private $content;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isValidated;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private $Users;

    #[ORM\ManyToOne(targetEntity: Stories::class, inversedBy: 'reviews')]
    #[Groups(['read:item'])]
    private ?Stories $Stories;

    public function __construct()
    {
      $this->createdAt =new \DateTimeImmutable();
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
        return $this->Users;
    }

    public function setUsers(?Users $Users): self
    {
        $this->Users = $Users;

        return $this;
    }

    public function isIsValidated(): ?bool
    {
        return $this->isValidated;
    }

    public function setIsValidated(?bool $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getStories(): ?Stories
    {
        return $this->Stories;
    }

    public function setStories(?Stories $Stories): self
    {
        $this->Stories = $Stories;

        return $this;
    }

}
