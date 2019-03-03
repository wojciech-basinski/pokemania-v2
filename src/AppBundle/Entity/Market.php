<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarketRepository")
 */
class Market
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $kind;

    /**
     * @var string
     *
     * @ORM\Column()
     */
    private $namePl;


    public function getId(): int
    {
        return $this->id;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setKind(string $kind): self
    {
        $this->kind = $kind;

        return $this;
    }

    public function getKind(): string
    {
        return $this->kind;
    }

    public function setNamePl(string $namePl): self
    {
        $this->namePl = $namePl;

        return $this;
    }

    public function getNamePl(): string
    {
        return $this->namePl;
    }
}
