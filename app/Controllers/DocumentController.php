<?php


namespace App\Controllers;

use App\Models\Formularios;
use App\Models\Documento;
use App\Models\Respuestas;
use App\Models\Etnia;
use App\Models\Genero;
use App\Models\User;
use App\Models\Work;
use App\Models\Terminos;
use Config\Services;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;


class DocumentController extends BaseController
{
    public function create(){
        $requets = $this->request->getPost();
        $id = $this->request->getPost('cedula');
        $tipo_documento = $this->request->getPost('tipo_documento');
        $userModel = new User();
        $user = $userModel->where(['cedula' => $id])->get()->getFirstRow();
        $id_user = $user->id;
        
        $documentoModel = new Documento();
        $id_formulario = $this->request->getPost('id_formulario');
        $info_document = [
            'id_tipo' => $tipo_documento,
            'id_estado' => 1,
            'users_id' => $id_user,
            'help' => !empty($this->request->getPost('help_'.$id_formulario)) ? $this->request->getPost('help_'.$id_formulario) : 'off',
            'terminos' => !empty($this->request->getPost('terminos_'.$id_formulario)) ? $this->request->getPost('terminos_'.$id_formulario) : 'off',
            'firma' => !empty($this->request->getPost('firma_'.$id_formulario)) ? $this->request->getPost('firma_'.$id_formulario) : 'off',
            'sedes_id' => $user->sedes_id
        ];
        $workM = new Work();
        $documentoModel->insert($info_document);
        $id_documento = $documentoModel->getInsertID();
        // $id_documento = 1;
        $formularioM = new Formularios();
        $formularioB = $formularioM->where(['id' => $id_formulario])->get()->getResult();
        $respuestaM = new Respuestas();
        foreach($formularioB as $formulario){
            $formulario->secciones = $formularioM->Secciones($formulario->id);
            foreach ($formulario->secciones as $key => $seccion) {
                $seccion->preguntas = $formularioM->Preguntas($seccion->id);
                foreach ($seccion->preguntas as $key_preguntas => $pregunta) {
                    switch ($pregunta->tipo_pregunta_id) {
                        case 1:
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($value)){
                                $data = [
                                    'preguntas_id' => $pregunta->id,
                                    'documento_id_documento' => $id_documento,
                                    'formulario_id' => $formulario->id,
                                    'secciones_id' => $seccion->id,
                                    'respuesta' => $value,
                                ];
                                $respuestaM->insert($data);
                            }
                            break;
                        case 2:
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($value)){
                                $data = [
                                    'preguntas_id' => $pregunta->id,
                                    'documento_id_documento' => $id_documento,
                                    'formulario_id' => $formulario->id,
                                    'secciones_id' => $seccion->id,
                                    'pregunta_detalle_id' => $value
                                ];
                                $respuestaM->insert($data);
                            }
                            break;
                        case 3:
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($value)){
                                $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                                foreach ($pregunta->detalles as $key => $detalle_pregunta) {
                                    if($value == $detalle_pregunta->id){
                                        $detalle_pregunta->preguntaHijos = $formularioM->PreguntaDetalleHijo($value);
                                        $data = [
                                            'preguntas_id' => $pregunta->id,
                                            'documento_id_documento' => $id_documento,
                                            'formulario_id' => $formulario->id,
                                            'secciones_id' => $seccion->id,
                                            'pregunta_detalle_id' => $value
                                        ];
                                        $respuestaM->insert($data);
                                        foreach ($detalle_pregunta->preguntaHijos as $key => $pregunta_detalle) {
                                            var_dump($pregunta_detalle->tipo_pregunta_id);
                                            switch ($pregunta_detalle->tipo_pregunta_id) {
                                                case '1':
                                                    $value_2 = $this->request->getPost($pregunta_detalle->campo_formulario);
                                                    if(!empty($value_2)){
                                                        $data = [
                                                            'preguntas_id' => $pregunta->id,
                                                            'documento_id_documento' => $id_documento,
                                                            'formulario_id' => $formulario->id,
                                                            'secciones_id' => $seccion->id,
                                                            'respuesta' => $value_2,
                                                            'pregunta_detalle_id' => $pregunta_detalle->id
                                                        ];
                                                        $respuestaM->insert($data);
                                                        // var_dump($pregunta_detalle);
                                                    }
                                                    break;
                                                case '3':
                                                    $value_2 = $this->request->getPost($detalle_pregunta->campo_formulario);
                                                    if($value_2 == $pregunta_detalle->id){
                                                        $data = [
                                                            'preguntas_id' => $pregunta->id,
                                                            'documento_id_documento' => $id_documento,
                                                            'formulario_id' => $formulario->id,
                                                            'secciones_id' => $seccion->id,
                                                            'pregunta_detalle_id' =>  $pregunta_detalle->id
                                                        ];
                                                        $respuestaM->insert($data);
                                                        // var_dump($data);
                                                    }
                                                    break;
                                                case '4':
                                                    $value_2 = $this->request->getPost($detalle_pregunta->campo_formulario);
                                                    if(!empty($value_2)){
                                                        foreach ($value_2 as $key => $check_box) {
                                                            if($check_box == $pregunta_detalle->id){
                                                                $data = [
                                                                    'preguntas_id' => $pregunta->id,
                                                                    'documento_id_documento' => $id_documento,
                                                                    'formulario_id' => $formulario->id,
                                                                    'secciones_id' => $seccion->id,
                                                                    'pregunta_detalle_id' => $check_box
                                                                ];
                                                                $respuestaM->insert($data);
                                                            }
                                                        }
                                                    }
                                                    break;
                                            }
                                        }
                                    }
                                }
                            }
                            break;

                        case 4:
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($value)){
                                $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                                foreach ($pregunta->detalles as $key => $detalles) {
                                    foreach ($value as $key => $valores) {
                                        if($detalles->id == $valores){
                                            $detalles->hijos = $formularioM->PreguntaDetalleHijo($valores);
                                            $data = [
                                                'preguntas_id' => $pregunta->id,
                                                'documento_id_documento' => $id_documento,
                                                'formulario_id' => $formulario->id,
                                                'secciones_id' => $seccion->id,
                                                'pregunta_detalle_id' => $valores
                                            ];
                                            $respuestaM->insert($data);
                                            foreach ($detalles->hijos as $key => $hijos) {
                                                switch ($hijos->tipo_pregunta_id) {
                                                    case 1:
                                                        $value_2 = $this->request->getPost($hijos->campo_formulario);
                                                        if(!empty($value_2)){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_documento,
                                                                'formulario_id' => $formulario->id,
                                                                'secciones_id' => $seccion->id,
                                                                'respuesta' => $value_2,
                                                                'pregunta_detalle_id' => $hijos->id
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 3:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if($value_2 == $hijos->id){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_documento,
                                                                'formulario_id' => $formulario->id,
                                                                'secciones_id' => $seccion->id,
                                                                'pregunta_detalle_id' => $value_2
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 4:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if(!empty($value_2)){
                                                            foreach ($value_2 as $key => $check_box) {
                                                                if($check_box == $hijos->id){
                                                                    $data = [
                                                                        'preguntas_id' => $pregunta->id,
                                                                        'documento_id_documento' => $id_documento,
                                                                        'formulario_id' => $formulario->id,
                                                                        'secciones_id' => $seccion->id,
                                                                        'pregunta_detalle_id' => $check_box
                                                                    ];
                                                                    $respuestaM->insert($data);
                                                                }
                                                            }
                                                        }
                                                        break;

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            break;
                        case 5:
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($value)){
                                $value = json_decode($value);
                                foreach ($value as $key => $items) {
                                    foreach ($items as $key => $item) {
                                        $data = [
                                            'preguntas_id' => $pregunta->id,
                                            'documento_id_documento' => $id_documento,
                                            'formulario_id' => $formulario->id,
                                            'secciones_id' => $seccion->id,
                                            'respuesta' => $item->value
                                        ];
                                        $respuestaM->insert($data);
                                    }
                                }
                            }
                            break;
                        case 6:
                            $files = $this->request->getFiles($pregunta->campo_formulario);
                            $names = $this->request->getPost($pregunta->campo_formulario.'_names');
                            if(!empty($files[$pregunta->campo_formulario])){
                                foreach ($files[$pregunta->campo_formulario] as $llave => $archivo) {
                                    $archivo->new_name = $names[$llave];
                                    $archivo->move('img/files', $archivo->getName());
                                    $data = [
                                        'preguntas_id' => $pregunta->id,
                                        'documento_id_documento' => $id_documento,
                                        'formulario_id' => $formulario->id,
                                        'secciones_id' => $seccion->id,
                                        'respuesta' => $archivo->new_name,
                                        'documento' => $archivo->getName()
                                    ];
                                    $respuestaM->insert($data);
                                }
                            }
                            break;

                        default:
                            break;
                    }
                }
            }
        }

        
        $name_word = $this->view_document($id_documento, 4);
        $workM->insert([
            'observation' => 'Creaci??n del documento',
            'documento_id_documento' => $id_documento,
            'users_id' => $id_user,
            'document' => $name_word,
            'work_type_id' => 1]);

        return redirect()->to($this->request->getPost('url'));
    }

    public function view_document($id, $type){
        // return var_dump($type);
        $documentosM = new Documento();
        $formularioM = new Formularios();
        $respuestasM = new Respuestas();
        $userM = new User();
        $documento = $documentosM
        ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
        ->where(['id_documento' => $id])->get()->getResult();
        if(!empty($documento[0]) && ($type == 1 || $type == 2 || $type == 3 || $type == 4)){
            if(!empty($documento[0]->plantilla)){
                $plantilla = $documento[0]->plantilla;
                $plantilla = str_replace('{{created_document}}', date_fecha($documento[0]->fecha), $plantilla);
                $formulario = $formularioM->where(['documento_tipo_id_tipo' => $documento[0]->id_tipo])->get()->getResult();
                $preguntas = $formularioM->PreguntasFormulario($formulario[0]->id);
                foreach ($preguntas as $key => $pregunta) {
                    $pregunta->respuesta = $respuestasM->Respuestas($formulario[0]->id, $pregunta->id, $documento[0]->id_documento);
                    switch ($pregunta->tipo_pregunta_id) {
                        case 1: // Preguntas abiertas
                            foreach ($pregunta->respuesta as $key => $respuesta) {
                                $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuesta}}", $respuesta->respuesta, $plantilla);
                                $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $respuesta->titulo, $plantilla);
                            }
                            break;
                        case 2: // Preguntas Select
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $pregunta->pregunta, $plantilla);
                            $pregunta_detalle = $respuestasM->PreguntaDetalle($pregunta->respuesta[0]->pregunta_detalle_id);
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuesta}}", $pregunta_detalle[0]->description, $plantilla);
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.complemento}}", $pregunta_detalle[0]->complemento, $plantilla);
                            break;
                        case 3: // Preguntas Radio
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $pregunta->pregunta, $plantilla);
                            $pregunta_detalle = $respuestasM->PreguntaDetalle($pregunta->respuesta[0]->pregunta_detalle_id);
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuesta}}", $pregunta_detalle[0]->description, $plantilla);
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.complemento}}", $pregunta_detalle[0]->complemento, $plantilla);
                            break;
                        case 4: // Preguntas Checkbox
                            $pregunta->preguntas_detalle = $respuestasM->PreguntaDetalles($pregunta->id);
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $pregunta->titulo, $plantilla);
                            foreach ($pregunta->respuesta as $key => $respuesta) {
                                // var_dump($respuesta);
                                foreach ($pregunta->preguntas_detalle as $key => $pregunta_detalle) {
                                    if($respuesta->pregunta_detalle_id == $pregunta_detalle->id){
                                        if(!empty($respuesta->respuesta)){
                                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}},", $respuesta->respuesta.',', $plantilla);
                                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}}", $respuesta->respuesta, $plantilla);
                                        }else{
                                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}},", $pregunta_detalle->description.',', $plantilla);
                                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}}", $pregunta_detalle->description, $plantilla);
                                        }
                                        $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario.".complemento}}", $pregunta_detalle->complemento, $plantilla);
                                    }
                                }
                            }
                            foreach ($pregunta->preguntas_detalle as $key => $pregunta_detalle) {
                                if(preg_match("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}}", $plantilla)){
                                    $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}},", '&nbsp;', $plantilla);
                                    $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario."}}", '&nbsp;', $plantilla);
                                    $plantilla = str_replace("{{{$pregunta->campo_formulario}.".$pregunta_detalle->campo_formulario.".complemento}}", '&nbsp;', $plantilla);
                                }
                            }
                            break;
                        case 5:
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $pregunta->titulo, $plantilla);
                            $ordinal = "/\{\{{$pregunta->campo_formulario}.respuestas.ordinal\*[[:digit:]]/";
                            $normal = "/\{\{{$pregunta->campo_formulario}.respuestas\}\}/";
                            $normal_lista = "/<li>\{\{{$pregunta->campo_formulario}.respuestas\}\}<\/li>/";
                            $aux_text = '';
                            $inicio;
                            preg_match_all($ordinal, $plantilla, $matches, PREG_PATTERN_ORDER);
                            if(!empty($matches[0])){
                                // var_dump($matches[0]);
                                foreach ($matches[0] as $key => $valores) {
                                    $value = explode('*', $valores);
                                    $inicio = $value[1];
                                    $aux_text_ordinal = '';
                                    foreach ($pregunta->respuesta as $key => $respuesta) {
                                        $ordinal = ordinal(($inicio-1));
                                        $aux_text_ordinal .= ucfirst(strtolower($ordinal)).': '.$respuesta->respuesta.'</p><p>';
                                        $inicio++;
                                    }
                                    $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuestas.ordinal*{$value[1]}}}", $aux_text_ordinal, $plantilla);
                                }
                            }
                            if(preg_match_all("{$normal_lista}", $plantilla, $matches, PREG_PATTERN_ORDER)){
                                $aux_text = '';
                                foreach ($pregunta->respuesta as $key => $respuesta) {
                                    $aux_text .= "<li>$respuesta->respuesta</li>";
                                }
                                $plantilla = str_replace("<li>{{{$pregunta->campo_formulario}.respuestas}}</li>", $aux_text, $plantilla);
                            }
                            if(preg_match_all("{$normal}", $plantilla, $matches, PREG_PATTERN_ORDER)){
                                $aux_text = '';
                                foreach ($pregunta->respuesta as $key => $respuesta) {
                                    $aux_text .= "$respuesta->respuesta ";
                                }
                                $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuestas}}", $aux_text, $plantilla);
                            }
                            break;
                        case 6:
                            $plantilla = str_replace("{{{$pregunta->campo_formulario}.titulo}}", $pregunta->titulo, $plantilla);
                            $ordinal = "/\{\{{$pregunta->campo_formulario}.respuestas.ordinal\*[[:digit:]]/";
                            $normal = "/\{\{{$pregunta->campo_formulario}.respuestas\}\}/";
                            $normal_lista = "/<li>\{\{{$pregunta->campo_formulario}.respuestas\}\}<\/li>/";
                            $aux_text = '';
                            $inicio;
                            preg_match_all($ordinal, $plantilla, $matches, PREG_PATTERN_ORDER);
                            if(!empty($matches[0])){
                                // var_dump($matches[0]);
                                foreach ($matches[0] as $key => $valores) {
                                    $value = explode('*', $valores);
                                    $inicio = $value[1];
                                    $aux_text_ordinal = '';
                                    foreach ($pregunta->respuesta as $key => $respuesta) {
                                        $ordinal = ordinal(($inicio-1));
                                        $aux_text_ordinal .= ucfirst(strtolower($ordinal)).': '.$respuesta->respuesta.'</p><p>';
                                        $inicio++;
                                    }
                                    $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuestas.ordinal*{$value[1]}}}", $aux_text_ordinal, $plantilla);
                                }
                            }
                            if(preg_match_all("{$normal_lista}", $plantilla, $matches, PREG_PATTERN_ORDER)){
                                $aux_text = '';
                                foreach ($pregunta->respuesta as $key => $respuesta) {
                                    $aux_text .= "<li>$respuesta->respuesta</li>";
                                }
                                $plantilla = str_replace("<li>{{{$pregunta->campo_formulario}.respuestas}}</li>", $aux_text, $plantilla);
                            }
                            if(preg_match_all("{$normal}", $plantilla, $matches, PREG_PATTERN_ORDER)){
                                $aux_text_2 = '';
                                foreach ($pregunta->respuesta as $key => $respuesta) {
                                    // var_dump($respuesta->respuesta);
                                    $aux_text_2 .= "$respuesta->respuesta ";

                                }
                                $plantilla = str_replace("{{{$pregunta->campo_formulario}.respuestas}}", $aux_text_2, $plantilla);
                            }
                            break;
                        
                        default:
                            # code...
                            break;
                    }
                }
                $user = $userM->where(['id' => $documento[0]->users_id])->get()->getresult();
                $plantilla = str_replace("{{user.direccion}}", $user[0]->direccion, $plantilla);
                $plantilla = str_replace("{{user.ciudad}}", $user[0]->ciudad, $plantilla);
                $plantilla = str_replace("{{user.email}}", $user[0]->email, $plantilla);
                $plantilla = str_replace("{{user.telefono}}", $user[0]->phone, $plantilla);
                $plantilla = str_replace("{{user.nombre}}", $user[0]->name, $plantilla);
                $plantilla = str_replace("{{user.cedula}}", $user[0]->id, $plantilla);

                $pattern = "/<[^\/>]*>(?:s|&nbsp;)*<\/[^>]*>/";  

                $plantilla = preg_replace($pattern, '', $plantilla);
                if($type != 4){
                    $mpdf = new \Mpdf\Mpdf([]);
                    $mpdf->WriteHTML($plantilla, \Mpdf\HTMLParserMode::HTML_BODY);
                    if($type == 3){
                        $name =$documento[0]->abreviacion.'-'.$documento[0]->id_documento.'_'.date('y_m_d_H_i').'.pdf';
                        $mpdf->Output($name, 'F');
                        $currentLocation = $name;
                        $newLocation = 'docs/pdf/'.$name;
                        $moved = rename($currentLocation, $newLocation);
                        if($moved) return $name;
                    }else{
                        $this->response->setHeader('Content-Type', 'application/pdf');
                        $mpdf->Output($documento[0]->abreviacion.'-'.$documento[0]->id_documento.'.pdf', $type == 1 ? 'I' : 'D');
                    }
                }else{
                    $phpWord = new PhpWord();
                    $section = $phpWord->addSection();
                    Html::addHtml($section, $plantilla);
                    $name = $documento[0]->abreviacion.'-'.$documento[0]->id_documento.'_'.date('y_m_d_H_i').'.docx';
                    $phpWord->save('docs/word/'.$name, 'Word2007');
                    return $name;
                }
                // return ;
            }else{
                if($type == 3 || $type == 4) return null;
                return view('errors/html/plantilla');
            }
        }else{
            return view('errors/html/error_404');
        }
    }


    /// Edit Document

    public function view_edit($id){
        $documentosM = new Documento();
        $formularioM = new Formularios();
        $respuestasM = new Respuestas();
        $genero = new Genero();
        $etnia = new Etnia();
        $userM = new User();
        // return;
        $documento = $documentosM
        ->join('documento_tipo', 'documento.id_tipo = documento_tipo.id_tipo')
        ->where(['id_documento' => $id])->get()->getResult();
        if(!empty($documento[0])){
            $formulario = $formularioM->where(['documento_tipo_id_tipo' => $documento[0]->id_tipo])->get()->getResult();
            $formulario = $formulario[0];
            $formulario->secciones = $formularioM->Secciones($formulario->id);
            foreach ($formulario->secciones as $key_2 => $seccion) {
                $seccion->preguntas = $formularioM->Preguntas($seccion->id);
                foreach($seccion->preguntas as $pregunta){
                    $pregunta->detalle = $formularioM->PreguntasDetalle($pregunta->id);
                    if(empty($pregunta->detalle))
                        $pregunta->respuesta = $respuestasM->Respuestas($formulario->id, $pregunta->id, $documento[0]->id_documento);
                    foreach ($pregunta->detalle as $detalleHijo) {
                        $detalleHijo->detalle = $formularioM->PreguntaDetalleHijo($detalleHijo->id);
                        $detalleHijo->respuesta =$respuestasM->RespuestasHijas($formulario->id, $pregunta->id, $documento[0]->id_documento, $detalleHijo->id);
                        foreach ($detalleHijo->detalle as $key => $value) {
                            $value->respuesta = $respuestasM->RespuestasHijas($formulario->id, $pregunta->id, $documento[0]->id_documento, $value->id);
                        }
                    }
                }
            }

            
            $terminosM = new Terminos();
            $terminos = $terminosM->get()->getFirstRow();

            $etnia = $etnia->orderBy('orden', 'ASC')->get()->getResult();
            $genero = $genero->orderBy('orden', 'ASC')->get()->getResult();
            $user = $userM->where('id', $documento[0]->users_id)->get()->getFirstRow();
            return view('ciudadano/edit', [
                'formulario'    => $formulario,
                'documento'     => $documento[0],
                'etnias'        => $etnia,
                'generos'       => $genero,
                'user'          => $user,
                'terminos'      => $terminos
            ]);
        }else return view('errors/html/error_404');
    }

    public function edit_document(){
        // return var_dump($this->request->getPost());
        $id_document = $this->request->getPost('id_documento');
        $id_formulario = $this->request->getPost('id_formulario');
        $documentM = new Documento();
        $documentM->set([
            'help' => !empty($this->request->getPost('help_'.$id_formulario)) ? $this->request->getPost('help_'.$id_formulario) : 'off',
            'terminos' => !empty($this->request->getPost('terminos_'.$id_formulario)) ? $this->request->getPost('terminos_'.$id_formulario) : 'off',
            'firma' => !empty($this->request->getPost('firma_'.$id_formulario)) ? $this->request->getPost('firma_'.$id_formulario) : 'off'
            ])->where(['id_documento' => $id_document])->update();
        $formularioM = new Formularios();
        $formularioB = $formularioM->where(['id' => $id_formulario])->get()->getResult();
        $respuestaM = new Respuestas();
        $doc = $this->view_document($id_document, 3);
        $doc_2 = $this->view_document($id_document, 4);
        // return var_dump($doc_2);
        foreach($formularioB as $formulario){
            $formulario->secciones = $formularioM->Secciones($formulario->id);
            foreach ($formulario->secciones as $key => $seccion) {
                $seccion->preguntas = $formularioM->Preguntas($seccion->id);
                foreach ($seccion->preguntas as $key_preguntas => $pregunta) {
                    switch ($pregunta->tipo_pregunta_id) {
                        case 1:
                            $pregunta->respuesta = $respuestaM->Respuestas($id_formulario, $pregunta->id, $id_document);
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($pregunta->respuesta)){
                                if($pregunta->respuesta[0]->respuesta != $value){
                                    $respuestaM->set(['respuesta' => $value])->where(['id' => $pregunta->respuesta[0]->id])->update();
                                }
                            }elseif(!empty($value)){
                                $data = [
                                    'preguntas_id' => $pregunta->id,
                                    'documento_id_documento' => $id_document,
                                    'formulario_id' => $id_formulario,
                                    'secciones_id' => $seccion->id,
                                    'respuesta' => $value,
                                ];
                                $respuestaM->insert($data);
                            }
                            break;
                        case 2:
                            $pregunta->respuesta = $respuestaM->Respuestas($id_formulario, $pregunta->id, $id_document);
                            $value = $this->request->getPost($pregunta->campo_formulario);
                            if(!empty($pregunta->respuesta)){
                                if($pregunta->respuesta[0]->pregunta_detalle_id != $value){
                                    $respuestaM->set(['pregunta_detalle_id' => $value])->where(['id' => $pregunta->respuesta[0]->id])->update();
                                }
                            }elseif(!empty($value)){
                                $data = [
                                    'preguntas_id' => $pregunta->id,
                                    'documento_id_documento' => $id_document,
                                    'formulario_id' => $id_formulario,
                                    'secciones_id' => $seccion->id,
                                    'pregunta_detalle_id' => $value,
                                ];
                                $respuestaM->insert($data);
                            }
                            break;
                        case 3:
                            $value_aux = $this->request->getPost($pregunta->campo_formulario);
                            $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                            foreach ($pregunta->detalles as $key => $detalle) {
                                $detalle->respuesta = $respuestaM->RespuestasHijas($id_formulario, $pregunta->id, $id_document, $detalle->id);
                                if(!empty($detalle->respuesta))
                                    $respuestaM->where(['id' => $detalle->respuesta[0]->id])->delete();
                                $detalle->preguntaHijos = $formularioM->PreguntaDetalleHijo($detalle->id);
                                foreach ($detalle->preguntaHijos as $key => $hijos) {
                                    $hijos->respuesta = $respuestaM->RespuestasHijas($id_formulario, $pregunta->id, $id_document, $hijos->id);
                                    if(!empty($hijos->respuesta))
                                        $respuestaM->where(['id' => $hijos->respuesta[0]->id])->delete();
                                }
                            }
                            if(!empty($value_aux)){
                                $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                                foreach ($pregunta->detalles as $key => $detalles) {
                                    $valores = $value_aux;
                                        if($detalles->id == $valores){
                                            $detalles->hijos = $formularioM->PreguntaDetalleHijo($valores);
                                            $data = [
                                                'preguntas_id' => $pregunta->id,
                                                'documento_id_documento' => $id_document,
                                                'formulario_id' => $id_formulario,
                                                'secciones_id' => $seccion->id,
                                                'pregunta_detalle_id' => $valores
                                            ];
                                            $respuestaM->insert($data);
                                            foreach ($detalles->hijos as $key => $hijos) {
                                                switch ($hijos->tipo_pregunta_id) {
                                                    case 1:
                                                        $value_2 = $this->request->getPost($hijos->campo_formulario);
                                                        if(!empty($value_2)){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_document,
                                                                'formulario_id' => $id_formulario,
                                                                'secciones_id' => $seccion->id,
                                                                'respuesta' => $value_2,
                                                                'pregunta_detalle_id' => $hijos->id
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 3:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if($value_2 == $hijos->id){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_document,
                                                                'formulario_id' => $id_formulario,
                                                                'secciones_id' => $seccion->id,
                                                                'pregunta_detalle_id' => $value_2
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 4:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if(!empty($value_2)){
                                                            foreach ($value_2 as $key => $check_box) {
                                                                if($check_box == $hijos->id){
                                                                    $data = [
                                                                        'preguntas_id' => $pregunta->id,
                                                                        'documento_id_documento' => $id_document,
                                                                        'formulario_id' => $id_formulario,
                                                                        'secciones_id' => $seccion->id,
                                                                        'pregunta_detalle_id' => $check_box
                                                                    ];
                                                                    $respuestaM->insert($data);
                                                                }
                                                            }
                                                        }
                                                        break;

                                                }
                                            }
                                    }
                                }
                            }
                            break;
                        case 4:
                            $value_aux = $this->request->getPost($pregunta->campo_formulario);
                            $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                            foreach ($pregunta->detalles as $key => $detalle) {
                                $detalle->respuesta = $respuestaM->RespuestasHijas($id_formulario, $pregunta->id, $id_document, $detalle->id);
                                if(!empty($detalle->respuesta))
                                    $respuestaM->where(['id' => $detalle->respuesta[0]->id])->delete();
                                $detalle->preguntaHijos = $formularioM->PreguntaDetalleHijo($detalle->id);
                                foreach ($detalle->preguntaHijos as $key => $hijos) {
                                    $hijos->respuesta = $respuestaM->RespuestasHijas($id_formulario, $pregunta->id, $id_document, $hijos->id);
                                    if(!empty($hijos->respuesta))
                                        $respuestaM->where(['id' => $hijos->respuesta[0]->id])->delete();
                                }
                            }
                            if(!empty($value_aux)){
                                $pregunta->detalles = $formularioM->PreguntasDetalle($pregunta->id);
                                foreach ($pregunta->detalles as $key => $detalles) {
                                    foreach ($value_aux as $key => $valores) {
                                        if($detalles->id == $valores){
                                            $detalles->hijos = $formularioM->PreguntaDetalleHijo($valores);
                                            $data = [
                                                'preguntas_id' => $pregunta->id,
                                                'documento_id_documento' => $id_document,
                                                'formulario_id' => $id_formulario,
                                                'secciones_id' => $seccion->id,
                                                'pregunta_detalle_id' => $valores
                                            ];
                                            $respuestaM->insert($data);
                                            foreach ($detalles->hijos as $key => $hijos) {
                                                switch ($hijos->tipo_pregunta_id) {
                                                    case 1:
                                                        $value_2 = $this->request->getPost($hijos->campo_formulario);
                                                        if(!empty($value_2)){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_document,
                                                                'formulario_id' => $id_formulario,
                                                                'secciones_id' => $seccion->id,
                                                                'respuesta' => $value_2,
                                                                'pregunta_detalle_id' => $hijos->id
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 3:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if($value_2 == $hijos->id){
                                                            $data = [
                                                                'preguntas_id' => $pregunta->id,
                                                                'documento_id_documento' => $id_document,
                                                                'formulario_id' => $id_formulario,
                                                                'secciones_id' => $seccion->id,
                                                                'pregunta_detalle_id' => $value_2
                                                            ];
                                                            $respuestaM->insert($data);
                                                        }
                                                        break;
                                                    case 4:
                                                        $value_2 = $this->request->getPost($detalles->campo_formulario);
                                                        if(!empty($value_2)){
                                                            foreach ($value_2 as $key => $check_box) {
                                                                if($check_box == $hijos->id){
                                                                    $data = [
                                                                        'preguntas_id' => $pregunta->id,
                                                                        'documento_id_documento' => $id_document,
                                                                        'formulario_id' => $id_formulario,
                                                                        'secciones_id' => $seccion->id,
                                                                        'pregunta_detalle_id' => $check_box
                                                                    ];
                                                                    $respuestaM->insert($data);
                                                                }
                                                            }
                                                        }
                                                        break;

                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            break;
                        case 5:
                            $value_aux = $this->request->getPost($pregunta->campo_formulario);
                            $pregunta->respuesta = $respuestaM->Respuestas($id_formulario, $pregunta->id, $id_document);
                            if(!empty($value_aux)){
                                $value = json_decode($value_aux);
                                foreach ($pregunta->respuesta as $key => $respuesta) {
                                    $respuestaM->where(['id' => $respuesta->id])->delete();
                                }
                                foreach ($value as $key => $items) {
                                    foreach ($items as $key => $item) {
                                        $data = [
                                            'preguntas_id' => $pregunta->id,
                                            'documento_id_documento' => $id_document,
                                            'formulario_id' => $id_formulario,
                                            'secciones_id' => $seccion->id,
                                            'respuesta' => $item->value
                                        ];
                                        $respuestaM->insert($data);
                                    }
                                }
                            }
                        case 6:
                            $files = $this->request->getFiles($pregunta->campo_formulario);
                            $value_2 = $this->request->getPost("respuesta_{$pregunta->id}");
                            // return var_dump($files);
                            $pregunta->respuestas = $respuestaM->Respuestas($id_formulario, $pregunta->id, $id_document);
                            $names = $this->request->getPost($pregunta->campo_formulario.'_names');
                            foreach ($pregunta->respuestas as $key => $value) {
                                $validador = true;
                                if(!empty($value_2)){
                                    foreach ($value_2 as $key => $id_respuesta) {
                                        if($value->id == $id_respuesta) $validador = false;
                                    }
                                }
                                if($validador){
                                    if(unlink('img/files/'.$value->documento)) $respuestaM->where(['id' => $value->id])->delete();
                                }
                            }
                            if(!empty($files)){
                                foreach ($files as $key => $value) {
                                    if(!empty($value_2)){
                                        foreach ($value_2 as $keyRespuesta => $idRespuesta) {
                                            $file = $value[$keyRespuesta];
                                            $name =  $names[$keyRespuesta];
                                            if($file->getError() == 0){
                                                $respuesta = $respuestaM->Respuesta($idRespuesta);
                                                if(unlink('img/files/'.$respuesta[0]->documento)){
                                                    $file->new_name = $name;
                                                    $file->move('img/files', $file->getName());
                                                    $respuestaM->set(['respuesta' => $name, 'documento' => $file->getName()])->where(['id' => $idRespuesta])->update();
                                                }
                                            }
                                            else{
                                                $respuestaM->set(['respuesta' => $name])->where(['id' => $idRespuesta])->update();
                                            }
                                            unset($value[$keyRespuesta]);
                                            unset($names[$keyRespuesta]);
        
                                        }
                                    }
                                    foreach ($value as $key => $archivo) {
                                        $archivo->new_name = $names[$key];
                                        $archivo->move('img/files', $archivo->getName());
                                        $data = [
                                            'preguntas_id' => $pregunta->id,
                                            'documento_id_documento' => $id_document,
                                            'formulario_id' => $id_formulario,
                                            'secciones_id' => $seccion->id,
                                            'respuesta' => $archivo->new_name,
                                            'documento' => $archivo->getName()
                                        ];
                                        $respuestaM->insert($data);
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }


        $observation = $this->request->getPost('observation');
        $workM = new Work();
        $data = [
            'observation' => $observation,
            'documento_id_documento' => $id_document,
            'users_id' => session('user')->id,
            'work_type_id' => 1,
            'status' => 'Pendiente',
            'document' => $doc,
            'document_2' => $doc_2,

        ];
        $workM->insert($data);
        return redirect()->to(base_url(['cespidh', 'edit', 'document', $id_document]));
    }

    public function new_document(){
        $id_document = $this->request->getPost('id_documento');
        $file = $this->request->getFile('new_document');
        $observation = $this->request->getPost('observation');
        $workM = new Work();
        if($file->move('docs/upload', $file->getName())){
            $data = [
                'users_id' => session('user')->id,
                'work_type_id' => 3,
                'observation'   => $observation,
                'document'      => $file->getName(),
                'documento_id_documento'    => $id_document
            ];
            $workM->insert($data);
        }
        return redirect()->back();
    }

}