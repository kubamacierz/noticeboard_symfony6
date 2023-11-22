<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NoticeControllerTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();
//        $client->request('GET', '/');
        $crawler = $client->request('GET', '/');
        $this->assertPageTitleContains('Welcome!');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h5', 'Welcome to the Notice Board!');
//        $this->assertSelectorExists('h4:contains("All Notices")');
//        $this->assertSelectorTextContains('th', 'Title');
    }

}
