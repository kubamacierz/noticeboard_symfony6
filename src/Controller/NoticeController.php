<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Form\NoticeType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('notice')]
class NoticeController extends AbstractController
{
    #[Route('/', name: 'notice_index', methods: 'GET')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $noticesRepo = $entityManager->getRepository(Notice::class);

        $notices = $noticesRepo->findAll();


        return $this->render('notice/index.html.twig', [
            'notices' => $notices,
            'tableTitle' => 'All Notices'
        ]);
    }

    #[Route('/{id}', name: 'notice_show', methods: ['GET'])]
    public function showAction(Notice $notice): Response
    {
        return $this->render('notice/show.html.twig', [
            'notice' => $notice
        ]);
    }

    #[Route('/new', name: 'notice_new', methods: ['GET', 'POST'])]
    public function newAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $notice = new Notice();

//        if(! in_array('ROLE_ADMIN',$user->getRoles() )){
            $notice->setExpiration(new DateTime('+7 days'));
//        }

        $form = $this->createForm(NoticeType::class, $notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $e->getMessage();
                }


                $notice->setImage($newFilename);
            }

            $entityManager->persist($notice);
            $entityManager->flush();

            return $this->redirectToRoute('notice_show', [
                'id' => $notice->getId(),
//                'username' => $user
            ]);
        }

        return $this->render('notice/new.html.twig', [
           'notice' => $notice,
           'form' => $form->createView(),
        ]);
    }


}
