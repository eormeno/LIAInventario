<?php

namespace App\Utils;

class FakeImage
{
    public static function generateBase64Image()
    {
        // Generar una imagen aleatoria
        $image = imagecreatetruecolor(200, 200);
        // Rellenar la imagen con un color aleatorio
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagefill($image, 0, 0, $color);
        // Convertir la imagen a Base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
