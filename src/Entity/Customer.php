<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
 * @Hateoas\Relation(
 *     "delete",
 *     href = @Hateoas\Route(
 *     "delete_customer",
 *     parameters={"id" = "expr(object.getId())"}
 *     )
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
    private $idCustomer;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customersList", "customerDetails"})
     * @Serializer\Since("1")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "Name must be at least {{ limit }} characters long",
     *     maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"customerDetails"})
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "Street must be at least {{ limit }} characters long",
     *     maxMessage = "Street cannot be longer than {{ limit }} characters"
     * )
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)     *
     * @Groups({"customerDetails"})
     * @Serializer\Since("1")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "City must be at least {{ limit }} characters long",
     *     maxMessage = "City cannot be longer than {{ limit }} characters"
     * )
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Since("1")
     * @Groups("customerDetails")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Since("1")
     * @Groups("customerDetails")
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Length(
     *     min = 3,
     *     max = 255,
     *     minMessage = "Country must be at least {{ limit }} characters long",
     *     maxMessage = "Country cannot be longer than {{ limit }} characters"
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Since("1")
     * @Groups({"customersList", "customerDetails"})
     * @Assert\NotBlank
     * @Assert\NotNull
     * @Assert\Type("string")
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email"
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Until("1")
     * @Groups({"customersList", "customerDetails"})
     */
    private $createdAt;


    /**
     * @var  UserInterface
     * @Serializer\Since("1")
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="customers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getIdCustomer(): ?int
    {
        return $this->idCustomer;
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

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }
}
