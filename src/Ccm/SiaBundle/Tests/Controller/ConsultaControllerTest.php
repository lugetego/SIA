<?php

namespace Ccm\SiaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConsultaControllerTest extends WebTestCase
{
    public function testConsulta()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/consulta');
    }

}
