<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoSucursalControllerTest extends WebTestCase
{
    public function testGetsucursal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getSucursal');
    }

    public function testCreatesucursal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createSucursal');
    }

    public function testEditsucursal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editSucursal');
    }

}
