<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiAccionControllerTest extends WebTestCase
{
    public function testCreateaccion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createAccion');
    }

    public function testEditaccion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editAccion');
    }

    public function testGetaccion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getAccion');
    }

}
