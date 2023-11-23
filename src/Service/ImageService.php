<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService
{
    public function moveImage(UploadedFile $image, $uniqid, $dir)
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
