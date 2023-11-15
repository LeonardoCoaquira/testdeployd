<!DOCTYPE html>

<?php
$api_endpoint = $_ENV["API_ENDPOINT"] ?: "http://localhost:5000/api/";
$err = "";
$links = [];    
$domainct = [];
$json_data = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == 0) {
        $file_name = $_FILES["csv_file"]["name"];
        $file_tmp = $_FILES["csv_file"]["tmp_name"];

        if (pathinfo($file_name, PATHINFO_EXTENSION) === "csv") {
            $csv_data = array_map("str_getcsv", file($file_tmp));
            $headers = array_shift($csv_data);

            foreach ($csv_data as $row) {
                $json_data[] = array_combine($headers, $row);
            }

            $json = json_encode($json_data, JSON_PRETTY_PRINT);
            $json_param = urlencode($json);
            
            $url_with_json = $api_endpoint . $json_param;
            
            // Hacer la solicitud a la API y obtener la respuesta HTML
            $html_response = @file_get_contents($url_with_json);
            
            if ($html_response !== false) {
                // Aquí puedes procesar o mostrar el HTML según tus necesidades
                echo "Respuesta HTML de la API: " . $html_response;
            } else {
                echo "Error al obtener la respuesta HTML de la API.";
            }
            
        } else {
            $err = "Invalid file format. Please upload a CSV file.";
        }
    } else {
        $err = "File upload failed. Please try again.";
    }
}
?>

<html>
<head>
    <meta charset="utf-8">
    <title>Link Extractor</title>
    <style media="screen">
        /* ... (tu estilo CSS actual) ... */
    </style>
</head>
<body>
    <div class="header">
        <h1><a href="/">Link Extractor</a></h1>
    </div>

    <section>
        <form action="/" method="post" enctype="multipart/form-data">
            <input class="button" type="submit" value="Extract Links">
            <input type="file" name="csv_file" accept=".csv">
        </form>
    </section>

    <?php if ($err): ?>
        <section>
            <h2>Error</h2>
            <p class="error"><?php echo $err; ?></p>
        </section>
    <?php endif; ?>

    <?php if (!empty($json_data) && ! $err): ?>
        <section>
            <h2>JSON Data</h2>
            <pre><?php echo htmlspecialchars($json, ENT_QUOTES, 'UTF-8'); ?></pre>
        </section>
    <?php endif; ?>

    <section>
      <h2>Generate Plot</h2>
      <p>Generate a plot from a CSV file:</p>
      <form action="http://<tu-direccion-de-flask>:<puerto-flask>/api/generate_plot" method="post" enctype="multipart/form-data">
          <label for="filename">CSV File:</label>
          <input type="file" id="filename" name="filename" accept=".csv" required>
          <input type="submit" value="Generate Plot">
      </form>
  </section>

    <div class="footer">
        <p><a href="https://github.com/ibnesayeed/linkextractor">Link Extractor</a> by <a
                    href="https://twitter.com/ibnesayeed">@ibnesayeed</a> from
            <a href="https://ws-dl.cs.odu.edu/">WS-DL, ODU</a>
        </p>
    </div>
</body>
</html>