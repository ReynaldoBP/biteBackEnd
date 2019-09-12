<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiModuloControllerTest extends WebTestCase
{
    public function testCreatemodulo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createModulo');
    }

    public function testEditmodulo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editModulo');
    }

    public function testGetmodulo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getModulo');
    }

}
