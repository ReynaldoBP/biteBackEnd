<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoEncuestaControllerTest extends WebTestCase
{
    public function testCreateencuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createEncuesta');
    }

    public function testEditencuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editEncuesta');
    }

    public function testGetencuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getEncuesta');
    }

}
