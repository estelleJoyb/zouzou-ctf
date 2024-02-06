<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'Le commentaire doit faire au moins {{ limit }} caractères.',
        maxMessage: 'Le commentaire doit faire moins de {{ limit }} caractères.'
    )]
    #[Assert\NotBlank(
        message: 'Si tu veux pas écrire poste pas de commentaire'
    )]
    private ?string $flag = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }
}