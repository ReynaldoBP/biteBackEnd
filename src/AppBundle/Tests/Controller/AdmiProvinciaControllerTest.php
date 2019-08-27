<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiProvinciaControllerTest extends WebTestCase
{
    public function testGetprovincia()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getProvincia');
    }

}
