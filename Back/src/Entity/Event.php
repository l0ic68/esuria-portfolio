<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SmallEvent", mappedBy="event")
     */
    private $smallEvent;

    public function __construct()
    {
        $this->smallEvent = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): self
    {
        $this->date = $date;

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

   /**
     * @return Collection|SmallEvent[]
     */
    public function getSmallEvent(): Collection
    {
        return $this->smallEvent;
    }
    
    public function addSmallEvent(SmallEvent $smallEvent): self
    {
        if (!$this->smallEvent->contains($smallEvent)) {
            $this->smallEvent[] = $smallEvent;
            $smallEvent->setTimeline($this);
        }
        return $this;
    }
    public function removeSmallEvent(SmallEvent $smallEvent): self
    {
        if ($this->smallEvent->contains($smallEvent)) {
            $this->smallEvent->removeElement($smallEvent);
            // set the owning side to null (unless already changed)
            if ($smallEvent->getTimeline() === $this) {
                $smallEvent->setTimeline(null);
            }
        }
        return $this;
    }
}
