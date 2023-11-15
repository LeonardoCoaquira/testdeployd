<?php
$api_endpoint = $_ENV["API_ENDPOINT"] ?: "http://localhost:5000/api/";
$err = "";
$img_path = "";  // Assuming this variable is where you store the path to the generated plot image

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Your existing code for processing form submission...
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Plot Test</title>
    <!-- Add any additional styles or scripts here if needed -->
</head>
<body>
    <h1>Generate Plot Test</h1>
    <form action="/api/generate_plot" method="post" enctype="multipart/form-data">
        <label for="filename">CSV File:</label>
        <input type="file" id="filename" name="filename" accept=".csv" required>
        <input type="submit" value="Generate Plot">
    </form>
    
    <?php if ($img_path): ?>
        <h2>Generated Plot</h2>
        <img src="/api/<?php echo $img_path; ?>" alt="Generated Plot">
    <?php endif; ?>
</body>
</html>