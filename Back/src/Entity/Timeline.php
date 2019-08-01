<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimelineRepository")
 */
class Timeline
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Event", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SmallEvent", mappedBy="timeline")
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

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
