<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var UploadedFile
     * @Assert\File(mimeTypes={"image/png", "image/jpeg"},
     * maxSize = "3000000"
     * )
     */
    private $file;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="image")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

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
}
