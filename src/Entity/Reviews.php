<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ReviewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    itemOperations: ['get','delete', 'put'],
    collectionOperations: ['get','post'],
)]
#[ApiFilter(SearchFilter::class, properties: [
    'user_id'=> SearchFilter::STRATEGY_PARTIAL,
])]
#[ApiFilter(OrderFilter::class, properties: ['user_id' => 'ASC']

)]
#[ORM\Entity(repositoryClass: ReviewsRepository::class)]
class Reviews
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $content;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: true)]
    private $Users;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $isValidated;

    #[ORM\ManyToOne(targetEntity: Stories::class, inversedBy: 'reviews')]
    private $Stories;

    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private $modifiedOn;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getModifiedOn(): ?\DateTimeImmutable
    {
        return $this->modifiedOn;
    }

    public function setModifiedOn(?\DateTimeImmutable $modifiedOn): self
    {
        $this->modifiedOn = $modifiedOn;

        return $this;
    }
}
