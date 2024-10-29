<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $button_text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $button_link = null;

    #[ORM\Column(nullable: true)]
    private ?int $Number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bg_image_url = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): static
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getButtonText(): ?string
    {
        return $this->button_text;
    }

    public function setButtonText(?string $button_text): static
    {
        $this->button_text = $button_text;

        return $this;
    }

    public function getButtonLink(): ?string
    {
        return $this->button_link;
    }

    public function setButtonLink(?string $button_link): static
    {
        $this->button_link = $button_link;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(?int $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    public function getBgImageUrl(): ?string
    {
        return $this->bg_image_url;
    }

    public function setBgImageUrl(?string $bg_image_url): static
    {
        $this->bg_image_url = $bg_image_url;

        return $this;
    }
}
