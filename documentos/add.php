<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('documentos.insertar');
$rutas = rutas::obtener_filas();

$band = 1;
if (count(var_post()) > 0) {
    if (!is_numeric(var_post('ruta'))) {
        $msj_ruta = text('error', 'Seleccione la ruta.');
        $band = 0;
    }

    if (var_post('titulo') == '') {
        $msj_titulo = text('error', 'Escriba el titulo del documento.');
        $band = 0;
    }

    if (var_post('descripcion') == '') {
        $msj_descripcion = text('error', 'Escriba una descripción breve del documento.');
        $band = 0;
    }

    if ($band) {
        if (documentos::add(var_post())) {
            set_flashdata('info', 'Se ha añadido un nuevo documento con éxito.');
            redirect('documentos');
        } else {
            set_flashdata('error', 'Error al intentar añadir un nuevo documento.');
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Control de documentos</title>

        <?php include_once base_url() . '/tpl/link.php'; ?>
    </head>
    <body>
        <header>
            <?php include_once base_url() . '/tpl/header.php'; ?>
        </header>
        <section class="container-fluid contenedor-principal">
            <div class="titlebar">
                <ul>
                    <li class="title">
                        Añadir usuario
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <?php echo flashdata() ?>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="form-horizontal row-fluid" >
                    <div class="control-group">
                        <label class="control-label">Ruta</label>
                        <div class="controls">
                            <select class="span6" id="ruta" name="ruta">
                                <option></option>
                                <?php
                                for ($i = 0; $i < count($rutas); $i++) {
                                    if ($rutas[$i]['id'] == var_post('ruta')) {
                                        $sltd = 'selected';
                                    } else {
                                        $sltd = '';
                                    }
                                    echo '<option value="' . $rutas[$i]['id'] . '" ' . $sltd . '>' . $rutas[$i]['ruta'] . '</option>';
                                }
                                ?>
                            </select>
                            <?php echo $msj_ruta ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Título</label>
                        <div class="controls">
                            <input class="span6" type="text" id="titulo" name="titulo" value="<?php echo var_post('titulo') ?>" />
                            <?php echo $msj_titulo ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Descripción breve</label>
                        <div class="controls">
                            <textarea class="span6" id="descripcion" name="descripcion"><?php echo var_post('descripcion') ?></textarea>
                            <?php echo $msj_descripcion ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <a href="<?php echo site_url() ?>/usuarios" class="btn">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Aceptar" />
                    </div>
                </form>
            </div>
        </section>
        <?php include_once base_url() . '/tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/usuarios.js"></script>
    </body>
</html>
