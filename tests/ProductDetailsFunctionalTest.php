<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductDetailsFunctionalTest extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return Client
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => $username,
                'password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

//        dd($data);

//        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    public function testProductDetails()
    {
        $client = $this->createAuthenticatedClient('PhoneSale', 'test');

        $client->request('GET', '/products/1');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertCount(7, $data);
        $this->assertIsArray($data);
        $this->assertJson($client->getResponse()->getContent());

//        $client = $this->createAuthenticatedClient('PhoneSale', 'test');
//        $client->request('GET', '/products/1');
//
//        $this->assertEquals(404, $client->getResponse()->getStatusCode());

    }
}