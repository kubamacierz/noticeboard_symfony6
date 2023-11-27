<?php

namespace App\Tests\EventListener;

use App\Entity\User;
use App\EventListener\LoginListener;
use DG\BypassFinals;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListenerTest  extends TestCase
{
    public function setUp(): void
    {
        BypassFinals::enable();
    }

    public function testLoginDateChangeSuccessful()
    {
        $emMock = $this->createMock(EntityManagerInterface::class);
        $emMock->expects(self::once())
            ->method('persist');
        $emMock->expects(self::once())
            ->method('flush');

        $listener = new LoginListener($emMock);
        $tokenMock = $this->createMock(TokenInterface::class);
        $tokenMock->expects(self::once())
            ->method('getUser')
            ->willReturn(new User());

        $eventMock = $this->createMock(InteractiveLoginEvent::class);

        $eventMock->expects(self::once())
            ->method('getAuthenticationToken')
            ->willReturn($tokenMock);

        $newEventListener = new LoginListener($emMock);
        $newEventListener->onSecurityInteractiveLogin($eventMock);
    }
}
