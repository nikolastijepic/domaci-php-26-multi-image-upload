<?php

declare(strict_types=1);

require_once "Db.php";

class Images extends Db
{
    const ALLOWED_EXTENSIONS = ['jpeg', 'jpg', 'png', 'gif'];
    const MAX_FILE_SIZE = 2 * 1024 * 1024;
    const MAX_IMAGE_WIDTH = 1920;
    const MAX_IMAGE_HEIGHT = 1024;


    public function isValidSize(int $size): bool
    {
        return $size <= self::MAX_FILE_SIZE;
    }

    public function isValidExtension(string $extension): bool
    {
        return in_array($extension, self::ALLOWED_EXTENSIONS, true);
    }

    public function isValidDimensions(int $imageWidth, int $imageHeight): bool
    {
        return $imageWidth <= self::MAX_IMAGE_WIDTH && $imageHeight <= self::MAX_IMAGE_HEIGHT;
    }

    public function generateRandomName(string $extension): string
    {
        return uniqid('img_') . "." . $extension;
    }

    public function upload(string $image, string $finalName, string $destination): bool
    {
        $finalDestination = $destination . "/" . $finalName;

        if (move_uploaded_file($image, $finalDestination)) {
            $finalName = $this->connection->real_escape_string($finalName);
            return $this->connection->query("INSERT INTO images (image) VALUES ('$finalName')");
        }
        return false;
    }

    public function getAllImages(): object
    {
        return $this->connection->query("SELECT * FROM images");
    }
}
