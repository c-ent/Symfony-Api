<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/customers');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateCustomer(): void
    {
        $client = static::createClient();
        $client->request('POST', '/customers', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstName' => 'Test',
                'lastName' => 'User',
                'email' => 'test@example.com',
                'country' => 'Test Country',
            ])
        );
    
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201); // Assuming that a 201 status code is returned when a customer is successfully created
    }

    public function testEditCustomer(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/customers/8', [], [], ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'firstName' => 'Updated Test',
                'lastName' => 'User',
                'email' => 'updated_test@example.com',
                'country' => 'Updated Test Country',
            ])
        );
    
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200); // Assuming that a 200 status code is returned when a customer is successfully updated
    }

    public function testDeleteCustomer(): void
{
    $client = static::createClient();
    $client->request('DELETE', '/customers/8', [], [], ['CONTENT_TYPE' => 'application/json']); // replace 1 with a valid customer ID

    $this->assertResponseIsSuccessful();
    $this->assertResponseStatusCodeSame(200); // Assuming that a 200 status code is returned when a customer is successfully deleted
}

}
