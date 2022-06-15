<?php
session_start();
$_SESSION['count'] = time();
$image;
?>
<html>
<head>
<link rel="stylesheet" href="style.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<title>PROYECTO CAPTCHA</title>
<body>

<?php
$flag = 5;
if (isset($_POST["flag"])) {
    $input = $_POST["input"];
    $flag = $_POST["flag"];
}

if ($flag == 1) {
    if ($input == $_SESSION['captcha_string']) {
        ?>

        <div style="text-align:center;">
            <h1>El CAPTCHA es Correcto!!!</h1>

            <form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="submit" value="Refrescar la pagina" class="btn btn-primary" style="background-color:#e088f9;">
            </form>
        </div>

    <?php

    } else {
        ?>

        <div style="text-align:center;">
            <h1>El CAPTCHA no es Correcto!!!</h1>

            <form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="submit" value="Refrescar la pagina" class="btn btn-primary" style="background-color:#e088f9;">
            </form>
        </div>

        <?php
        
    }
} else {
    create_image();
    display();
}

function display()
{
    ?>

<div class="card mt-5" style="max-width:500px;margin:auto;">
    <div class="card-body text-center" >

        <div style="text-align:center;">
            <h3 class="h3 mb-3">Escribe el texto que vez en la imagen (CAPTCHA)</h3>
            <b class="mb-3">Este es un Test para verificar que no eres un Robot</b>

            <div style="display:block;margin-bottom:20px;margin-top:20px;">
                <img src="image<?php echo $_SESSION['count'] ?>.png">
            </div>
            <form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" name="input"  class="form-control"/>
            <input type="hidden" name="flag" value="1"/>
            <br>
            <div class="seccion-enviar1 d-flex align-items-center justify-content-center mt-3 mb-3">
            <input type="submit" value="Enviar" name="submit" class="btn btn-primary" style="background-color:#e088f9;"/>
            </div>
            </form>

            <form action=" <?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="submit" value="Refrescar la pagina" class="btn btn-primary" style="background-color:#e088f9;">
            </form>
        </div>

    </div>
</div>

<?php
}

function  create_image()
{
    global $image;
    $image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");

    $background_color = imagecolorallocate($image, 224, 136, 249);
    $text_color = imagecolorallocate($image, 0, 255, 255);
    $line_color = imagecolorallocate($image, 255, 255, 255);
    $pixel_color = imagecolorallocate($image, 0, 0, 255);

    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);

    for ($i = 0; $i < rand()%100; $i++) {
        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
    }

    for ($i = 0; $i < 1000; $i++) {
        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
    }


    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $len = strlen($letters);
    $letter = $letters[random_int(0, $len - 1)];

    $text_color = imagecolorallocate($image, 0, 0, 0);
    $word = "";
    for ($i = 0; $i < 6; $i++) {
        $letter = $letters[random_int(0, $len - 1)];
        imagestring($image, 500, 5 + ($i * 30), 20, $letter, $text_color);
        $word .= $letter;
    }
    $_SESSION['captcha_string'] = $word;

    $images = glob("*.png");
    foreach ($images as $image_to_delete) {
        @unlink($image_to_delete);
    }
    imagepng($image, "image" . $_SESSION['count'] . ".png");

}

?>

</body>
</html>