<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoRespuestaControllerTest extends WebTestCase
{
    public function testGetrespuesta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getRespuesta');
    }

}
