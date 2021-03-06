<?php
require_once '../config.php';
sesiones::logged_in();
sesiones::has_permission('documentos.acceso');
$doc = documentos::obtener_vista(var_get('var'));

$movimientos = documentos::obtener_vista_movimientos($doc['id']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Control de documentos</title>
        <?php include_once '../tpl/link.php'; ?>
    </head>
    <body>
        <header>
            <?php include_once '../tpl/header.php'; ?>
        </header>
        <section class="container-fluid contenedor-principal">
            <div class="titlebar">
                <ul>
                    <li class="title">
                        Control de documentos
                    </li>
                    <li class="search">
                    </li>
                </ul>
            </div>
            <div class="contenido-principal">
                <div id="flashdata"></div>
                <div class="row-fluid">
                    <div class="row-fluid">
                        <div class="span12">
                            <h4><strong><?php echo documentos::cod_doc($doc['id']) . ' ' . $doc['titulo'] ?></strong></h4>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <p><?php echo $doc['descripcion'] ?></p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <span class="btn btn-mini"><i class="icon-time"></i> <?php echo $doc['horas'] ?> horas (<?php echo $doc['dias'] ?> días)</span>
                            <span class="btn btn-mini"><i class="icon-calendar"></i> Inicio: <?php echo fecha('d M Y - h:i:s a', $doc['fecha_inicio']) ?></span>
                            <span class="btn btn-mini"><i class="icon-calendar"></i> Fin: <?php echo fecha('d M Y - h:i:s a', $doc['fecha_fin']) ?></span>
                            <span class="btn btn-mini"><i class="icon-comment"></i> <?php echo $doc['estaciones_cumplidas'] ?> de <?php echo $doc['total_estaciones'] ?></span>
                            <span class="btn btn-info btn-mini"><i class="icon-resize-full icon-white"></i> <strong>En curso</strong></span>
                        </div>
                    </div>
                </div>
                <div class="tabbable"> <!-- Only required for left/right tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1" data-toggle="tab"><i class="icon-map-marker"></i> Ruta: Nombre de la ruta</a></li>
                        <li><a href="#tab2" data-toggle="tab"><i class="icon-list-alt"></i> Linea de respuestas</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <ul class="media-list">
                                <?php for ($i = 0; $i < count($movimientos); $i++) { ?>
                                    <li class="media ">
                                        <div class="orden pull-left"><i></i><?php echo $movimientos[$i]['orden'] ?></div>
                                        <div class="media-body">
                                            <div class="row-fluid">
                                                <div class="media-heading pull-left"><strong><?php echo $movimientos[$i]['unidad'] ?> - <?php echo $movimientos[$i]['cargo'] ?> - <?php echo $movimientos[$i]['responsable'] ?></strong> / <i><?php echo $movimientos[$i]['descripcion'] ?></i></div>
                                                <div class="pull-right"><?php echo $movimientos[$i]['horas'] ?> horas</div>
                                                <div class="row-fluid">
                                                    <?php if ($movimientos[$i]['testigo'] == 'si') { ?>
                                                        <form id="form_respuesta">
                                                            <div class="row-fluid">
                                                                <div class="span12">
                                                                    <input class="span12" type="hidden" id="movimiento_fkey" name="movimiento_fkey" value="<?php echo $movimientos[$i]['id'] ?>" />
                                                                    <input class="span12" type="text" id="respuesta" name="respuesta" autocomplete="off" />
                                                                </div>
                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span6">
                                                                    <div id="msj_respuesta"></div>
                                                                </div>

                                                                <div class="span6">
                                                                    <div class="pull-right">
                                                                        <input class="btn btn-info btn-small" type="submit" value="Responder" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php } else { ?>

                                                        <?php $resp = documentos::obtener_respuesta_por_movimiento($movimientos[$i]['id']); ?>
                                                        <?php if (is_array($resp)) { ?>
                                                            <div class = "span12">
                                                                <div style = "font-size:18px;" class = "span12">
                                                                    <strong>Respuesta:</strong>
                                                                    <?php echo $resp['respuesta']
                                                                    ?>
                                                                </div>
                                                                <div>
                                                                    <p><i class="icon-calendar"></i> Sept 16th, 2012 at 4:20 pm</p>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <hr>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <p>Howdy, I'm in Section 2.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once '../tpl/script.php'; ?>
        <script src="<?php echo site_url() ?>/js/documentos.js"></script>
    </body>
</html>