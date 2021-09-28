<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectsRepository")
 */
class Projects
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client;

    /**
    * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $technologie;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $logiciel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $URL_site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", orphanRemoval=true, cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $banner;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", orphanRemoval=true, cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $miniature;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="projects", orphanRemoval=true,cascade={"persist" ,"remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $gallery;


    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->technologies = new ArrayCollection();

        $date = \DateTime::createFromFormat('d-m-Y','now');
        $timeZone = new \DateTimeZone('Europe/Paris');
        $date2 = new \DateTime($date);
        $date2->setTimeZone($timeZone);
        $this->date = $date2;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return (new Slugify())->slugify($this->title);
    }


    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }


    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getTechnologie(): ?string
    {
        return $this->technologie;
    }

    public function setTechnologie(string $technologie): self
    {
        $this->technologie = $technologie;

        return $this;
    }
    
    public function getLogiciel(): ?string
    {
        return $this->logiciel;
    }

    public function setLogiciel(string $logiciel): self
    {
        $this->logiciel = $logiciel;

        return $this;
    }

    public function getURLSite(): ?string
    {
        return $this->URL_site;
    }

    public function setURLSite(?string $URL_site): self
    {
        $this->URL_site = $URL_site;

        return $this;
    }

    public function getBanner(): ?Image
    {
        return $this->banner;
    }

    public function setBanner(Image $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    public function getMiniature(): ?Image
    {
        return $this->miniature;
    }

    public function setMiniature(Image $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(Image $gallery): self
    {
        $gallery->setProjects($this);
        $this->gallery->add($gallery);
        return $this;
    }

    public function removeGallery(Image $gallery): self
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
            // set the owning side to null (unless already changed)
            if ($gallery->getProjects() === $this) {
                $gallery->setProjects(null);
            }
        }

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
