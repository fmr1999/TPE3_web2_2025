<?php
require_once './libs/router/router.php';
require_once './app/controllers/ComentariosApiController.php';
require_once 'config.php';

$router = new Router();

 #                 endpoint          verbo             controller             método
$router->addRoute('comentarios',  'GET',  'ComentariosApiController',   'obtenerComentarios');
$router->addRoute('comentarios/:id',  'GET',  'ComentariosApiController',   'obtenerComentario');
$router->addRoute('comentarios',  'POST',  'ComentariosApiController',   'crearComentario');
$router->addRoute('comentarios/:id',  'PUT',  'ComentariosApiController',   'editarComentario');
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
