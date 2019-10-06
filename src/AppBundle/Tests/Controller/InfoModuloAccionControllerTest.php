<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoModuloAccionControllerTest extends WebTestCase
{
    public function testGetmoduloaccion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getModuloAccion');
    }

}
