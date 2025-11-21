<?php

    require_once './app/models/ComentariosApiModel.php';


    class ComentariosApiController{

        private $modelComentarios;


        function __construct(){
            $this->modelComentarios = new ComentariosApiModel();
        }

        function obtenerComentarios($req, $res){

            $parametros = [];

            if (!isset($req->query->sort) &&  !isset($req->query->order)) {
                    $comentarios = $this->modelComentarios->obtenerComentarios();
                    return $res->json($comentarios, 200);
            }

            if (empty($req->query->sort) || empty($req->query->order)) {
                return $res->json("Debe enviar sort y order", 400);
            }

            $parametros['sort'] = $req->query->sort;
            $parametros['order'] = $req->query->order;

            if ($this->validarParametrosOrdenamiento($parametros)) {
                $resultado = $this->modelComentarios->order($parametros['sort'], $parametros['order']);
                return $res->json($resultado, 200);
            } else {
                return $res->json("Debe proporcionar un criterio de orden válido", 400);
            }  
        }

        function validarParametrosOrdenamiento($parametros){
            
            $camposPermitidos = ['id', 'fecha', 'autor', 'mensaje', 'valoracion'];
            $ordenesPermitidas = ['asc', 'desc'];

            if (!isset($parametros['sort']) || !in_array($parametros['sort'], $camposPermitidos)) {
                return false;
            }

            if (!isset($parametros['order']) || !in_array($parametros['order'], $ordenesPermitidas)) {
                return false;
            }
            return true;
        }



        function obtenerComentario($req, $res){

            $idComentario = $req->params->id;

            $comentario = $this->modelComentarios->obtenerComentario($idComentario);

             if (!$comentario) {
                return $res->json("La tarea con el id=$idComentario no existe", 404);
            }   

            return $res->json($comentario, 200);

        }

        function crearComentario($req, $res){

            if(!isset($req->body->fecha) || empty($req->body->fecha)){
                return $res->json("falta completar el campo fecha", 400);
            }
            if(!isset($req->body->autor) || empty($req->body->autor)){
                return $res->json("falta completar el campo autor", 400);
            }
            if(!isset($req->body->mensaje) || empty($req->body->mensaje)){
                return $res->json("falta completar el campo mensaje", 400);
            }
            if(!isset($req->body->valoracion) || empty($req->body->valoracion)){
                return $res->json("falta completar el campo valoracion", 400);
            }

            $fecha = $req->body->fecha;
            $autor = $req->body->autor;
            $mensaje = $req->body->mensaje;
            $valoracion = $req->body->valoracion;

            $nuevoComentarioId = $this->modelComentarios->insertarComentario( $fecha,$autor,$mensaje,$valoracion);

            if ($nuevoComentarioId == false) {
                return $res->json('Error del servidor', 500);
            }

            $nuevoComentario = $this->modelComentarios->obtenerComentarioNuevo($nuevoComentarioId);
            return $res->json($nuevoComentario, 201); 
        }


        function editarComentario($req, $res){

            $id = $req->params->id;

            $comentario = $this->modelComentarios->obtenerComentario($id);
            
            if(!$comentario){
                return $res->json('No existe el comentario', 404);
            }

            if(!isset($req->body->fecha) || empty($req->body->fecha)){
                return $res->json("falta completar el campo fecha", 400);
            }
            if(!isset($req->body->autor) || empty($req->body->autor)){
                return $res->json("falta completar el campo autor", 400);
            }
            if(!isset($req->body->mensaje) || empty($req->body->mensaje)){
                return $res->json("falta completar el campo mensaje", 400);
            }
            if(!isset($req->body->valoracion) || empty($req->body->valoracion)){
                return $res->json("falta completar el campo valoracion", 400);
            }

            $fecha = $req->body->fecha;
            $autor = $req->body->autor;
            $mensaje = $req->body->mensaje;
            $valoracion = $req->body->valoracion;

            $this->modelComentarios->actualizar($id, $fecha, $autor, $mensaje, $valoracion);

            $actualizarComentario = $this->modelComentarios->obtenerComentarioActualizado($id);
            return $res->json($actualizarComentario, 201);

        }

    }