<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoPerfilControllerTest extends WebTestCase
{
    public function testCreateperfil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createPerfil');
    }

    public function testEditperfil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editPerfil');
    }

    public function testGetperfil()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPerfil');
    }

}
