<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @Hateoas\Relation(
 *     "self",
 *     href = @Hateoas\Route(
 *     "customer_details",
 *     parameters={"id" = "expr(object.getId())"}
 *     ),
 *     exclusion = @Hateoas\Exclusion(groups = {"customersList", "customerDetails"})
 * )
 * @Hateoas\Relation(
 *     "list",
 *     href = @Hateoas\Route(
 *     "customer_list"),
 *      exclusion = @Hateoas\Exclusion(groups = {"customerDetails"})
 * )
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"customersList", "customerDetails"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customersList", "customerDetails"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customerDetails"})
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customerDetails"})
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("customerDetails")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("customerDetails")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customersList", "customerDetails"})
     */
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"customersList", "customerDetails"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
