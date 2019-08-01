<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaisControllerTest extends WebTestCase
{
    public function testGetpais()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getPais');
    }

}
