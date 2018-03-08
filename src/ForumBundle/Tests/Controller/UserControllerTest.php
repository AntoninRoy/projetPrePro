<?php

namespace ForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testDisplayaccount()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/displayAccount');
    }

    public function testCreateaccount()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/createAccount');
    }

    public function testAccountparameters()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accountParameters');
    }

    public function testNewtopic()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newTopic');
    }

    public function testTopic()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/topic');
    }

    public function testHome()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/home');
    }

}
