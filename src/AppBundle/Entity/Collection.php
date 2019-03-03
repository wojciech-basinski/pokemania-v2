<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="collections")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CollectionRepository")
 */
class Collection
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
     * @var string
     *
     * @ORM\Column(type="string", length=2000)
     */
    private $collection;

    public function getId(): int
    {
        return $this->id;
    }

    public function setCollection(string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): string
    {
        return $this->collection;
    }

    public function getCollectionAsArray(): array
    {
        return explode(';', $this->collection);
    }
}
