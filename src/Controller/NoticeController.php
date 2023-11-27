<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Entity\User;
use App\Form\NoticeType;
use App\Repository\NoticeRepository;
use App\Repository\UserRepository;
use App\Service\ImageService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('notice')]
class NoticeController extends AbstractController
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'notice_index', methods: 'GET')]
    public function index(
        NoticeRepository $noticeRepository,
        ?UserInterface $user,
    ): Response
    {
        if ($user && in_array(strtoupper('ROLE_ADMIN'), $user->getRoles())) {
            $notices = $noticeRepository->findAll();
        } else {
            $notices = $noticeRepository->getActualNotices();
        }

        $deleteForms = [];
        foreach ($notices as $notice) {
            $deleteFormView = $this->createDeleteForm($notice)->createView();
            $deleteForms[] = $deleteFormView;
        }

        return $this->render('notice/index.html.twig', [
            'notices' => $notices,
            'delete_forms' => $deleteForms,
            'tableTitle' => 'All Notices',
        ]);
    }

    #[Route('/new', name: 'notice_new', methods: ['GET', 'POST'])]
    public function newAction(
        Request $request,
        ImageService $imageService,
        ?UserInterface $user,
        SessionInterface $session,
        TokenInterface $token
    ): Response
    {
        if ($user === null || !in_array('ROLE_USER', $user->getRoles())) {
            return $this->redirectToRoute('notice_index');
        }

        $notice = new Notice();
        $notice->setUser($user);

        if(!in_array('ROLE_ADMIN',$user->getRoles() )){
            $notice->setExpiration(new DateTime('+7 days'));
        }

        $form = $this->createForm(NoticeType::class, $notice, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                try {
                    $properFileName = $imageService->moveImage($image, uniqid(), $this->getParameter('images_directory'));
                } catch (FileException $e) {
                    $e->getMessage();
                    $session->getFlashBag()->add('fail',$e->getMessage());
                }

                $notice->setImage($properFileName);
            }

            $this->em->persist($notice);
            $this->em->flush();

            return $this->redirectToRoute('notice_show', [
                'id' => $notice->getId(),
            ]);
        }

        return $this->render('notice/new.html.twig', [
           'notice' => $notice,
           'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'notice_show', methods: ['GET'])]
    public function showAction(Notice $notice): Response
    {
        return $this->render('notice/show.html.twig', [
            'notice' => $notice,
        ]);
    }

    /**
     * Displays a form to edit an existing notice entity.
     */
    #[Route('/{id}/edit', name: 'notice_edit', methods: ['GET', 'POST'])]
    public function editAction(
        Request $request,
        ImageService $imageService,
        Notice $notice,
        UserInterface $user,
        SessionInterface $session): Response
    {

        $form = $this->createForm(NoticeType::class, $notice, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['image']->getData();
            if ($image) {
                try {
                    $properFileName = $imageService->moveImage($image, uniqid(), $this->getParameter('images_directory'));
                } catch (FileException $e) {
                    $e->getMessage();
                    $session->getFlashBag()->add('fail',$e->getMessage());
                }

                $notice->setImage($properFileName);
            }

            $this->em->persist($notice);
            $this->em->flush();

            $session->getFlashBag()->add('success','Edition was successful!');

            return $this->redirectToRoute('notice_edit', ['id' => $notice->getId()]);
        }

        $userId = $user->getId();

        return $this->render('notice/edit.html.twig', [
            'notice' => $notice,
            'form' => $form->createView(),
            'id' => $userId
        ]);
    }

    /**
     * Creates a form to delete a notice entity.
     *
     * @param Notice $notice The notice entity
     *
     * @return \Symfony\Component\Form\FormInterface The form
     */
    private function createDeleteForm(Notice $notice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_delete', ['id' => $notice->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    #[Route('/{id}', name: 'notice_delete', methods: ['GET', 'POST'])]
    public function deleteActionIfShouldBeDeleted(Request $request, Notice $notice, TokenInterface $token)
    {
        $form = $this->createDeleteForm($notice);
        $form->handleRequest($request);

        if($request->isMethod('POST')) {
            $form->submit($request->request->all()[$form->getName()]);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->remove($notice);
                $this->em->flush();

                $previousRoute = $request->headers->get('referer');
                if (str_contains($previousRoute, 'notice/user')) {

                    /** @var User $user */
                    $user = $token->getUser();

                    return $this->redirectToRoute('notices_by_userId', ['id' => $user->getId()]);
                } else {
                    return $this->redirectToRoute("notice_index");
                }
            }
        }

        return false;
    }

    #[Route('/user/{id}', name: 'notices_by_userId')]
    public function showNoticesByUserIdAction(UserRepository $userRepository)
    {
        $userId = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $user = $userRepository->find($userId);

        $repo = $this->em->getRepository(Notice::class);
        /** @var NoticeRepository $repo */
        $notices = $repo->getActualNoticesById($userId);

        $deleteForms = [];
        foreach ($notices as $notice) {
            $deleteFormView = $this->createDeleteForm($notice)->createView();
            $deleteForms[] = $deleteFormView;
        }

        return $this->render(
            'notice/index.html.twig',
            [
                'notices' => $notices,
                'delete_forms' => $deleteForms,
                'username' => $user,
                'tableTitle' => 'Your notices'
            ]);
    }
}
