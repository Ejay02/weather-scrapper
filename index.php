<?php
    $weather = "";
    $error = "";

    if(array_key_exists('city', $_GET)) {
        $city = str_replace(' ', '', $_GET['city']);
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . 
            $city . "/forecasts/latest");

        if($file_headers[0] == "HTTP/1.1 404 Not Found") {
            $error = "That city could not be found.";
        }
        else {
            $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/" . 
              $city . "/forecasts/latest");

            $pageArray = 
               explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">',
               $forecastPage);

            if(sizeof($pageArray) > 1) {
                $secondPageArray = explode('</span></p></td>', $pageArray[1]);

                if(sizeof($secondPageArray) > 1) {
                    $weather = $secondPageArray[0];
                }
                else {
                    $error = "That city could not be found.";
                }
            }
            else {
                $error = "That city could not be found.";
            }
        }
    }
    else {
        $error = "That city could not be found.";
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" type="text/css" href="index.css" />
  </head>
  <body>
    <div class="container">
      <h1 id="font">Whats the weather? </h1>
      <form>
        <fieldset class="fotm-group">
          <label for="city" id="font"> Enter the name of a city</label>
          <input
            type="text"
            class="form-control"
            name="city"
            id="city"
            placeholder="E.g. Dubai, Tokyo"
            value = "<?php
              if(array_key_exists('city', $_GET)){
                echo $_GET['city'];
              }
            ?>"
          />
        </fieldset>
        <button id="submit" class="btn btn-primary">Submit</button>
      </form>

      <div id="weather">
        <?php
        
        if($weather){
          echo '<div class="alert alert-success" role="alert">'
            . $weather .
           '</div>';
        }
        else if ($error) {
           echo '<div class="alert alert-danger" role="alert">' .$error . '</div>';
        }
        
        ?>
      </div>
    </div>

    <script
      src="https://code.jquery.com/jquery-3.6.4.js"
      integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
