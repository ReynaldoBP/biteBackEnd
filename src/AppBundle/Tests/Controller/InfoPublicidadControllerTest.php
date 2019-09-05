<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoPublicidadControllerTest extends WebTestCase
{
    public function testCreatepublicidad()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createPublicidad');
    }

    public function testEditpublicidad()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPublicidad');
    }

    public function testGetpublicidad()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPublicidad');
    }

}
