<?php 
    date_default_timezone_set('America/Sao_Paulo');
    $hora_atual = date('H:i:s');
    $date = date('d');
    $month = date('M');
    $day = date('l');

    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $city = isset($_POST["city"]) ? trim($_POST["city"]) : "";

        if (empty($city)){
            $errorMessage = "Enter city name";
        } else {
            $api_key = ".........add your key...............";
            $api = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $api_key;
            $headers = get_headers($api);

            if (!$headers || strpos($headers[0], '404') !== false){
                $errorMessage = 'City not found';
            } else {
                $api_data = file_get_contents($api);
                // var_dump($api_data);
                if ($api_data === false){
                    $errorMessage = "Error fetching weather data";
                } else {
                    $weather = json_decode($api_data, true);
                    // print_r($weather);
                    $celcius = number_format(($weather['main']['temp'] - 273.15), 0);

                    switch ($weather['weather'][0]['icon']){
                        case "01d":
                            $icon = "img/01d.png";
                            break;
                        case "01n":
                            $icon = "img/01n.png";
                            break;
                        case "02d":
                            $icon = "img/02d.png";
                            break;
                        case "02n":
                            $icon = "img/02n.png";
                            break;
                        case "03d":
                            $icon = "img/03d.png";
                            break;
                        case "03n":
                            $icon = "img/03n.png";
                            break;
                        case "04d":
                            $icon = "img/04.png";
                            break;
                        case "04n":
                            $icon = "img/04.png";
                            break;
                        case "09d":
                            $icon = "img/09.png";
                            break;
                        case "09n":
                            $icon = "img/09.png";
                            break;
                        case "10d":
                            $icon = "img/10d.png";
                            break;
                        case "10n":
                            $icon = "img/10n.png";
                            break;
                        case "11d":
                            $icon = "img/11.png";
                            break;
                        case "11n":
                            $icon = "img/11.png";
                            break;
                        case "13d":
                            $icon = "img/13.png";
                            break;
                        case "13n":
                            $icon = "img/13.png";
                            break;
                        case "50d":
                            $icon = "img/50d.png";
                            break;
                        case "50n":
                            $icon = "img/50n.png";
                            break;
                            
                        
                        default:
                            $icon = "img/n-clear-sky.png";
                    }
                    
                }
            }
        }
    }
    /*if (isset($_POST["submit"]) && isset($weather)){
        $status = 1;
    } elseif (isset($errorMessage)){
        $status = 2;
        echo "$errorMessage";
        // unset($errorMessage);
    }*/
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Previsão do Tempo</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <h1>Weather App API</h1>
        <form method="post">
            <span class="date"><?php echo "Today is $day, $date $month<br>";?></span>
            <div class="input-with-icon">
                <input type="text" name="city" placeholder="Enter city name">
                <button type="submit" name="submit"><i class="fas fa-search"></i></button>
            </div>

        </form>

        <?php
            if (isset($_POST["submit"]) && isset($weather)){?>
                
                <div class='name-city'>
                    <h3><i class='fa-solid fa-location-dot'></i> <?php echo $weather['name'];?></h3>
                    <div><?php echo $hora_atual;?></div>
                </div>
                <div class="container-date">
                    <div>
                        <span class='celcius-degrees'><?php echo $celcius ?></span>
                        <span class='degrees'>°</span> 
                        <span class="celcius">C</span><br>
                        <div class="description">
                            <?php echo $weather['weather'][0]['description']?>
                        </div>
                    </div>

                    <div class='container-img'>
                        <img src='<?php echo $icon ?>'>
                    </div>
                </div>
                        
                <div class='icons'>
                    <div class="humidity">
                        <span>Humidity</span>
                        <div class="icons-humidity">
                            <i class='fa-solid fa-droplet'></i>  
                            <?php echo $weather['main']['humidity'] . '%';?>
                        </div>
                        
                    </div>
                    <div class="speed">
                        <span>Speed</span>
                        <div class="icons-speed">
                            <i class='fa-solid fa-wind'></i> 
                            <?php echo $weather['wind']['speed'];?>
                        </div>
                    </div>

                </div>
                
            <?php 
            } elseif (isset($errorMessage)){
                echo "$errorMessage";
                // unset($errorMessage);
            }?>
    
    </main>
</body>
</html>