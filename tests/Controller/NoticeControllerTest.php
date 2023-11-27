<?php

namespace App\Tests\Controller;

use App\Controller\NoticeController;
use App\Entity\Category;
use App\Entity\Notice;
use App\Entity\User;
use App\Repository\NoticeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class NoticeControllerTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertPageTitleContains('Welcome!');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h5', 'Welcome to the Notice Board!');
    }



}
