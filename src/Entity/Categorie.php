<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[Vich\Uploadable]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "IDCateg", type: "integer")]
    private ?int $IDCateg = null;

    #[ORM\Column(length: 150)]
    #[Assert\NotBlank(message: "Le nom ne doit pas être vide.")]
    private ?string $nom = null;

    #[ORM\Column(length: 65535)]
    #[Assert\NotBlank(message: "Le description ne doit pas être vide.")]
    private ?string $description = null;


    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'image ne doit pas être vide.")]
    private ?string $image = null;

    
    #[Vich\UploadableField(mapping: 'category_images', fileNameProperty: 'image')]
    private ?File $imageFile = null;
    /*
      @Vich\UploadableField(mapping="category_images", fileNameProperty="image")
     
    private ?File $imageFile = null;
*/
    public function setImageFile(?File $imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getIDCateg(): ?int
    {
        return $this->IDCateg;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
     /**
     * Returns the string representation of the Categorie object.
     *
     * @return string
     */
    public function __toString(): string
    {
        // Modify this method according to your needs
        return $this->nom; // Assuming 'nom' is a property of your Categorie entity
    }
}
