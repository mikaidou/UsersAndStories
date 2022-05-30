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
trait RessourceId
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collection'])]

    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}