<?php

class ControladorBlog
{
    /*======================================
    Mostrar contenido tabla blog
    =======================================*/

    static public function ctrMostrarBlog()
    {
        $tabla = "blog";

        $respuesta = ModeloBlog::mdlModeloBlog($tabla);

        return $respuesta;
    }

    /*======================================
    Mostrar contenido tabla categorias
    =======================================*/

    static public function ctrMostrarCategorias($item , $valor)
    {
        $tabla = "categorias";

        $respuesta = ModeloBlog::mdlModelomostrarCategorias($tabla, $item , $valor);

        return $respuesta;
    }

    /*======================================
    Mostrar Articulos y Categorias con Inner Join
    =======================================*/
    static public function ctrMostrarConInnerJoin($desde, $cantidad, $item, $valor)
    {
        $tabla1 = "categorias";
        $tabla2 = "articulos";

        $respuesta = ModeloBlog::mdlMostrarConInnerJoin($tabla1, $tabla2, $desde, $cantidad, $item, $valor);

        return $respuesta;
    }
    /*======================================
    Mostrar Total Articulos
    =======================================*/
    static public function ctrMostrarTotalArticulos($item, $valor)
    {
        $tabla  =  "articulos";

        $respuesta = ModeloBlog::mdlMostrarTotalArticulo($tabla, $item, $valor);

        return $respuesta;
    }
    /*======================================
    Mostrar Opiniones
    =======================================*/
    static public function ctrMostrarOpiniones($item, $valor)
    {
        $tabla1  =  "opiniones";
        $tabla2  =  "administradores";

        $respuesta = ModeloBlog::mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor);

        return $respuesta;
    }

    /*======================================
    Enviar Opinion
    =======================================*/
    static public function ctrEnviarOpinion()
    {
        if (isset($_POST["nombre_opinion"])) {
            if (
                preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["nombre_opinion"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_opinion"]) &&
                preg_match('/^[=\\$\\;\\*\\"\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $_POST["contenido_opinion"])
            ) {

                /*======================================
                Validación Foto lado Servidor
                =======================================*/
                if (isset($_FILES["foto_opinion"]["tmp_name"]) && !empty($_FILES["foto_opinion"]["tmp_name"])) {
                    /*======================================
                    Capturar Ancho y Alto de la imagen y definir los nuevos valores
                    =======================================*/
                    list($ancho, $alto) = getimagesize($_FILES["foto_opinion"]["tmp_name"]);

                    $nuevoAncho = 128;
                    $nuevoAlto = 128;
                    /*======================================
                    Creamos el Directorio donde Vamos a guardar la foto del usuario
                    =======================================*/
                    $directorio = "views/img/usuarios/";
                    /*======================================
                    De acuerdo al tipo de Imagen aplicamos las funciones por defecto de php
                    =======================================*/
                    if ($_FILES["foto_opinion"]["type"] == "image/jpeg") {
                        
                        $aleatorio = mt_rand(100, 9999);

                        $ruta = $directorio.$aleatorio.".jpg";

                        $origen = imagecreatefromjpeg($_FILES["foto_opinion"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagejpeg($destino, $ruta);

                    }else if ($_FILES["foto_opinion"]["type"] == "image/png") {
                        
                        $aleatorio = mt_rand(100, 9999);

                        $ruta = $directorio.$aleatorio.".png";

                        $origen = imagecreatefrompng($_FILES["foto_opinion"]["tmp_name"]);

                        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

                        imagealphablending($destino, false);

                        imagesavealpha($destino, true);

                        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                        imagepng($destino, $ruta);

                    }else {
                        return "error-formato";
                    }
                    
                } else {
                    $ruta = "views/img/usuarios/default.png";
                }

                $tabla = "opiniones";

                $datos = array(
                    'id_art' => $_POST["id_articulo"],
                    'nombre_opinion' => $_POST["nombre_opinion"],
                    'correo_opinion' => $_POST["email_opinion"],
                    'foto_opinion' => $ruta,
                    'contenido_opinion' => $_POST["contenido_opinion"],
                    'fecha_opinion' => date('Y-m-d'),
                    'id_adm' => 1
                );

                $respuesta = ModeloBlog::mdlEnviarOpinion($tabla, $datos);

                return $respuesta;
            } else {
                return "error";
            }
        }
    }
    /*======================================
    Actualizar vista articulo
    =======================================*/
    static public function ctrActualizarVista($ruta)
    {
        $articulo = ControladorBlog::ctrMostrarConInnerJoin(0, 1, "ruta_articulo", $ruta);

        $valor = $articulo[0]["vistas_articulo"] + 1;

        $tabla = "articulos";

        ModeloBlog::mdlActualizarVista($tabla, $valor, $ruta);

    }
    /*======================================
    Articulos Destacado
    =======================================*/
    static public function ctrArticuloDestacados($item, $valor)
    {
        $tabla = "articulos";

        $respuesta = ModeloBlog::mdlArticulosDesatcados($tabla, $item, $valor);

        return $respuesta;
    }
}
