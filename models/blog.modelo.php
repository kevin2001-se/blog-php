<?php
require_once "conexion.php";

class ModeloBlog
{

    /*======================================
    Mostrar Contenido tabla blog
    =======================================*/
    static public function mdlModeloBlog($tabla)
    {
        $stmt =  Conexion::Conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetch();

        $stmt = null;
    }

    /*======================================
    Modelo Mostrar Tabla Categorias
    =======================================*/

    static public function mdlModelomostrarCategorias($tabla, $item, $valor)
    {
        if ($item != null && $valor != null) {
            
            $stmt =  Conexion::Conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

            $stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt = null;

        } else {
            $stmt =  Conexion::Conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt = null;
        }
    }

    /*======================================
    Modelo Mostrar Articulos y Ctaegorias con Inner Join
    =======================================*/

    static public function mdlMostrarConInnerJoin($tabla1, $tabla2, $desde, $cantidad, $item, $valor)
    {
        if ($item == null && $valor == null) {
            $stmt = Conexion::Conectar()->prepare("SELECT $tabla1.*, $tabla2.*, 
                    DATE_FORMAT(fecha_articulo, '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat 
                    ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt = null;
        } else {
            $stmt = Conexion::Conectar()->prepare("SELECT $tabla1.*, $tabla2.*, 
                    DATE_FORMAT(fecha_articulo, '%d.%m.%Y') AS fecha_articulo FROM $tabla1 INNER JOIN $tabla2 ON $tabla1.id_categoria = $tabla2.id_cat
                    WHERE $item = :$item 
                    ORDER BY $tabla2.id_articulo DESC LIMIT $desde, $cantidad");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();

            $stmt = null;
        }
    }

    /*======================================
    Modelo Mostrar Total Articulo
    =======================================*/
    static public function mdlMostrarTotalArticulo($tabla, $item, $valor)
    {
        if ($item == null && $valor == null) {
            $stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla");

            $stmt->execute();

            return $stmt->fetchAll();
        } else {
            $stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id_articulo DESC");

            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        }
        $stmt = null;
    }

    /*======================================
    Modelo Mostrar Opiniones
    =======================================*/
    static public function mdlMostrarOpiniones($tabla1, $tabla2, $item, $valor)
    {
        $stmt = Conexion::Conectar()->prepare("SELECT $tabla1.*, $tabla2.* FROM $tabla1 INNER JOIN $tabla2
                                            ON $tabla1.id_adm = $tabla2.id_admin WHERE $item =:$item");

        $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;
    }
    /*======================================
    Enviar Opinión
    =======================================*/
    static public function mdlEnviarOpinion($tabla, $datos)
    {
        $stmt = Conexion::Conectar()->prepare("INSERT INTO $tabla(id_art, nombre_opinion, correo_opinion,
                foto_opinion, contenido_opinion, fecha_opinion, id_adm) VALUES(:id_art, :nombre_opinion, :correo_opinion,
                :foto_opinion, :contenido_opinion, :fecha_opinion, :id_adm)");

        $stmt->bindParam(":id_art", $datos["id_art"], PDO::PARAM_INT);
        $stmt->bindParam(":nombre_opinion", $datos["nombre_opinion"], PDO::PARAM_STR);
        $stmt->bindParam(":correo_opinion", $datos["correo_opinion"], PDO::PARAM_STR);
        $stmt->bindParam(":foto_opinion", $datos["foto_opinion"], PDO::PARAM_STR);
        $stmt->bindParam(":contenido_opinion", $datos["contenido_opinion"], PDO::PARAM_STR);
        $stmt->bindParam(":fecha_opinion", $datos["fecha_opinion"], PDO::PARAM_STR);
        $stmt->bindParam(":id_adm", $datos["id_adm"], PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::Conectar()->errorInfo());
        }

        $stmt = null;
    }

    /*======================================
    Actualizar Vista Articulo
    =======================================*/
    static public function mdlActualizarVista($tabla, $valor, $ruta)
    {
        $stmt = Conexion::Conectar()->prepare("UPDATE $tabla SET vistas_articulo = :vistas_articulo 
                                                WHERE ruta_articulo = :ruta_articulo");

        $stmt->bindParam(":vistas_articulo", $valor, PDO::PARAM_STR);
        $stmt->bindParam(":ruta_articulo", $ruta, PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";
        } else {
            print_r(Conexion::Conectar()->errorInfo());
        }

        $stmt = null;
    }
    /*======================================
    Modelo Articulo Destacados
    =======================================*/
    static public function mdlArticulosDesatcados($tabla, $item, $valor)
    {
        if ($item != null && $valor != null) {

            $stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER
                                    BY vistas_articulo DESC LIMIT 3");
            $stmt->bindParam(":" . $item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetchAll();
        } else {

            $stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla ORDER BY vistas_articulo DESC LIMIT 3");

            $stmt->execute();

            return $stmt->fetchAll();
        }

        $stmt = null;
    }
}
