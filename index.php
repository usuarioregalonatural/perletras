<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 12/04/2019
 * Time: 18:52
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Motrar todos los errores de PHP
ini_set('error_reporting', E_ALL);


use Imagick;

define("ruta",$_SERVER['DOCUMENT_ROOT'] . "/perletras/images/");
define("imgfondo","fondo004.jpg");

$nombre=htmlspecialchars($_POST["nombre"]);
ProcesaPalabra($nombre);

function ProcesaPalabra ($texto){
    $nombre=$texto;
    $array_letras = str_split($texto);
    $longitud_array=count($array_letras);
    $nombre_fichero=ruta . $texto. ".png";
    for($i=0; $i<$longitud_array; $i++)
    {
        $letra=$array_letras[$i];
        $imagenes[0][$i]=ruta . "letra-".$letra . ".png";
    }
    $imagen_final=new Imagick();

    foreach ($imagenes as $imageRow) {
        $rowImagick = new Imagick();
        $rowImagick->setBackgroundColor('gray');
        foreach ($imageRow as $imagePath) {
            $imagick = new Imagick(realpath($imagePath));
            $rowImagick->addImage($imagick);
        }
        $rowImagick->resetIterator();
        //Add the images horizontally.
        $combinedRow = $rowImagick->appendImages(false);
        $imagen_final->addImage($combinedRow);
    }
    $imagen_final->setImageFormat('png');
    $imagen_final->writeImage($nombre_fichero);

    Fusiona2($nombre_fichero,$nombre);
    return ;
}

function Fusiona2($texto, $nombre_personalizado){

    $first = new Imagick(ruta . imgfondo);
    $second = new Imagick($texto);
    $first->resizeImage(1280,800,1,true);
// Set the colorspace to the same value
    $first->setImageColorspace($second->getImageColorspace() );
    $second->scaleImage(1000,1000,true,true);
//Second image is put on top of the first
    $first->compositeImage($second, \Imagick::COMPOSITE_DEFAULT, 120, 380);
//new image is saved as final.jpg
    $first->writeImage(ruta . "Final-" . $nombre_personalizado . ".jpg");

    echo "http://gestion.vicsoft.net:8081/perletras/images/" . "Final-" . $nombre_personalizado . ".jpg";
}



?>
