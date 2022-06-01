<?php

namespace App\Entity;

use App\Repository\YtVideosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YtVideosRepository::class)]
class YtVideos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $videoid;

    #[ORM\Column(type: 'string', length: 255)]
    private $thumb;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'date')]
    private $date_published;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $liked;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[ORM\ManyToOne(targetEntity: YtChannels::class, inversedBy: 'ytVideos')]
    #[ORM\JoinColumn(nullable: false)]
    private $channel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideoid(): ?string
    {
        return $this->videoid;
    }

    public function setVideoid(string $videoid): self
    {
        $this->videoid = $videoid;

        return $this;
    }

    public function getThumb(): ?string
    {
        return $this->thumb;
    }

    public function setThumb(string $thumb): self
    {
        $this->thumb = $thumb;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDatePublished(): ?\DateTimeInterface
    {
        return $this->date_published;
    }

    public function setDatePublished(\DateTimeInterface $date_published): self
    {
        $this->date_published = $date_published;

        return $this;
    }

    public function isLiked(): ?bool
    {
        return $this->liked;
    }

    public function setLiked(?bool $liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getChannel(): ?YtChannels
    {
        return $this->channel;
    }

    public function setChannel(?YtChannels $channel): self
    {
        $this->channel = $channel;

        return $this;
    }
}
