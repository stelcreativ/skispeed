<?php

namespace App\Service;

use App\Entity\Image;

class Uploader {

    /**
     * Donner un nom et un path à l'image à enregistrer en BDD
     *
     * @param Image $image
     * @return Image $image
     */
    public function upload(Image $image): Image
    {
        // Uploader le fichier de l'image
        $file = $image->getFile();
        // Créer un nom unique pour le fichier
        $name = md5(uniqid()) . '.' . $file->guessExtension();
        // Déplacer le fichier
       
        $file->move($this->getParameter['upload_directory'], $name);

        // Donner le path et le nom au fichier dans la base de données
        $image->setUploadDirectory($url);
        $image->setName($name);

        return $image;
    }

}