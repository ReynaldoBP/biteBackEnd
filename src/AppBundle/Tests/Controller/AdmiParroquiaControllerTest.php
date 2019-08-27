<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiParroquiaControllerTest extends WebTestCase
{
    public function testGetparroquia()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getParroquia');
    }

}
