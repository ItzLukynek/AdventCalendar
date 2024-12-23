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

    #[ORM\Column(nullable: true)]
    private ?bool $shuffle = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title_color = null;

    #[ORM\Column(nullable: true)]
    private ?bool $showGift = null;

    #[ORM\Column(nullable: true)]
    private ?bool $allow_previous_days = null;

    #[ORM\Column(nullable: true)]
    private ?int $title_size = null;


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
        return $this->title ?? "Adventní kalendář";
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

    public function isShuffle(): ?bool
    {
        return $this->shuffle;
    }

    public function setShuffle(?bool $shuffle): static
    {
        $this->shuffle = $shuffle;

        return $this;
    }

    public function getTitleColor(): ?string
    {
        return $this->title_color ?? "#ffcc00";
    }

    public function setTitleColor(?string $title_color): static
    {
        $this->title_color = $title_color;

        return $this;
    }

    public function isShowGift(): ?bool
    {
        return $this->showGift;
    }

    public function setShowGift(?bool $showGift): static
    {
        $this->showGift = $showGift;

        return $this;
    }

    public function isAllowPreviousDays(): ?bool
    {
        return $this->allow_previous_days;
    }

    public function setAllowPreviousDays(?bool $allow_previous_days): static
    {
        $this->allow_previous_days = $allow_previous_days;

        return $this;
    }

    public function getTitleSize(): ?int
    {
        return $this->title_size ?? "50";
    }

    public function setTitleSize(?int $title_size): static
    {
        $this->title_size = $title_size;

        return $this;
    }


}
