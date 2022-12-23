<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $countryName = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $countryCode = null;

    #[ORM\Column(length: 75, nullable: true)]
    private ?string $countryCapital = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $countryFlag = null;

    #[ORM\Column(nullable: true)]
    private ?int $countryPopulation = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $apiId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(?string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getCountryCapital(): ?string
    {
        return $this->countryCapital;
    }

    public function setCountryCapital(?string $countryCapital): self
    {
        $this->countryCapital = $countryCapital;

        return $this;
    }

    public function getCountryFlag(): ?string
    {
        return $this->countryFlag;
    }

    public function setCountryFlag(?string $countryFlag): self
    {
        $this->countryFlag = $countryFlag;

        return $this;
    }

    public function getCountryPopulation(): ?int
    {
        return $this->countryPopulation;
    }

    public function setCountryPopulation(?int $countryPopulation): self
    {
        $this->countryPopulation = $countryPopulation;

        return $this;
    }

    public function getApiId(): ?string
    {
        return $this->apiId;
    }

    public function setApiId(?string $apiId): self
    {
        $this->apiId = $apiId;

        return $this;
    }
}
