<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoPromocionControllerTest extends WebTestCase
{
    public function testCreatepromocion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createPromocion');
    }

    public function testEditpromocion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPromocion');
    }

    public function testGetpromocion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPromocion');
    }

}
