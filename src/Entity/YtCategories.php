<?php

namespace App\Entity;

use App\Repository\YtCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: YtCategoriesRepository::class)]
class YtCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'boolean')]
    private $active;

    #[Gedmo\Slug(fields: ['name','id'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[Gedmo\SortablePosition]
    #[ORM\Column(type: 'integer')]
    private $cat_order;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: YtChannels::class)]
    private $ytChannels;

    public function __construct()
    {
        $this->ytChannels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCatOrder(): ?int
    {
        return $this->cat_order;
    }

    public function setCatOrder(int $cat_order): self
    {
        $this->cat_order = $cat_order;

        return $this;
    }

    /**
     * @return Collection<int, YtChannels>
     */
    public function getYtChannels(): Collection
    {
        return $this->ytChannels;
    }

    public function addYtChannel(YtChannels $ytChannel): self
    {
        if (!$this->ytChannels->contains($ytChannel)) {
            $this->ytChannels[] = $ytChannel;
            $ytChannel->setCategory($this);
        }

        return $this;
    }

    public function removeYtChannel(YtChannels $ytChannel): self
    {
        if ($this->ytChannels->removeElement($ytChannel)) {
            // set the owning side to null (unless already changed)
            if ($ytChannel->getCategory() === $this) {
                $ytChannel->setCategory(null);
            }
        }

        return $this;
    }
}
