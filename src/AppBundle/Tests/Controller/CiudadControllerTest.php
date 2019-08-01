<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CiudadControllerTest extends WebTestCase
{
    public function testGetciudad()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getCiudad');
    }

}
