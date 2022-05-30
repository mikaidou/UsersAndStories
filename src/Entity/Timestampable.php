<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    normalizationContext:['groups' => ['read:collection']],
    itemOperations: [
        'get','put','delete' => [
            'normalization_context' => ['groups' => ['read:collection',
             'read:item']]
        ]

    ]
)]

trait Timestampable
{
    #[ORM\Column(type: 'datetime')]
    #[Groups(['read:item'])]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime_immutable',nullable: true)]
    #[Groups(['read:item'])]
    private \DateTimeInterface $updatedAt;
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}