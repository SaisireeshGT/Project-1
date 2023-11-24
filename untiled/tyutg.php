<?php
$status = "";
$msg = "";
$city = "";

if (isset($_POST['submit'])) {
    $city = $_POST['city'];
    $url = "http://api.openweathermap.org/data/2.5/weather?q=$city&appid=a249702aeca89669623203f117094e5b";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result, true);

    if ($result['cod'] == 200) {
        $status = "yes";
    } else {
        $msg = $result['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Card</title>
    <!-- Include the CSS file -->
    <link rel="stylesheet" href="file.css">
</head>
<body>
<div class="form">
    <form method="post">
        <div class="input-group">
            <input type="text" class="text" placeholder="Enter city name" name="city" value="<?php echo $city ?>"/>
            <input type="submit" value="Submit" class="submit" name="submit"/>
        </div>
        <?php echo $msg ?>
    </form>
</div>

<?php if ($status == "yes") { ?>
    <article class="widget">
        <div class="weatherIcon">
            <img src="http://openweathermap.org/img/wn/<?php echo $result['weather'][0]['icon'] ?>@4x.png"/>
        </div>
        <div class="weatherInfo">
            <div class="temperature">
                <span><?php echo round($result['main']['temp'] - 273.15) ?>°</span>
            </div>
            <div class="description mr45">
                <div class="weatherCondition"><?php echo $result['weather'][0]['main'] ?></div>
                <div class="place"><?php echo $result['name'] ?></div>
            </div>
            <div class="description">
                <div class="weatherCondition">Wind</div>
                <div class="place"><?php echo $result['wind']['speed'] ?> M/H</div>
            </div>
        </div>
        <div class="date">
            <?php echo date('d M', $result['dt']) ?>
        </div>
    </article>
<?php } ?>
</body>
</html>
