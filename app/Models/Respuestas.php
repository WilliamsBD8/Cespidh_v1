<?php


namespace App\Models;


use CodeIgniter\Model;

class Respuestas extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'respuestas';

    protected $allowedFields    = ['id', 'preguntas_id', 'pregunta_detalle_id', 'documento_id_documento', 'formulario_id', 'secciones_id', 'respuesta', 'documento'];

    public function Pregunta($id){
      $pregunta = $this->builder('preguntas')->where("id=$id")->orderBy('orden', 'ASC')->get()->getResult();
      return $pregunta[0];
    }

    public function PreguntaDetalle($id){
      $pregunta_detalle = $this->builder('pregunta_detalle')->where("id=$id")->orderBy('orden', 'ASC')->get()->getResult();
      return $pregunta_detalle;
    }

    public function PreguntaDetalles($id){
      $pregunta_detalle = $this->builder('pregunta_detalle')->where("preguntas_id=$id")->orderBy('orden', 'ASC')->get()->getResult();
      return $pregunta_detalle;
    }

    public function PreguntaDetalleHijo($id){
      $pregunta_detalle = $this->builder('pregunta_detalle')->where("pregunta_padre=$id")->orderBy('orden', 'ASC')->get()->getResult();
      return $pregunta_detalle;
    }

    public function Respuestas($id_formulario, $id_preguntas, $id_documento){
      return $this->where(['formulario_id' => $id_formulario, 'preguntas_id' => $id_preguntas, 'documento_id_documento' => $id_documento])->get()->getResult();
    }

    public function RespuestasHijas($id_formulario, $id_preguntas, $id_documento, $hijas){
      return $this->where(['formulario_id' => $id_formulario, 'preguntas_id' => $id_preguntas, 'documento_id_documento' => $id_documento, 'pregunta_detalle_id' => $hijas])->get()->getResult();
    }

    public function Respuesta($id){
      return $this->where(['id' => $id])->get()->GetResult();
    }

}