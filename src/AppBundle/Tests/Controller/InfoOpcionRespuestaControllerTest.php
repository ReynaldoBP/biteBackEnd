<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoOpcionRespuestaControllerTest extends WebTestCase
{
    public function testGetopcionrespuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getOpcionRespuesta');
    }

    public function testCreateopcionrespuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createOpcionRespuesta');
    }

    public function testEditopcionrespuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editOpcionRespuesta');
    }

}
