<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("productList")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("productList")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("productList")
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     * @Groups("productList")
     */
    private $characteristics;

    /**
     * @ORM\Column(type="float")
     * @Groups("productList")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="Product")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("productList")
     */
    private $brand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCharacteristics()
    {
        return $this->characteristics;
    }

    /**
     * @param mixed $characteristics
     */
    public function setCharacteristics($characteristics): void
    {
        $this->characteristics = $characteristics;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }
}
