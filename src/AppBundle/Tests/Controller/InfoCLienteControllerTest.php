<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoCLienteControllerTest extends WebTestCase
{
    public function testEditcliente()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editCliente');
    }

}
