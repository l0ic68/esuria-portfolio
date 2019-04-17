<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Image;


/**
 * @ORM\Entity(repositoryClass="App\Repository\HobbiesRepository")
 * @Vich\Uploadable()
 */
class Hobbies
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

    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

     /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;
    

    public function __construct()
    {
        // $this->image = new Image();
        $this->updatedAt = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug()
    {
     return (new Slugify())->slugify($this->type);
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }



    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;

        return $this;
    }

}
