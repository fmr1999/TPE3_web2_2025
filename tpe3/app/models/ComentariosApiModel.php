<?php

    require_once './app/models/Model.php';

    class ComentariosApiModel extends Model{

        function obtenerComentarios() {
            $query = $this->db->prepare('SELECT * FROM comentarios');
            $query->execute();
            $comentarios = $query->fetchAll(PDO::FETCH_OBJ);
            return $comentarios;
        }

        function obtenerComentario($id) {
            $query = $this->db->prepare('SELECT * FROM comentarios WHERE id = ?');
            $query->execute([$id]);
            $comentario = $query->fetch(PDO::FETCH_OBJ);
            return $comentario;
        }

        function insertarComentario($fecha,$autor,$mensaje,$valoracion){
            $query = $this->db->prepare("INSERT INTO comentarios(fecha, autor, mensaje, valoracion) VALUES (?,?,?,?)");
            $query->execute([$fecha, $autor, $mensaje , $valoracion]);
            return $this->db->lastInsertId();
        }

        function obtenerComentarioNuevo($nuevoComentarioId){
            $query = $this->db->prepare('SELECT * FROM comentarios WHERE id = ?');
            $query->execute([$nuevoComentarioId]);
            $comentario = $query->fetch(PDO::FETCH_OBJ);
            return $comentario;
        }

        function actualizar($id, $fecha, $autor, $mensaje, $valoracion){
            $query = $this->db->prepare('UPDATE comentarios SET fecha = ?, autor = ?, mensaje = ?, valoracion = ? WHERE id = ?');
            $query->execute([$fecha, $autor, $mensaje, $valoracion, $id]);
        }

        function obtenerComentarioActualizado($id){
            $query = $this->db->prepare('SELECT * FROM comentarios WHERE id = ?');
            $query->execute([$id]);
            $comentario = $query->fetch(PDO::FETCH_OBJ);
            return $comentario;
        }

        function order($sort, $order ){
            $query = $this->db->prepare("SELECT * FROM comentarios ORDER BY $sort $order");
            $query->execute();
            $comentarios = $query->fetchAll(PDO::FETCH_OBJ);
            return $comentarios;
        }

    }
