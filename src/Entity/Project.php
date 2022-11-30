<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use App\Entity\SonataMediaMedia;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project implements Translatable
{
    #[Gedmo\Locale]
    private $locale;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $title;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private $category;

    #[ORM\ManyToOne(targetEntity: SonataMediaMedia::class)]
    #[ORM\JoinColumn(name: "picture", referencedColumnName: "id")]
    private $picture;

    #[Gedmo\Translatable]
    #[ORM\Column(type: 'text')]
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPicture(): ?SonataMediaMedia
    {
        return $this->picture;
    }

    public function setPicture(?SonataMediaMedia $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

    public function __toString()
    {
        return ($this->getTitle()) ? : '';
    }
}
