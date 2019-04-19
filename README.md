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
```ssh
docker run -d -p 8081:80 -v /directorio_persistente:/var/www/html --name tienda_pers -h pers vicsoft01/tienda_pers:1.0
```

Actualmente la ejecución es la siguiente:
```ssh
docker run -d -p 8081:80 -v /home/nousers/dockers/tienda/personalizacion/web:/var/www/html --name tienda_pers -h pers vicsoft01/tienda_pers:1.0
```

## Examinar el Docker
Para examinar el contenido del docker una vez en ejecución tendremos que buscar el nombre que tiene:
```ssh
docker ps -a
```
Nos mostrará los dockers actuales:
```ssh
CONTAINER ID    IMAGE                     COMMAND        CREATED       STATUS   PORTS                 NAMES
09b0b4f05899   vicsoft01/tienda_pers:1.0  "/bin/bash"   2 weeks ago  Up 2 weeks 0.0.0.0:8082->80/tcp tmptienda_pers
```
Elegimos el docker perletras que en este caso hemos nombrado como **tmptienda_pers** y ejecutamos el comando:
```ssh
docker container exec -it tmptienda_pers /bin/bash
```
Una vez dentro podremos revisar lo que deseemos.

  
