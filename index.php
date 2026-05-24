<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Modern Upload Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form class="upload-card" method="POST" action="upload.php" enctype="multipart/form-data">
        <h1>Upload Images</h1>
        <p>
            Drag & drop your files here or click below to browse and upload multiple images.
        </p>
        <label for="profileImage" class="file-input-wrapper">
            <div class="upload-icon">📁</div>
            <div class="upload-text">
                <span>Click to upload</span>
                <p id="fileMessage">
                    JPEG, JPG, PNG, GIF supported
                </p>
            </div>
        </label>
        <input
            type="file"
            id="profileImage"
            name="profileImage[]"
            multiple
            hidden>
        <button class="upload-btn" type="submit">
            Upload Files
        </button>
    </form>
    <script src="js/script.js"></script>
</body>

</html>