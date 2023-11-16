<?php

namespace App\DataFixtures;

use App\Entity\Notice;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NoticeFixtures extends Fixture
{
    private $pictureUrlArray = [
        'https://cdn.pixabay.com/photo/2015/11/19/21/10/glasses-1052010_960_720.jpg',
        'https://cdn.pixabay.com/photo/2019/05/23/13/11/headphones-4223911_960_720.jpg',
        'https://cdn.pixabay.com/photo/2015/01/19/13/51/car-604019_960_720.jpg',
        'https://cdn.pixabay.com/photo/2018/04/01/11/32/motorcycle-3280682_960_720.jpg',
    ];

    private $titleArray = [
        'Ładna książka',
        'Niezły film',
        'Samochód Audi',
        'Motocykl BMW',
    ];

    private $descriptionArray = [
        'opis książki',
        'opis filmu',
        'opis samochodu',
        'opis motocykla',
    ];

    private function persistNotice($pictureUrls, $titles, $descriptions, ObjectManager $manager)
    {
        for ($i = 0; $i < count($titles); $i++) {
            $notice = new Notice();
            $notice->setTitle($titles[$i]);
            $notice->setDescription($descriptions[$i]);
            $notice->setExpiration(new DateTime('+7 days'));
            $notice->setImage(basename($pictureUrls[$i]));
            $notice->setCategory($this->getReference('category_' . rand(1, 2)));
            $manager->persist($notice);
        }
    }


    public function load(ObjectManager $manager): void
    {
        $this->downloadPictures($this->pictureUrlArray);

        $this->persistNotice($this->pictureUrlArray, $this->titleArray, $this->descriptionArray, $manager);

        $manager->flush();
    }

    private function downloadPictures(array $pictureUrls)
    {
        $dir = realpath(__DIR__ . '/../..');
        $uploadsDir = $dir . '/public/uploads/images/';

        foreach ($pictureUrls as $pictureUrl){
            $fileName = basename($pictureUrl);
            if (!file_exists($uploadsDir . $fileName)) {
                file_put_contents($uploadsDir . $fileName, file_get_contents($pictureUrl));
            }
        }
    }
}

