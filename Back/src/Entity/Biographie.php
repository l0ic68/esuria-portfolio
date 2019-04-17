<?php

namespace App\Entity;

use App\Entity\Biographie;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BiographieRepository")
 */
class Biographie
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="text")
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $parcours;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Skill", mappedBy="biographie")
     */
    private $competence;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getParcours(): ?string
    {
        return $this->parcours;
    }

    public function setParcours(string $parcours): self
    {
        $this->parcours = $parcours;

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Skill $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
            $competence->setBiographie($this);
        }

        return $this;
    }

    public function removeCompetence(Skill $competence): self
    {
        if ($this->competence->contains($competence)) {
            $this->competence->removeElement($competence);
            // set the owning side to null (unless already changed)
            if ($competence->getBiographie() === $this) {
                $competence->setBiographie(null);
            }
        }

        return $this;
    }



}
