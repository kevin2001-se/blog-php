<?php
/*======================================
Remplazar
=======================================*/
$remplazar = array(1,2,3,4,5,6,7,8,9,0,'á','é','í','ó','ú','ñ',' ');
$remplazado =array('_','_','_','_','_','_','_','_','_','a','e','i','o','u','_','_');
/*======================================
Seleccionar Los articulos de la Categoria Especifica
=======================================*/
if (isset($rutas[0])) {
    $articulos = ControladorBlog::ctrMostrarConInnerJoin(0, 5, "ruta_categoria", $rutas[0]);
    $totalArticulos = ControladorBlog::ctrMostrarTotalArticulos("id_cat", $articulos[0]["id_cat"]);

    $totalPaginas = ceil(count($totalArticulos) / 5);

    $articulosDestacados = ControladorBlog::ctrArticuloDestacados("id_cat", $articulos[0]["id_cat"]);

    $anuncios = ControladorBlog::ctrAnuncios("categorias");
}

/*======================================
Revisar si viene paginacion de categorias
=======================================*/

if (isset($rutas[1])) {

    if (is_numeric($rutas[1])) {
        if ($rutas[1] > $totalPaginas) {
            echo '<script>window.location = "' . $blog["dominio"] . 'error"</script>';
            return;
        }

        $paginaActual = $rutas[1];
        $desde = ($rutas[1] - 1) * 5;
        $cantidad = 5;
        $articulos = ControladorBlog::ctrMostrarConInnerJoin($desde, $cantidad, "ruta_categoria", $rutas[0]);
    } else {
        echo '<script>window.location = "' . $blog["dominio"] . 'error"</script>';
        return;
    }
} else {
    $paginaActual = 1;
}

?>
<!--=====================================
CONTENIDO CATEGORIA
======================================-->

<div class="container-fluid bg-white contenidoInicio py-2 py-md-4">

    <div class="container">

        <!-- BREADCRUMB -->

        <ul class="breadcrumb bg-white p-0 mb-2 mb-md-4">

            <li class="breadcrumb-item inicio"><a href="<?php echo $blog["dominio"]; ?>">Inicio</a></li>

            <li class="breadcrumb-item active"><?php echo $articulos[0]["descripcion_categoria"] ?></li>

        </ul>

        <div class="row">

            <!-- COLUMNA IZQUIERDA -->

            <div class="col-12 col-md-8 col-lg-9 p-0 pr-lg-5">

                <?php
                /*======================================
                Articulos
                =======================================*/
                foreach ($articulos as $key => $value) { ?>

                    <div class="row">

                        <div class="col-12 col-lg-5">

                            <a href="<?php echo $blog["dominio"].$value["ruta_categoria"]."/".$value["ruta_articulo"] ?>">
                                <h5 class="d-block d-lg-none py-3"><?php echo $value["titulo_articulo"] ?></h5>
                            </a>

                            <a href="<?php echo $blog["dominio"].$value["ruta_categoria"]."/".$value["ruta_articulo"] ?>"><img src="<?php echo $blog["dominio"]; ?><?php echo $value["portada_articulo"] ?>" alt="<?php echo $value["titulo_articulo"] ?>" class="img-fluid" width="100%"></a>

                        </div>

                        <div class="col-12 col-lg-7 introArticulo">

                            <a href="<?php echo $blog["dominio"].$value["ruta_categoria"]."/".$value["ruta_articulo"] ?>">
                                <h4 class="d-none d-lg-block"><?php echo $value["titulo_articulo"] ?></h4>
                            </a>

                            <p class="my-2 my-lg-5"><?php echo $value["descripcion_articulo"] ?></p>

                            <a href="<?php echo $blog["dominio"].$value["ruta_categoria"]."/".$value["ruta_articulo"] ?>" class=" float-right">Leer Más</a>

                            <div class="fecha"><?php echo $value["fecha_articulo"] ?></div>
                        </div>


                    </div>

                    <hr class="mb-4 mb-lg-5" style="border: 1px solid #79FF39">

                <?php
                }
                ?>

                <div class="container d-none d-md-block">

                    <ul class="pagination justify-content-center" totalPaginas="<?php echo $totalPaginas; ?>" paginaActual="<?php echo $paginaActual; ?>" rutapagina="<?php echo $articulos[0]["ruta_categoria"]; ?>">
                    </ul>

                </div>

            </div>

            <!-- COLUMNA DERECHA -->

            <div class="d-none d-md-block pt-md-4 pt-lg-0 col-md-4 col-lg-3">

                <!-- ETIQUETAS -->

                <div>

                    <h4>Etiquetas</h4>

                    <?php
                    $tags = json_decode($articulos[0]["p_claves_categorias"]);

                    foreach ($tags as $key => $value) { ?>
                        <a href="<?php echo $blog["dominio"].str_replace($remplazar, $remplazado,$value); ?>" class="btn btn-secondary btn-sm m-1"><?php echo $value; ?></a>
                    <?php }
                    ?>

                </div>

                <!-- Artículos Destacados -->

                <div class="my-4">

                    <h4>Artículos Destacados</h4>

                    <?php foreach ($articulosDestacados as $key => $value) : 
                    
                    $categoriaA = ControladorBlog::ctrMostrarCategorias("id_categoria" , $value["id_cat"]);
                        
                    ?>
                        <div class="d-flex my-3">

                            <div class="w-100 w-xl-50 pr-3 pt-2">

                                <a href="<?php echo $blog["dominio"].$categoriaA[0]["ruta_categoria"]."/".$value["ruta_articulo"]; ?>">

                                    <img src="<?php echo $blog["dominio"].$value["portada_articulo"]; ?>" alt="<?php echo $value["titulo_articulo"]; ?>" class="img-fluid">

                                </a>

                            </div>

                            <div>

                                <a href="<?php echo $blog["dominio"].$categoriaA[0]["ruta_categoria"]."/".$value["ruta_articulo"]; ?>" class="text-secondary">

                                    <p class="small"><?php echo substr($value["descripcion_articulo"],0,-150)."..."; ?></p>

                                </a>

                            </div>

                        </div>
                    <?php endforeach ?>


                </div>

                <!-- PUBLICIDAD -->

                <?php foreach($anuncios as $key => $value): ?>
                    <?php echo $value["codigo_anuncio"]; ?>
                <?php endforeach ?>

            </div>

        </div>

    </div>

</div>