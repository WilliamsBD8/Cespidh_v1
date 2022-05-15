<?php


namespace App\Models;


use CodeIgniter\Model;

class Formularios extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'formularios';

    public function DocumentoTipo($id){
        return $this->builder('documento_tipo')->where("id_tipo=$id")->get()->getResult();
    }

    public function Secciones($id){
        return $this->builder('secciones')->where("formulario_id=$id")->orderBy('orden', 'ASC')->get()->getResult();
    }

    public function Preguntas($id){
        return $this->builder('preguntas')->where("secciones_id=$id")->orderBy('orden', 'ASC')->get()->getResult();
    }

    public function PreguntasDetalle($id){
        return $this->builder('pregunta_detalle')->where(["preguntas_id" =>$id, 'pregunta_padre' => NULL])->orderBy('orden', 'ASC')->get()->getResult();
    }

    public function PreguntaDetalleHijo($id){
        return $this->builder('pregunta_detalle')->where(['pregunta_padre' => $id])->orderBy('orden', 'ASC')->get()->getResult();
    }


    public function PreguntasFormulario($id){
        return $this->builder('preguntas')->where("formulario_id=$id")->orderBy('id', 'ASC')->get()->getResult();
    }

}