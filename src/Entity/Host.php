<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Id\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="hosts")
 **/
class Host
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $hash;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ttl;

    /**
     * @ORM\OneToMany(targetEntity="Heartbeat", mappedBy="host")
     * @var Collection An ArrayCollection of Heartbeats.
     **/
    protected $heartbeats;

    public function __construct()
    {
        $this->heartbeats = new ArrayCollection();
    }

    public static function create($name, $ttl)
    {
        $host = new Host();
        $host->setName($name);
        $host->setTtl($ttl);
        $host->createHash();

        return $host;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }

    public function getTtl(): string
    {
        return $this->ttl;
    }

    /**
     * @param string $ttl
     */
    public function setTtl(string $ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * @return Collection
     */
    public function getHeartbeats(): Collection
    {
        return $this->heartbeats;
    }

    /**
     * @param Collection $heartbeats
     */
    public function setHeartbeats(Collection $heartbeats)
    {
        $this->heartbeats = $heartbeats;
    }

    public function createHash()
    {
        $this->hash = uniqid("", true);
    }
}
