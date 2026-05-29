<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "./models/Images.php";

$image = new Images();

if ($_FILES['profileImage']['error'][0] === UPLOAD_ERR_NO_FILE) {
    $_SESSION['uploadErrors'] = "Morate odabrati barem jednu sliku.";
    header("Location: index.php");
    exit;
}

foreach ($_FILES['profileImage']['name'] as $key => $file) {

    $imgName = $_FILES['profileImage']['name'][$key];

    /// Provera velicine slike (maksimalna dozvoljena velicina slike je 2MB) ///
    $imageSize = $_FILES['profileImage']['size'][$key];

    if (!$image->isValidSize($imageSize)) {
        $_SESSION['uploadErrors'][] = "Slika je prevelika (max 2MB): $imgName";
        continue;
    }

    /// Provera formata slike (jpeg, jpg, png, gif) ///
    $imageType = pathinfo($imgName, PATHINFO_EXTENSION);

    if (!$image->isValidExtension($imageType)) {
        $_SESSION['uploadErrors'][] =  "Format slike nije dobar, mora biti: " . implode(', ', Images::ALLOWED_EXTENSIONS) . " : $imgName";
        continue;
    }

    /// Provera maksimalne sirine i visine slike (1920x1024) ///
    $tmpName = $_FILES['profileImage']['tmp_name'][$key];
    list($imageWidth, $imageHeight) = getimagesize($tmpName);

    if (!$image->isValidDimensions($imageWidth, $imageHeight)) {
        $_SESSION['uploadErrors'][] =  "Maksimalne dozvoljene dimenzije slike su 1920x1024: $imgName";
        continue;
    }

    /// Generisanje jedinstvenog imena slike ///
    $randomName = $image->generateRandomName($imageType);
    if (!is_dir('./uploads')) {
        mkdir('./uploads', permissions: 0755, recursive: true);
    }

    /// Upload slike i cuvanje imena slike u bazi podataka ///
    if (!$image->upload($tmpName, $randomName, "uploads")) {
        $_SESSION['uploadErrors'][] =  "Neuspesan upload slike: $imgName";
    } else {
        $_SESSION['uploadSuccess'][] = "Uspesan upload slike: '$imgName'";
    }
}

header("Location: images.php");
exit;
