<?php

//TODO: Hay que adaptar los include
include "../../../wp-load.php";
include "../../../wp-content/themes/zurbox-lite/header.php";
require "../../../security-functions.php";
require "../../../tools/enlace.php";
if (!assert_is_shop_admin()){
    header('Location: ../../../index.php');
} else {
?>

<div class="row">
    <div id="primary" class="content-area small-12 large-8 large-centered columns">
        <main id="main" class="site-main" role="main">

            <article id="post-91" class="post-91 page type-page status-publish hentry wp-sticky">
 
                <header class="entry-header">
                    <h1 class="entry-title">Crear Caja</h1>  <!-- AQUI VA EL TITULO -->                        
                </header><!-- .entry-header -->
    
                <div class="entry-content">
                    <!-- INICIO DEL CONTENIDO -->
                    <?php
                        $enlace = start_database();
                        $lista_productos = $enlace->query('SELECT * FROM producto p');

                        if (is_numeric($_REQUEST['id'])){
                            $query_box = "SELECT * FROM caja WHERE id=" . $_REQUEST['id'] . ";";
                            $resultados = $enlace->query($query_box);
                            $box= $resultados->fetch_assoc();
                            
                            $query_productos_fijos = "SELECT producto FROM producto_seleccionado WHERE fijo=1 and caja=" . $_REQUEST['id'] . ";";
                            $resultados_productos_fijos = $enlace->query($query_productos_fijos);
                            $productos_fijos = $resultados_productos_fijos->fetch_all();
                            
                            $query_productos_aleatorios = "SELECT producto FROM producto_seleccionado WHERE fijo=0 and caja=" . $_REQUEST['id'] . ";";
                            $resultados_productos_aleatorios = $enlace->query($query_productos_aleatorios);
                            $productos_aleatorios = $resultados_productos_aleatorios->fetch_all();
                        } 

                    ?>
                        
                        <div id="form_product">
                            <form action="../../../tools/save-box.php" method="POST">
                                <input type="hidden" name="id"  <?php echo "value=\"" . $box['id'] . "\""?>/>
                                
                                Temática:<br>
                                <input type="text" name="tematica" required <?php echo "value=\"" . $box['tematica'] . "\""?>>
                                <br>
                                Precio:<br>
                                <input type="number" step="0.01" name="precio" required <?php echo "value=\"" . $box['precio'] . "\""?>><br>

                                Cantidad de productos:<br>
                                <input type="number" step="1" name="cantidad_productos" required <?php echo "value=\"" . $box['cantidad_productos'] . "\""?>><br>
                                
                                Selecciona los productos fijos:</br>
                                <select multiple name="productos_fijos[]">
                                    <?php
                                    foreach ($lista_productos as $producto) {
                                        $option = "<option value=". $producto["id"] .">" . $producto["nombre"] ."</option>";
                                        foreach ($productos_fijos as $producto_fijo) {           
                                            if ($producto["id"] == $producto_fijo[0]) {
                                                $option = "<option value=". $producto["id"] ." selected>" . $producto["nombre"] ." </option>";
                                            break;
                                            }
                                        }
                                        echo $option;
                                    }
                                    ?>
                                </select></br>

                                Selecciona los productos que serán aleatorios: </br>
                                <select multiple name="productos_aleatorios[]" required>
                                    <?php
                                    foreach ($lista_productos as $producto) {
                                        $option = "<option value=". $producto["id"] .">" . $producto["nombre"] ."</option>";
                                        foreach ($productos_aleatorios as $producto_fijo) {           
                                            if ($producto["id"] == $producto_fijo[0]) {
                                                $option = "<option value=". $producto["id"] ." selected>" . $producto["nombre"] ." </option>";
                                            break;
                                            }
                                        }
                                        echo $option;
                                    }
                                    ?>
                                </select>

                                <input type="submit" value="Enviar"/>
                            </form>
                        </div>
           
                    <?php
                        mysqli_close($enlace);
                    ?>
                    <!-- FIN DEL CONTENIDO -->
                    </br>
                </div><!-- .entry-content -->
    
 
            </article><!-- #post-## -->
        </main><!-- #main -->
    </div><!-- #primary -->
</div><!-- .row -->


</div><!-- #content -->
 



<?php 
// TODO: ADAPTAR LOS INCLUDES
include "../../../wp-content/themes/zurbox-lite/footer.php";
                                }?>