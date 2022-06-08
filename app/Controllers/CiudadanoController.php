<?php


namespace App\Controllers;

use App\Models\Formularios;
use App\Models\Documento;
use App\Models\Respuestas;
use App\Models\Etnia;
use App\Models\Genero;
use App\Models\User;
use App\Models\Work;
use Config\Services;


class CiudadanoController extends BaseController
{
    public function index(){
        $formularioM = new Formularios();
        $genero = new Genero();
        $etnia = new Etnia();
        $formularios = $formularioM
            ->join('documento_tipo', 'documento_tipo.id_tipo = formularios.documento_tipo_id_tipo')
            ->orderBy('orden', 'ASC')
            ->get()->getResult();
        foreach($formularios as $key => $formulario){
            $formulario->secciones = $formularioM->Secciones($formulario->id);
            if(!empty($formulario->secciones)){
                foreach ($formulario->secciones as $key_2 => $seccion) {
                    $seccion->preguntas = $formularioM->Preguntas($seccion->id);
                    foreach($seccion->preguntas as $preguntadetalle){
                        $preguntadetalle->detalle = $formularioM->PreguntasDetalle($preguntadetalle->id);
                        foreach ($preguntadetalle->detalle as $detalleHijo) {
                            $detalleHijo->detalle = $formularioM->PreguntaDetalleHijo($detalleHijo->id);
                        }
                    }
                }
            }else unset($formularios[$key]);
        }
        $etnia = $etnia->orderBy('orden', 'ASC')->get()->getResult();
        $genero = $genero->orderBy('orden', 'ASC')->get()->getResult();
        // var_dump($formularios);
        // return null;
        $documentosM = new Documento();
        $documentos = $documentosM
        ->select('documento.*, users.*, documento_tipo.*, documento_estado.*, sedes.name as sede')
        ->join('users', 'documento.users_id = users.id')
        ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
        ->join('documento_estado', 'documento.id_estado = documento_estado.id_estado')
        ->join('sedes', 'sedes.id = documento.sedes_id')
        ->orderBy('id_documento', 'DESC')
        ->get()->getResult();
        // return var_dump($documentos);
        // $documentos = documents();
        return view('ciudadano/ciudadanos' , [
            'formularios'=>$formularios,
            'etnias' => $etnia,
            'generos' => $genero,
            'documents' => $documentos
        ]);         
    }
}