<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 12/04/2019
 * Time: 18:52
 */
use Imagick;

define("ruta",$_SERVER['DOCUMENT_ROOT'] . "/perletras/images/");
//      $valor=htmlspecialchars($_POST["nombre"]);
//   echo $valor;
 $valor="manada";
//echo ProcesaPalabra("pepe");

ProcesaPalabra($valor);

//TrataImagenes($valor);
//appendImages();

function ProcesaPalabra ($texto){
    $array_letras = str_split($texto);
    $longitud_array=count($array_letras);
    $ancho=0;
    for($i=0; $i<$longitud_array; $i++)
        {
            $letra=$array_letras[$i];
            $imagenes[0][$i]=ruta . "letra-".$letra . ".png";
        }
   $imagen_final=new Imagick();

    foreach ($imagenes as $imageRow) {
        $ancho=$ancho + 200;
        $rowImagick = new Imagick();
        $rowImagick->setBackgroundColor('gray');
        foreach ($imageRow as $imagePath) {
            $imagick = new Imagick(realpath($imagePath));
            $rowImagick->addImage($imagick);
        }
        $rowImagick->resizeImage($ancho,$ancho,\Imagick::FILTER_LANCZOS,1.0, true);
        $rowImagick->resetIterator();
        //Add the images horizontally.
        $combinedRow = $rowImagick->appendImages(false);
        $imagen_final->addImage($combinedRow);
  //      $imagen_final->resizeImage(200,100,\Imagick::FILTER_LANCZOS,1.0, true);
    }
    $imagen_final->setImageFormat('png');
 //   $imagen_final->resizeImage(200,200,\Imagick::FILTER_LANCZOS,1.0, true);
    header("Content-Type: image/png");
    echo $imagen_final->getImageBlob();
    $imagen_final->writeImage(ruta . $texto. ".png");
    return ;
}




?>