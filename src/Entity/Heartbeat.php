<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="heartbeats")
 **/
class Heartbeat
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datetime;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $ip;

    /**
     * @ORM\ManyToOne(targetEntity="Host", inversedBy="heartbeats")
     **/
    protected $host;

    public static function create($host)
    {
        $heartbeart = new Heartbeat();
        $heartbeart->setDatetime(new DateTime());
        $heartbeart->setHost($host);
        $heartbeart->setIp($_SERVER['REMOTE_ADDR']);

        return $heartbeart;
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
     * @return DateTime
     */
    public function getDatetime(): DateTime
    {
        return $this->datetime;
    }

    /**
     * @param DateTime $datetime
     */
    public function setDatetime(DateTime $datetime)
    {
        $this->datetime = $datetime;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return Host
     */
    public function getHost(): Host
    {
        return $this->host;
    }

    /**
     * @param Host $host
     */
    public function setHost(Host $host)
    {
        $this->host = $host;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'ip' => $this->getIp(),
            'datetime' => $this->getDatetime()->format(DATE_ATOM),
        ];
    }
}
