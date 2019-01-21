<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

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
    private $filename;

    /**
    * @var File
    * @Vich\UploadableField(mapping="hobbies_image", fileNameProperty="filename")
    */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */

    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

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

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): Hobbies
    {
        $this->filename = $filename;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): Hobbies
    {
        $this->imageFile = $imageFile;

        return $this;
    }

}
