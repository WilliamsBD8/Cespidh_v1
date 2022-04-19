<?php


namespace App\Controllers;


use App\Traits\Grocery;
use App\Models\Menu;
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
                case 'documento_tipo':
                    $this->crud->displayAs(['descripcion' => 'Descripción', 'abreviacion' => 'Abreviación']);
                    break;
                
                case 'secciones':
                    $this->crud->displayAs(['formulario_prueba_id' => 'Formulario', 'title' => 'Título']);
                    $this->crud->setRelation('formulario_prueba_id', 'formularios', 'title');
                    break;

                case 'preguntas':
                    $this->crud->displayAs(['secciones_id' => 'Secciones', 'tipo_pregunta_id' => 'Tipo de pregunta', 'formulario_id' => 'Formulario', 'pregunta_padre_id' => 'Pregunta general', 'descripcion' => 'Descripción', 'titulo' => 'Título']);
                    $this->crud->setRelation('secciones_id', 'secciones', 'title'); 
                    $this->crud->setRelation('tipo_pregunta_id', 'tipo_pregunta', 'tipo');
                    $this->crud->setRelation('formulario_id', 'formularios', 'title');  
                    break;

                case 'formularios':                    
                    $this->crud->displayAs(['documento_tipo_id_tipo' => 'Tipo de documento', 'title' => 'Título']);
                    $this->crud->setRelation('documento_tipo_id_tipo', 'documento_tipo', '{descripcion} - {abreviacion}'); 
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