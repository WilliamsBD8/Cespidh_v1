<?php


namespace App\Controllers;


use App\Traits\Grocery;
use App\Models\Menu;
use App\Models\Preguntas;
use CodeIgniter\Exceptions\PageNotFoundException;

class TableController extends BaseController
{
    use Grocery;

    private $crud;

    public function __construct()
    {
        $this->crud = $this->_getGroceryCrudEnterprise();
        $this->crud->setSkin('bootstrap-v3');
        $this->crud->setLanguage('Spanish');
    }

    public function index($data)
    {
        $menu = new Menu();
        $component = $menu->where(['table' => $data, 'component' => 'table'])->get()->getResult();
        if($component) {
            $this->crud->setTable($component[0]->table);
            switch ($component[0]->table) {
                case 'documento_estado':
                    $this->crud->unsetAdd();
                    $this->crud->unsetDelete();
                    $this->crud->readOnlyFields(['nombre']);
                    break;
                case 'documento_tipo':
                    $this->crud->displayAs(['descripcion' => 'Descripción', 'abreviacion' => 'Abreviación']);
                    $this->crud->setTexteditor(['plantilla']);
                    break;
                
                case 'secciones':
                    $this->crud->displayAs(['formulario_id' => 'Formulario', 'title' => 'Título']);
                    $this->crud->setRelation('formulario_id', 'formularios', 'title');
                    break;

                case 'preguntas':
                    $this->crud->displayAs(['secciones_id' => 'Secciones', 'tipo_pregunta_id' => 'Tipo de pregunta', 'formulario_id' => 'Formulario', 'descripcion' => 'Descripción', 'titulo' => 'Título']);
                    $this->crud->setRelation('secciones_id', 'secciones', 'title'); 
                    $this->crud->setRelation('tipo_pregunta_id', 'tipo_pregunta', 'tipo');
                    $this->crud->setRelation('formulario_id', 'formularios', 'title');
                    $this->crud->setDependentRelation('secciones_id', 'formulario_id', 'formulario_id');
                    $this->crud->uniqueFields(['campo_formulario']);
                    break;                     

                case 'formularios':                    
                    $this->crud->displayAs(['documento_tipo_id_tipo' => 'Tipo de documento', 'title' => 'Título']);
                    $this->crud->setRelation('documento_tipo_id_tipo', 'documento_tipo', '{descripcion} - {abreviacion}'); 
                break;
                case 'tipo_pregunta':
                    if(session('user')->roles_id != 1){
                        $this->crud->unsetAdd();
                        $this->crud->unsetDelete();
                    }
                    break;
            }
            $output = $this->crud->render();
            if (isset($output->isJSONResponse) && $output->isJSONResponse) {
                header('Content-Type: application/json; charset=utf-8');
                echo $output->output;
                exit;
            }

            $this->viewTable($output, $component[0]->title, $component[0]->description);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    public function subindex($data, $data_2){
        $menu = new Menu();
        $component = $menu->where(['url' => $data.'/'.$data_2, 'component' => 'table'])->get()->getResult();
        if($component) {
            $this->crud->setTable($component[0]->table);
            switch ($component[0]->table) {

                case 'pregunta_detalle':
                    $this->crud->setRelation('formulario_id', 'formularios', '{title}'); 
                    $this->crud->setRelation('seccion_id', 'secciones', '{title}');
                    $this->crud->setRelation('preguntas_id', 'preguntas', '{pregunta}');
                    $this->crud->setRelation('pregunta_padre', 'pregunta_detalle', '{description}');
                    
                    if($data_2 == 'padre'){
                        $this->crud->setRelation('tipo_pregunta_id', 'tipo_pregunta', '{tipo}', ['id' => ['2', '3', '4']]);
                        $this->crud->where('pregunta_detalle.pregunta_padre IS NULL');
                        $this->crud->addFields(['formulario_id', 'seccion_id', 'preguntas_id', 'description', 'complemento', 'orden', 'campo_formulario']);
                        $this->crud->editFields(['formulario_id', 'seccion_id', 'preguntas_id', 'tipo_pregunta_id', 'description', 'complemento', 'orden', 'campo_formulario']);
                        $this->crud->columns(['formulario_id', 'seccion_id', 'preguntas_id', 'tipo_pregunta_id', 'description', 'complemento', 'orden', 'campo_formulario']);
                        $this->crud->callbackBeforeInsert(function ($stateParameters) {
                            $pregunta = new Preguntas();
                            $id = $stateParameters->data['preguntas_id'];
                            $pregunta = $pregunta->where(['id' => $id])->get()->getResult();
                            $stateParameters->data['tipo_pregunta_id'] = $pregunta[0]->tipo_pregunta_id;
                            // $errorMessage = new \GroceryCrud\Core\Error\ErrorMessage();
                            // return $errorMessage->setMessage("You can't add a Rejected status without a message\n". $stateParameters->data['preguntas_id']);
                            return $stateParameters;
                        });
                    }else{
                        $this->crud->where(['pregunta_detalle.pregunta_padre >?' => 'NULL']); 
                        $this->crud->setRelation('tipo_pregunta_id', 'tipo_pregunta', '{tipo}', ['id' => ['1', '3', '4']]);
                    }
                    $this->crud->setDependentRelation('pregunta_padre', 'preguntas_id', 'preguntas_id');
                    $this->crud->setDependentRelation('seccion_id', 'formulario_id', 'formulario_id');
                    $this->crud->setDependentRelation('preguntas_id', 'seccion_id', 'secciones_id');
                    $this->crud->displayAs(['formulario_id' => 'Formulario', 'seccion_id' => 'Sección', 'tipo_pregunta_id' => 'Tipo de Pregunta', 'description' => 'Pregunta', 'preguntas_id' => 'Pregunta']);
                    $this->crud->setTexteditor(['complemento']);
                    $this->crud->uniqueFields(['campo_formulario']);
                    $this->crud->requiredFields(['campo_formulario']);
                    break;
            
            }
            $output = $this->crud->render();
            if (isset($output->isJSONResponse) && $output->isJSONResponse) {
                header('Content-Type: application/json; charset=utf-8');
                echo $output->output;
                exit;
            }

            $this->viewTable($output, $component[0]->title, $component[0]->description);
        } else {
            throw PageNotFoundException::forPageNotFound();
        }
    }
}