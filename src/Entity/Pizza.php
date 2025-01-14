<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PizzaRepository::class)]
#[Vich\Uploadable]
class Pizza
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column( nullable: true)]
    private ?string $imageName = null;

    // Obligatoire car bug avec symfony qui ne prend pas si on change uniquement une image
    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Patte $Patte = null;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'pizza')]
    private Collection $ingredient;

    public function __construct()
    {
        $this->ingredient = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getPatte(): ?Patte
    {
        return $this->Patte;
    }

    public function setPatte(?Patte $Patte): static
    {
        $this->Patte = $Patte;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredient(): Collection
    {
        return $this->ingredient;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredient->contains($ingredient)) {
            $this->ingredient->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->ingredient->removeElement($ingredient);

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void 
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // Si fichier chargé, met à jour la date
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile() : ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}
