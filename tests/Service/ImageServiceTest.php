<?php

namespace App\Tests\Service;

use App\Service\ImageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageServiceTest extends KernelTestCase
{
    public function testMoveImageSuccessful()
    {
        $imageMock = $this->createMock(UploadedFile::class);
        $imageMock->expects(self::once())
            ->method('getClientOriginalName')
            ->willReturn('file-name.png');
        $imageMock->expects(self::once())
            ->method('guessExtension')
            ->willReturn('png');
        $imageMock->expects(self::once())
            ->method('move');

        $imageService = new ImageService();
        $this->assertEquals(
            'filename-abcd.png',
            $imageService->moveImage($imageMock, 'abcd', '')
        );
    }

    public function testMoveImageSuccessfulConvertsFileNameToLatin()
    {
        $imageMock = $this->createMock(UploadedFile::class);
        $imageMock->expects(self::once())
            ->method('getClientOriginalName')
            ->willReturn('coś-name.png');
        $imageMock->expects(self::once())
            ->method('guessExtension')
            ->willReturn('png');
        $imageMock->expects(self::once())
            ->method('move');

        $imageService = new ImageService();
        $this->assertEquals(
            'cosname-abcd.png',
            $imageService->moveImage($imageMock, 'abcd', '')
        );
    }
}
