<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageService extends AbstractController
{
    private $newFilename;

    public function moveImage($image)
    {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

        $image->move(
            $this->getParameter('images_directory'),
            $newFilename
        );

        $this->newFilename = $newFilename;

    }

    /**
     * @return mixed
     */
    public function getNewFilename()
    {
        return $this->newFilename;
    }

}
