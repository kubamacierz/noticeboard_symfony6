<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageService extends AbstractController
{
    public function moveImage($image, $uniqid, $dir)
    {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $newFilename = $safeFilename . '-' . $uniqid . '.' . $image->guessExtension();

        $image->move(
            $dir,
            $newFilename
        );

        return $newFilename;
    }


}
