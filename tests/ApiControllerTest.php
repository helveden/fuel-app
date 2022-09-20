<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{    

    // php bin/phpunit --coverage-html ./reports/

    public function testBaseUrl(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/');

        $response = $client->getResponse();
        
        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
    }
    
    public function testIndexPdv()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/pdv');

        $response = $client->getResponse();
        
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
    
    public function testShowPdv()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/pdv/1');

        $response = $client->getResponse();
        
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }
    
    public function testSearchPdvByCity()
    {
        $q = 'Chadrac';

        $client = static::createClient();
        $crawler = $client->request('GET', '/api/search-pdv/' . $q);

        $response = $client->getResponse();
        $content = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());

        $this->assertEquals($q, $content[0]['city']);
        $this->assertEquals($q, $content[0]['datas']['ville']);
    }
}
