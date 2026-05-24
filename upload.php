<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./models/Images.php";

$image = new Images();



foreach ($_FILES['profileImage']['name'] as $key => $file) {
    /// Provera velicine slike (maksimalna dozvoljena velicina slike je 2MB) ///
    $imageSize = $_FILES['profileImage']['size'][$key];

    if (!$image->isValidSize($imageSize)) {
        $_SESSION['uploadErrors'][] = "Slika je prevelika! Maksimalna dozvoljena velicina slike je 2MB.";
        continue;
    }

    /// Provera formata slike (jpeg, jpg, png, gif) ///
    $imgName = $_FILES['profileImage']['name'][$key];
    $imageType = pathinfo($imgName, PATHINFO_EXTENSION);

    if (!$image->isValidExtension($imageType)) {
        $_SESSION['uploadErrors'][] =  "Format slike nije dobar, mora biti: " . implode(', ', Images::ALLOWED_EXTENSIONS);
        continue;
    }

    /// Provera maksimalne sirine i visine slike (1920x1024) ///
    $tmpName = $_FILES['profileImage']['tmp_name'][$key];
    list($imageWidth, $imageHeight) = getimagesize($tmpName);

    if (!$image->isValidDimensions($imageWidth, $imageHeight)) {
        $_SESSION['uploadErrors'][] =  "Maksimalna dozvoljena sirina slike je 1920px, a maksimalna dozvoljena visina slike je 1024px.";
        continue;
    }

    /// Generisanje jedinstvenog imena slike ///
    $randomName = $image->generateRandomName($imageType);
    if (!is_dir('./uploads')) {
        mkdir('./uploads', permissions: 0755, recursive: true);
    }

    /// Upload slike i cuvanje imena slike u bazi podataka ///
    if (!$image->upload($tmpName, $randomName, "uploads")) {
        $_SESSION['uploadErrors'][] =  "Upload slike nije uspeo!";
    } else {
        $_SESSION['uploadSuccess'][] = "Uspesan upload slike!";
    }
}

header("Location: images.php");
