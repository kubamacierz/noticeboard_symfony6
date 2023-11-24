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
//    public function testCreateDeleteForm()
//    {
//        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
//        $noticeMock = $this->createMock(Notice::class);
//        $noticeMock->expects(self::once())
//            ->method('getId')
//            ->willReturn('1');
//
//        $noticeController = new NoticeController($entityManagerMock);
//        $this->assertEquals(FormInterface::class, $noticeController->);
//    }

//    public function testDeleteActionIfShouldBeDeleted()
//    {
//        $entityManagerMock = $this->createMock(EntityManagerInterface::class);
//
//        $notice = new Notice();
//        $notice->setTitle('test1');
//        $notice->setExpiration(new DateTime('+ 7 days'));
//
//        $noticeController = new NoticeController($entityManagerMock);
//
//
//    }


//    public function testIndex()
//    {
//        $user = new User();
//        $user->setUsername('tester');
//        $user->addRole('ROLE_USER');
//        $user->setEmail('test@test.com');
//        $user->setPassword('test');
//
//        $category = new Category();
//        $category->setCategoryName('test');
//
//        $notice = new Notice();
//        $notice->setTitle('test1');
//        $notice->setDescription('blabla');
//        $notice->setCategory($category);
//        $notice->setUser($user);
//
//        $noticeRepositoryMock = $this->createMock(NoticeRepository::class);
//        $noticeRepositoryMock->expects(self::once())
//            ->method('find')
//            ->willReturn($notice);
//
//        $userMock = $this->createMock(UserInterface::class)
//            ->expects(self::once())
//            ->willReturn(null);
//
//
//        $index = new NoticeController();
//        $this->assertEquals('test1', $notice->getTitle());
//    }

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
