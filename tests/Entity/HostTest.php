<?php

namespace App\Entity;

use App\Exceptions\InvalidIntervalException;
use PHPUnit\Framework\TestCase;

class HostTest extends TestCase
{
    const uuidRegex = '/[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/';

    public function testItCreatesAUuidHash()
    {
        $host = new Host();
        $host->createHash();
        $this->assertRegExp(self::uuidRegex, $host->getHash());
    }

    public function testItCreatesAHostWithHash()
    {
        $host = Host::create('someHostname', 'P1D');
        $this->assertEquals('someHostname', $host->getName());
        $this->assertEquals('P1D', $host->getTtl());
        $this->assertRegExp(self::uuidRegex, $host->getHash());
    }

    public function testItThrowsExceptionOnWrongTtl()
    {
        $this->expectException(InvalidIntervalException::class);
        Host::create('someHostname', 'nonValidTtl');
    }
}
