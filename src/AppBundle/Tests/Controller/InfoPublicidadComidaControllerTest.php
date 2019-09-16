<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoPublicidadComidaControllerTest extends WebTestCase
{
    public function testCreatepublicidadcomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createPublicidadComida');
    }

    public function testEditpublicidadcomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPublicidadComida');
    }

    public function testGetpublicidadcomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPublicidadComida');
    }

}
