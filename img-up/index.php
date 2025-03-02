<?php
// Define the target directory for uploads
$targetDir = "images/";
$maxFileSize = 10 * 1024 * 1024; // 10MB
$message = "Made With ♥️ by Daven, Max 10MB";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file'];
        
        // Validate file size
        if ($file['size'] > $maxFileSize) {
            $message = "Error: File size exceeds 10MB.";
        } else {
            // Validate file type
            $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($fileType, $allowedTypes)) {
                $message = "Error: Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            } else {
                // Generate a random file name
                $randomName = bin2hex(random_bytes(5)) . '.' . $fileType;
                $targetFilePath = $targetDir . $randomName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    $message = "File uploaded successfully! Download your file using the link below:<br>";
                    $message .= "<input type='text' value='" . $targetFilePath . "' readonly />";
                    $message .= "<button onclick='copyToClipboard(\"" . $targetFilePath . "\")'>Copy URL</button>";
                } else {
                    $message = "Error: There was an error uploading your file.";
                }
            }
        }
    } else {
        $message = "Error: No file uploaded or there was an upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uploader</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        input[type="file"] {
            margin-bottom: 1rem;
        }
        button {
            background-color: #4F46E5;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4338CA;
        }
        .message {
            margin-top: 1rem;
            color: #333;
        }
    </style>
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('URL copied to clipboard!');
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Upload Your Image</h1>
        <form id="uploadForm" enctype="multipart/form-data" method="POST">
            <input type="file" name="file" id="file" required />
            <button type="submit">Upload Image</button>
        </form>
        <div class="message">
            <?php if ($message) echo $message; ?>
        </div>
    </div>
</body>
</html>