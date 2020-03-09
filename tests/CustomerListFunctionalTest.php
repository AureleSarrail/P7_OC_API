<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerListFunctionalTest extends WebTestCase
{
    use LoginTrait;

    public function testCustomerList()
    {
        $client = $this->createAuthenticatedClient('PhoneSale', 'test');

        $client->request('GET', '/api/customers');

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertIsArray($data);
        $this->assertCount(6, $data);
        $this->assertJson($client->getResponse()->getContent());
    }
}