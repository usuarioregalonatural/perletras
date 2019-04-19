# Perletras

[![N|Vicsoft](https://www.regalonatural.com)]

[![Build Status](https://github.com/usuarioregalonatural/perletras?branch=master)](https://travis-ci.org/joemccann/dillinger)

Perletras es un docker que recibiendo un texto lo convierte en modo gráfico con fotos.
Se está utlizando para convertir la personalización de jabones de letras a una vista previa de como quedarían.

# Estado y próximos pasos

  - **Estado:** Actualmente recoge la información del texto y genera la foto con las letras "reales"
  - **Próximos pasos**: Componer las letras según los colores enviados.
  - **Ultima versión docker:** v 1.0 

# Descripción  
**Perletras** se basa en un docker, `vicsoft01/tienda_pers` el cual contiene lo siguiente:
* Sistema Operativo: **Ubuntu 18.04.2 LTS (Bionic Beaver)**
* Servidor Web: **Apache/2.4.29 (Ubuntu)**
* Versión PHP: **PHP 7.1.27**
* ImagiMagick: **ImageMagick 6.9.7-4**
* Versión CURL: **curl 7.58.0**

Es necesario disponer de un directorio **fuera del docker** en el sistema host para poder hacer persistentes los datos Web:
 - /*directorio_persistente*

## Ejecución del Docker
El docker se ejecutará mediante docker run como sigue:
```sh
docker run -d -p 8081:80 -v /directorio_persistente:/var/www/html --name tienda_pers -h pers vicsoft01/tienda_pers:1.0
```

Actualmente la ejecución es la siguiente:
```sh
docker run -d -p 8081:80 -v /home/nousers/dockers/tienda/personalizacion/web:/var/www/html --name tienda_pers -h pers vicsoft01/tienda_pers:1.0
```

## Examinar el Docker
Para examinar el contenido del docker una vez en ejecución tendremos que buscar el nombre que tiene:
```sh
docker ps -a
```
Nos mostrará los dockers actuales:
```sh
CONTAINER ID    IMAGE                     COMMAND        CREATED       STATUS   PORTS                 NAMES
09b0b4f05899   vicsoft01/tienda_pers:1.0  "/bin/bash"   2 weeks ago  Up 2 weeks 0.0.0.0:8082->80/tcp tmptienda_pers
```
Elegimos el docker perletras que en este caso hemos nombrado como **tmptienda_pers** y ejecutamos el comando:
```sh
docker container exec -it tmptienda_pers /bin/bash
```
Una vez dentro podremos revisar lo que deseemos.

## Utilización
La utilización de este docker se realizará mediante un llamada **curl** de tipo **POST** que nos devolverá la ruta de la imagen generada con el texto enviado.
Un ejemplo de utilización con PHP es el siguiente:
```php
        $valor="textoenviado";
// abrimos la sesión cURL
        $ch = curl_init();
// definimos la URL a la que hacemos la petición (este será el docker donde ejecuta [perletras])
        curl_setopt($ch, CURLOPT_URL,"http://gestion.vicsoft.net:8081/perletras/index.php");
// indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
// definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $valor);
// recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
// cerramos la sesión cURL
        curl_close ($ch);
// Si el código está dentro de una función, retornamos la url de la imagen generada
       return $remote_server_output;
// si lo vamos a seguir utilizando almacenamos la url en una variable
        $linkImagenGenerada=$remote_server_output;
```
