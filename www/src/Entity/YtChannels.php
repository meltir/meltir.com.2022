<?php

namespace App\Entity;

use App\Repository\YtChannelsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YtChannelsRepository::class)]
class YtChannels
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $chan_id;

    #[ORM\Column(type: 'string', length: 255)]
    private $thumb;

    #[ORM\Column(type: 'string', length: 255)]
    private $chan_name;

    #[ORM\Column(type: 'string', length: 255)]
    private $upload_playlist;

    #[ORM\Column(type: 'text')]
    private $chan_description;

    #[ORM\OneToMany(mappedBy: 'channel', targetEntity: YtVideos::class)]
    private $ytVideos;

    #[ORM\ManyToOne(targetEntity: YtCategories::class, inversedBy: 'ytChannels')]
    private $category;

    public function __construct()
    {
        $this->ytVideos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChanId(): ?string
    {
        return $this->chan_id;
    }

    public function setChanId(string $chan_id): self
    {
        $this->chan_id = $chan_id;

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

    public function getChanName(): ?string
    {
        return $this->chan_name;
    }

    public function setChanName(string $chan_name): self
    {
        $this->chan_name = $chan_name;

        return $this;
    }

    public function getUploadPlaylist(): ?string
    {
        return $this->upload_playlist;
    }

    public function setUploadPlaylist(string $upload_playlist): self
    {
        $this->upload_playlist = $upload_playlist;

        return $this;
    }

    public function getChanDescription(): ?string
    {
        return $this->chan_description;
    }

    public function setChanDescription(string $chan_description): self
    {
        $this->chan_description = $chan_description;

        return $this;
    }

    /**
     * @return Collection<int, YtVideos>
     */
    public function getYtVideos(): Collection
    {
        return $this->ytVideos;
    }

    public function addYtVideo(YtVideos $ytVideo): self
    {
        if (!$this->ytVideos->contains($ytVideo)) {
            $this->ytVideos[] = $ytVideo;
            $ytVideo->setChannel($this);
        }

        return $this;
    }

    public function removeYtVideo(YtVideos $ytVideo): self
    {
        if ($this->ytVideos->removeElement($ytVideo)) {
            // set the owning side to null (unless already changed)
            if ($ytVideo->getChannel() === $this) {
                $ytVideo->setChannel(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?YtCategories
    {
        return $this->category;
    }

    public function setCategory(?YtCategories $category): self
    {
        $this->category = $category;

        return $this;
    }
}
