<?php
session_start();
?>
<title>demoCpatcha.php</title>

<body style="background-color:#ddd; ">
    <?php
    display();
    create_image();
    function display()
    {
        ?>
        <div style="text-align:center;">
            <h3>TYPE THE TEXT YOU SEE IN THE IMAGE</h3>
            <b>This is just to check if you are a robot</b>

            <div style="display:block;margin-bottom:20px;margin-top:20px;">
                <img src="linux.jpg">
            </div>
        </div>
    <?php
    }
    function  create_image()
    {
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
        $line_color = imagecolorallocate($image, 64, 64, 64);
        for ($i = 0; $i < 10; $i++) {
            imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
        }
        $pixel_color = imagecolorallocate($image, 0, 0, 255);
        for ($i = 0; $i < 1000; $i++) {
            imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
        }
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $len = strlen($letters);
        $letter = $letters[rand(0, $len - 1)];

        $text_color = imagecolorallocate($image, 0, 0, 0);

        for ($i = 0; $i< 6;$i++) {
            $letter = $letters[rand(0, $len-1)];
            imagestring($image, 5,  5+($i*30), 20, $letter, $text_color);
           
        }
    
        imagepng($image, "linux.jpg");
    }


    ?>
</body>

<?php

?>