<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InfoUsuarioResControllerTest extends WebTestCase
{
    public function testCreateusuariores()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createUsuarioRes');
    }

    public function testEditusuariores()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editUsuarioRes');
    }

    public function testGetusuariores()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getUsuarioRes');
    }

}
