<?php

namespace App\Controller;

use AppBundle\Entity\Notice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class LayoutController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function showHomepageAction(UserInterface $user = null)
    {
        if($user === null){
            return $this->render('layout/first_menu.html.twig');
        }

        $userName = $user->getUsername();
        $userId = $user->getId();
        return $this->render('layout/first_menu.html.twig', [
            'username' => $userName,
            'id' => $userId,
        ]);
    }

}
