<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubUser", mappedBy="image")
     */
    private $subUser;

    public function __construct()
    {
        $this->subUser = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection|SubUser[]
     */
    public function getSubUser(): Collection
    {
        return $this->subUser;
    }

    public function addSubUser(SubUser $subUser): self
    {
        if (!$this->subUser->contains($subUser)) {
            $this->subUser[] = $subUser;
            $subUser->setImage($this);
        }

        return $this;
    }

    public function removeSubUser(SubUser $subUser): self
    {
        if ($this->subUser->contains($subUser)) {
            $this->subUser->removeElement($subUser);
            // set the owning side to null (unless already changed)
            if ($subUser->getImage() === $this) {
                $subUser->setImage(null);
            }
        }

        return $this;
    }
}
