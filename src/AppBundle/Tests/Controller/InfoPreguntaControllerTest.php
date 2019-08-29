<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoPreguntaControllerTest extends WebTestCase
{
    public function testCreatepregunta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createPregunta');
    }

    public function testEditpregunta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPregunta');
    }

    public function testGetpregunta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPregunta');
    }

}
