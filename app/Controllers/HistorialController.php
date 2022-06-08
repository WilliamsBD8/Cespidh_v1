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


class HistorialController extends BaseController
{
  public function index($id){
    $userM = new User();
    $workM = new Work();
    $documentoM = new Documento();
    $documento = $documentoM
      ->where(['id_documento' => $id])->get()->getResult();
    $works = $workM
      ->select('work.*, work_type.id as work_type_id, work_type.name as name')
      ->join('work_type', 'work_type.id = work.work_type_id', 'left')
      ->where(['documento_id_documento' => $id])
      ->orderBy('work.id', 'DESC')->get()->getResult();
    foreach($works as $work){
      $work->user = $workM->User($work->users_id);
      if(!empty($work->user_aux))
        $work->user_asigado = $workM->User($work->user_aux);
    }
    // return var_dump($works);
    $users = $userM->whereNotIn('role_id', [1,3])
        ->where(['sedes_id' => session('user')->sedes_id])
        ->select('users.*, roles.name as rol')
        ->join('roles', 'users.role_id = roles.id')
        ->get()->getResult();
    return view('ciudadano/historial', [
        'usuarios' => $users,
        'works' => $works,
        'documento' => $documento[0]
    ]);
  }

  public function create(){
    $type = $this->request->getPost('type');
    switch ($type) {
      case 'create':
        $user = $this->request->getPost('user');
        $observation = $this->request->getPost('observation');
        $type_work = $this->request->getPost('type_work');
        $id_documento = $this->request->getPost('id_documento');
        $workM = new Work();
        $data = [
          'observation' => $observation,
          'documento_id_documento' => $id_documento,
          'users_id' => session('user')->id,
          'work_type_id' => 2,
          'user_aux' => $user,
          'status' => 'Aceptado'
        ];
        $workM->set(['finish_at' => date('Y-m-d H:i:s'), 'status' => 'Finalizado'])
          ->where(['documento_id_documento' => $id_documento, 'status' => 'Aceptado', 'work_type_id' => 2])->update();
        $workM->insert($data);
        break;
    }
    return redirect()->back();
  }

  public function index_activity(){
    $workM = new Work();
    $works = $workM
      ->select('work.*, work_type.name as name')
      ->join('work_type', 'work_type.id = work.work_type_id', 'left')
      ->where(['users_id' => session('user')->id])
      ->orWhere(['user_aux' => session('user')->id])
      ->orderBy('work.id', 'DESC')->get()->getResult();
    foreach($works as $work){
        $work->user = $workM->User($work->users_id);
        if(!empty($work->user_aux))
          $work->user_asigado = $workM->User($work->user_aux);
        $work->documento = $workM->Documento($work->documento_id_documento);
    }
    // return var_dump($documents);
    return view('pages/activity', [
      'works' => $works
    ]);
  }
}