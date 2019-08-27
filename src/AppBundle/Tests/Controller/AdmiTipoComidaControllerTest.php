<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiTipoComidaControllerTest extends WebTestCase
{
    public function testGettipocomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getTipoComida');
    }

    public function testEdittipocomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editTipoComida');
    }

    public function testCreatetipocomida()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createTipoComida');
    }

}
