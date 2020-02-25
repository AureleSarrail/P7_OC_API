<?php


namespace App\Tests;


use App\Entity\Customer;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerCreationFunctionalTest extends WebTestCase
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

    /**
     * @param SerializerInterface $serializer
     */
    public function testCustomerCreation()
    {
        $data = [
            'name' => 'Aurele',
            'street' => 'Dufay',
            'city' => 'Rouen',
            'zip_code' => '76000',
            'country' => 'France',
            'mail' => 'aurele.sarrail@gmail.com'
        ];
        $json = json_encode($data);
        $client = $this->createAuthenticatedClient('PhoneSale', 'test');
        $client->request('PUT', '/customers/create', [], [], [], $json);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }
}