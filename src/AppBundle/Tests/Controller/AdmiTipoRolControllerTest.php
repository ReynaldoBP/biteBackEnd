<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiTipoRolControllerTest extends WebTestCase
{
    public function testGettiporol()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getTipoRol');
    }

    public function testEdittiporol()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editTipoRol');
    }

    public function testCreatetiporol()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createTipoRol');
    }

}
