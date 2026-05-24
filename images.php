<?php

require_once "models/Images.php";
$img = new Images();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/images.css">
</head>

<body>

    <!-- Poruka o gresci pri upload-u -->
    <div>
        <?php if (isset($_SESSION['uploadErrors'])): ?>
            <?php foreach ($_SESSION['uploadErrors'] as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['uploadErrors']); ?>
        <?php endif; ?>
    </div>

    <!-- Poruka o uspesnom upload-u -->
    <div>
        <?php if (isset($_SESSION['uploadSuccess'])): ?>
            <?php foreach ($_SESSION['uploadSuccess'] as $success): ?>
                <p><?= $success ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['uploadSuccess']); ?>
        <?php endif; ?>
    </div>

    <!-- Prikaz galerije slika -->
    <div class="gallery-container">
        <div class="gallery-header">
            <h1>Image Gallery</h1>
            <p>Uploaded images preview</p>
        </div>
        <div class="gallery-grid">
            <?php foreach ($img->getAllImages() as $image): ?>
                <div class="image-card">
                    <img
                        src="./uploads/<?php echo $image['image']; ?>"
                        alt="Slika">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>