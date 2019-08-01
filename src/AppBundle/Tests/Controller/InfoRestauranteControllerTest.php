<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoRestauranteControllerTest extends WebTestCase
{
    public function testCreaterestaurante()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createRestaurante');
    }

    public function testGetrestaurante()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getRestaurante');
    }

}
