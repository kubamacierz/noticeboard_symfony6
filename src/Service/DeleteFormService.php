<?php

namespace App\Service;

use App\Entity\Notice;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteFormService extends AbstractController
{
    public function createDeleteForm(Notice $notice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_delete', ['id' => $notice->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}







