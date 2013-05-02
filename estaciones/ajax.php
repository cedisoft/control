<?php

include_once '../config.php';

$data = var_post();

switch ($data['band']) {
    case 'lista': {
            $json = array(
                'lista' => estaciones::lista_por_ruta($data['ruta'])
            );
            break;
        }
    case 'add': {
            if ($data['ruta'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el nombre de la ruta que deseas añadir.'
                );
            } elseif (!rutas::esta_ruta_disponible($data['ruta'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El nombre de la ruta <i>"' . $data['ruta'] . '"</i> ya se encuntra registrada.'
                );
            } elseif (rutas::add(array('ruta' => $data['ruta']))) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El nombre de la ruta se ha añadido con éxito.',
                    'lista' => rutas::lista()
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar añadir el nombre de la ruta.'
                );
            }
            break;
        }
    case 'edit': {
            if ($data['ruta'] == '') {
                $json = array(
                    'resp' => 2,
                    'msj' => 'Escribe el nombre de la ruta que deseas añadir.'
                );
            } elseif (!rutas::esta_ruta_disponible_al_editar($data['id'], $data['ruta'])) {
                $json = array(
                    'resp' => 2,
                    'msj' => 'El nombre de la ruta <i>"' . $data['ruta'] . '"</i> ya se encuntra registrado.'
                );
            } elseif (rutas::edit($data)) {
                $json = array(
                    'resp' => 1,
                    'msj' => 'El nombre de la ruta se ha editado con éxito.'
                );
            } else {
                $json = array(
                    'resp' => 0,
                    'msj' => 'Error al intentar editar el nombre de la ruta.'
                );
            }
            break;
        }
}

echo json_encode($json);
?>