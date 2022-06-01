<?php

namespace App\Entity;

use App\Repository\GoogleTokenStorageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GoogleTokenStorageRepository::class)]
class GoogleTokenStorage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json')]
    private $token = [];

    #[ORM\Column(type: 'string', length: 255)]
    private $scope;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?array
    {
        return $this->token;
    }

    public function setToken(array $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getScope(): ?string
    {
        return $this->scope;
    }

    public function setScope(string $scope): self
    {
        $this->scope = $scope;

        return $this;
    }
}
