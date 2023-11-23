<?php

namespace App\Tests\Service;

use App\Entity\Notice;
use App\Service\DeleteFormService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Uid\Uuid;
use function PHPUnit\Framework\once;

class DeleteFormServiceTest extends KernelTestCase
{
    public function testCreateDeleteForm()
    {
//        $entityManagerMock = $this->createMock(EntityManagerInterface::class);

        $uuid = Uuid::fromString('018bf1bb-e4c3-79df-b403-e2e4bbe9f1a8');

        $noticeMock = $this->createMock(Notice::class);
        $noticeMock->expects(self::once())
            ->method('getId')
            ->willReturn($uuid);

        $this->assertEquals($uuid, $noticeMock->getId());

        $deleteFormService = new DeleteFormService();
        $this->assertEquals(FormInterface::class, $deleteFormService->createDeleteForm($noticeMock));
    }
}

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
