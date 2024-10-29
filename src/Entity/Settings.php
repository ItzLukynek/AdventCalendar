<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $auth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $bg_image_url = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(nullable: true)]
    private ?bool $main_settings = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAuth(): ?bool
    {
        return $this->auth;
    }

    public function setAuth(?bool $auth): static
    {
        $this->auth = $auth;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isMainSettings(): ?bool
    {
        return $this->main_settings;
    }

    public function setMainSettings(?bool $main_settings): static
    {
        $this->main_settings = $main_settings;

        return $this;
    }
}
