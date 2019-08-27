<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdmiSectorControllerTest extends WebTestCase
{
    public function testGetsector()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getSector');
    }

}
