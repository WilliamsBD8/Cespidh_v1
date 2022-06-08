<?php


namespace App\Controllers;

use App\Models\Formularios;
use App\Models\Documento;
use App\Models\Respuestas;
use App\Models\Etnia;
use App\Models\Genero;
use App\Models\User;
use App\Models\Work;
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
        $where = '';
        $documentos = $documentosM
            ->select('documento.*, users.*, documento_tipo.*, documento_estado.*, sedes.name as sede')
            ->join('users', 'documento.users_id = users.id')
            ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
            ->join('documento_estado', 'documento.id_estado = documento_estado.id_estado')
            ->join('sedes', 'sedes.id = documento.sedes_id');
        if(session('user')->role_id == 6){
            $documentos = $documentos->where(['documento.sedes_id' => session('user')->sedes_id]);
        }
        $documentos = $documentos->orderBy('id_documento', 'DESC')
            ->get()->getResult();
        $user = [];
        $ids = [];
        $sedes = [];
        $usuarios = [];
        
        foreach ($documentos as $key => $document) {
            $user[$document->name] = null;
            $ids[$document->id] = null;
            $sedes[$document->sede] = null;
            $document->asignacion = $documentosM->Asignar($document->id_documento);
            if(!empty($document->asignacion))
                $usuarios[$document->asignacion->name] = null;
        }
        $usuarios['No asignado'] = null;
        $usuarios['No necesita'] = null;
        $aux = [
            'names' => $user, 'ids' => $ids, 'sedes' => $sedes, 'usuarios' => $usuarios
        ];

        $userM = new User();
        $users = $userM->select('name, cedula, ciudad, direccion, phone, email, genero_id, grupo_etnia_id');
        $users = session('user')->role_id == 6 ? $users->where('users.sedes_id = '.session('user')->sedes_id )->get()->getResult() : $users->get()->getResult();

        $session = session();
        $session->set('filtro_entidad', $aux);
        $session->set('users_aux', $users);

        // return var_dump(session('users_aux'));
        
        $estados = $documentosM
            ->select('id_estado, count(*) as total,
            (select documento_estado.nombre from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS nombre, 
            (select documento_estado.icono from documento_estado where (documento_estado.id_estado = documento.id_estado)) AS icono')
            ->groupBy(['id_estado'])
            ->get()->getResult();

        $tiposDocumentosM = new TiposDocumento();
        $tipos_documento = $tiposDocumentosM->get()->getResult();

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
        $sede = $this->request->getPost('sede');

        $usuario = $this->request->getPost('usuario');

        $post = $this->request->getPost();
        // return var_dump($post);

        $documentosM = new Documento();
        $documentsM = new Documento();
        $formularioM = new Formularios();
        $genero = new Genero();
        $etnia = new Etnia();

        $parcial = $documentosM
            ->select('documento.*, users.*, documento_tipo.*, documento_estado.*, sedes.name as sede')
            ->join('users', 'documento.users_id = users.id')
            ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
            ->join('documento_estado', 'documento.id_estado = documento_estado.id_estado')
            ->join('sedes', 'sedes.id = documento.sedes_id')
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
        if(!empty($sede))
            $parcial = $parcial->where(['sedes.name' => $sede]);
        if(!empty($usuario)){
            if($usuario == 'No necesita'){
                $parcial = $parcial->where(['documento.help' => 'off']);
                $data = $parcial->get()->getResult();
            }else{
                $data = $parcial->get()->getResult();
                foreach ($data as $key => $document) {
                    $document->asignacion = $documentosM->Asignar($document->id_documento);
                }
                foreach ($data as $key_doc => $document) {
                    switch ($usuario) {
                        case 'No asignado':
                            if(!empty($document->asignacion)){
                                unset($data[$key_doc]);
                            }
                            break;
                        default:
                            if($document->asignacion->name != $usuario){
                                unset($data[$key_doc]);;
                            }
                            break;
                    }
                }
            }
            
        }else{
            $data = $parcial->get()->getResult();
            foreach ($data as $key => $document)
                $document->asignacion = $documentosM->Asignar($document->id_documento);
        }
        // var_dump($data);
        // return;
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

        $tiposDocumentosM = new TiposDocumento();
        $tipos_documento = $tiposDocumentosM->get()->getResult();
        // return var_dump(isset($post));
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