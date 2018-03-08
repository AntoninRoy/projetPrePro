<?php

namespace ForumBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testDisplayaccount()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/displayAccount');
    }

}
