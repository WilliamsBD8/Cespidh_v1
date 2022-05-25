<?php


namespace App\Controllers;

use App\Models\Formularios;
use App\Models\Documento;
use App\Models\Respuestas;
use App\Models\Etnia;
use App\Models\Genero;
use App\Models\User;
use App\Models\TiposDocumento;
use Config\Services;


class EntidadController extends BaseController
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

        $documentosM = new Documento();
        $documentos = $documentosM
            ->join('users', 'documento.users_id = users.id')
            ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
            ->join('documento_estado', 'documento.id_estado = documento_estado.id_estado')
            ->orderBy('id_documento', 'DESC')
            ->get()->getResult();
        
        $estados = $documentosM
            ->select('id_estado, count(*) as total,
            (select documento_estado.nombre from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS nombre, 
            (select documento_estado.icono from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS icono')
            ->groupBy(['id_estado'])
            ->get()->getResult();

        $tiposDocumentosM = new TiposDocumento();
        $tipos_documento = $tiposDocumentosM->get()->getResult();
        // return var_dump($tipos_documento);


        return view('entidad/entidades' , [
            'formularios'=> $formularios,
            'etnias' => $etnia,
            'generos' => $genero,
            'documents' => $documentos,
            'estados' => $estados,
            'tipo_documento' => $tipos_documento,
        ]);         
    }

    public function search(){
        $nombre = $this->request->getPost('nombre');
        $cedula = $this->request->getPost('cedula');
        $type_document = $this->request->getPost('tipo_documento');
        $date_init = $this->request->getPost('date_init');
        $date_finish = $this->request->getPost('date_finish');

        $post = $this->request->getPost();

        $documentosM = new Documento();
        $documentsM = new Documento();
        $formularioM = new Formularios();
        $genero = new Genero();
        $etnia = new Etnia();

        $parcial = $documentosM
            ->join('users', 'documento.users_id = users.id')
            ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
            ->join('documento_estado', 'documento.id_estado = documento_estado.id_estado')
            ->orderBy('id_documento', 'DESC');

        if(!empty($nombre))
            $parcial = $parcial->like(['users.name' => $nombre]);
        if(!empty($cedula))
            $parcial = $parcial->where(['documento.users_id' => $cedula]);
        if(!empty($type_document))
            $parcial = $parcial->where(['documento.id_tipo' => $type_document]);
        if(!empty($date_init))
            $parcial = $parcial->where(['documento.fecha >=' => date('Y-m-d', strtotime($date_init)).' 00:00:00']);
        if(!empty($date_finish))
            $parcial = $parcial->where(['documento.fecha <=' => date('Y-m-d', strtotime($date_finish)).' 23:59:59']);

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
        
        $estados = $documentsM
            ->select('id_estado, count(*) as total,
            (select documento_estado.nombre from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS nombre, 
            (select documento_estado.icono from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS icono')
            ->groupBy(['id_estado'])
            ->get()->getResult();
        // return var_dump('hola');

        $tiposDocumentosM = new TiposDocumento();
        $tipos_documento = $tiposDocumentosM->get()->getResult();

        $data = $parcial->get()->getResult();
        // return var_dump($post['nombre']);
        return view('entidad/entidades' , [
            'formularios'=> $formularios,
            'etnias' => $etnia,
            'generos' => $genero,
            'documents' => $data,
            'estados' => $estados,
            'tipo_documento' => $tipos_documento,
            'data' => $post
        ]); 
    }
}