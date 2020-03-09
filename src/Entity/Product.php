<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *     "product_details",
 *     parameters={"id" = "expr(object.getId())"}
 *      ),
 *      exclusion = @Hateoas\Exclusion(groups = {"productList", "productDetails"})
 * )
 * @Hateoas\Relation(
 *     "list",
 *     href = @Hateoas\Route(
 *     "product_list"),
 *      exclusion = @Hateoas\Exclusion(groups = {"productDetails"})
 * )
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"productList", "productDetails"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Since("1")
     * @Groups({"productList", "productDetails"})
     * @Serializer\Until("1")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Since("1")
     * @Groups("productDetails")
     *
     */
    private $description;

    /**
     * @ORM\Column(type="array")
     * @Serializer\Since("1")
     * @Groups("productDetails")
     */
    private $characteristics;

    /**
     * @ORM\Column(type="float")
     * @Serializer\Since("1")
     * @Groups({"productList", "productDetails"})     *
     *
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="Product")
     * @Serializer\Since("1")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"productList", "productDetails"})
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
