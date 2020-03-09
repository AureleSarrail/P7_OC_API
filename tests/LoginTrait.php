<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Trait LoginTrait
 * @package App\Tests
 * @method createClient
 *
 */

trait LoginTrait
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return KernelBrowser
     */
    protected function createAuthenticatedClient($username = 'user', $password = 'password')
    {
        /** @var KernelBrowser $client */
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
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}