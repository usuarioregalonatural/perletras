<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 12/04/2019
 * Time: 18:52
 */
use Imagick;

define("ruta",$_SERVER['DOCUMENT_ROOT'] . "/perletras/images/");
define("imgfondo","fondo004.jpg");

//      $valor=htmlspecialchars($_POST["nombre"]);
//   echo $valor;
 $valor="damian";

ProcesaPalabra($valor);

function ProcesaPalabra ($texto){
    $array_letras = str_split($texto);
    $longitud_array=count($array_letras);
    $nombre_fichero=ruta . $texto. ".png";
    $ancho=0;
    for($i=0; $i<$longitud_array; $i++)
        {
            $letra=$array_letras[$i];
            $imagenes[0][$i]=ruta . "letra-".$letra . ".png";
        }
   $imagen_final=new Imagick();

    foreach ($imagenes as $imageRow) {
    //    $ancho=$ancho + 200;
        $rowImagick = new Imagick();
        $rowImagick->setBackgroundColor('gray');
        foreach ($imageRow as $imagePath) {
            $imagick = new Imagick(realpath($imagePath));
            $rowImagick->addImage($imagick);
        }
   //     $rowImagick->resizeImage($ancho,$ancho,\Imagick::FILTER_LANCZOS,1.0, true);
        $rowImagick->resetIterator();
        //Add the images horizontally.
        $combinedRow = $rowImagick->appendImages(false);
        $imagen_final->addImage($combinedRow);
    }
    $imagen_final->setImageFormat('png');
    header("Content-Type: image/png");
    echo $imagen_final->getImageBlob();
    $imagen_final->writeImage($nombre_fichero);

 //   PoneFondo($texto,$ancho);
//    compositeImage($texto);
    Fusiona2($nombre_fichero,$ancho);
    return ;
}

function PoneFondo ($texto, $ancho){
    $layerMethodType = imagick::LAYERMETHOD_COMPARECLEAR;
    $img2 = new \Imagick(realpath(ruta . "fondo003.jpg"));
    $img2->resizeImage($ancho,$ancho,\Imagick::FILTER_LANCZOS,1.0, true);


    $img1 = new \Imagick(realpath(ruta . $texto. ".png"));
    $img2->addImage($img1);
    $img2->setImageFormat('png');

    $result = $img2->mergeImageLayers($layerMethodType);
    header("Content-Type: image/png");

    echo $result->getImageBlob();
    $result->writeImage(ruta . $texto. "-final.png");

}


function compositeImage($texto)
{
    $img1 = new \Imagick();
    $img1->readImage(realpath(ruta . $texto. ".png"));

    $img2 = new \Imagick();
    $img2->readImage(realpath(ruta . "fondo003.jpg"));

    $img1->resizeimage(
        $img2->getImageWidth(),
        $img2->getImageHeight(),
        \Imagick::FILTER_LANCZOS,
        1
    );

    $opacity = new \Imagick();
    $opacity->newPseudoImage(
        $img1->getImageHeight(),
        $img1->getImageWidth(),
        "gradient:gray(10%)-gray(90%)"
    );
    $opacity->rotateimage('black', 90);

    $img2->compositeImage($opacity, \Imagick::COMPOSITE_COPYOPACITY, 0, 0);
    $img1->compositeImage($img2, \Imagick::COMPOSITE_DEFAULT, 0, 0);

    header("Content-Type: image/jpg");
    echo $img1->getImageBlob();

    $img1->writeImage(ruta . $texto. "-final.png");

}


function Fusiona($texto){
    $nombre = new Imagick();
    $nombre->readImage($texto);

    $fondo= new Imagick();
    $fondo->readImage(ruta . "fondo003.jpg");

    $fondo->compositeImage($nombre, Imagick::COMPOSITE_DEFAULT, 10,20);
  //  $fondo->flattenImages();
    $fondo->setImageFilename($texto);
    $fondo->writeImage();
}


function Fusiona2($texto,$ancho){

    $first = new Imagick(ruta . imgfondo);
    $second = new Imagick($texto);

 //   $second->resizeImage($second->getImageWidth(), $first->getImageHeight(), \Imagick::FILTER_LANCZOS,1);

//    $second->scaleImage($second->getImageWidth(),$second->getImageHeight(),true);
//    $first->scaleImage(1680,1050,true);
   // $second->scaleImage(200,200,false);

    $first->resizeImage(1280,800,1,true);
//    $second->resizeImage(200,200,true,true);
// Set the colorspace to the same value
    $first->setImageColorspace($second->getImageColorspace() );

//    $second->resizeImage(200,200,true,true);
    $second->scaleImage(1000,1000,true,true);

//Second image is put on top of the first
//    $first->compositeImage($second, $second->getImageCompose(), 20, 80);
    $first->compositeImage($second, \Imagick::COMPOSITE_DEFAULT, 120, 380);

//new image is saved as final.jpg
    $first->writeImage(ruta . "final.jpg");

}


function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom) {
    //The blur factor where &gt; 1 is blurry, &lt; 1 is sharp.
    $imagick = new \Imagick(realpath($imagePath));

    $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);

    $cropWidth = $imagick->getImageWidth();
    $cropHeight = $imagick->getImageHeight();

    if ($cropZoom) {
        $newWidth = $cropWidth / 2;
        $newHeight = $cropHeight / 2;

        $imagick->cropimage(
            $newWidth,
            $newHeight,
            ($cropWidth - $newWidth) / 2,
            ($cropHeight - $newHeight) / 2
        );

        $imagick->scaleimage(
            $imagick->getImageWidth() * 4,
            $imagick->getImageHeight() * 4
        );
    }


    header("Content-Type: image/jpg");
    echo $imagick->getImageBlob();
    $imagick->writeImage(ruta . "previa.jpg");
}


?>