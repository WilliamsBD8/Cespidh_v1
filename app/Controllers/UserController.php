<?php


namespace App\Controllers;


use App\Models\User;
use Config\Services;


class UserController extends BaseController
{
    public function perfile()
    {
        $validation = Services::validation();
        $user = new User();
        $data = $user->select('*, roles.name as role_name, users.name as name')
            ->join('roles', 'users.role_id = roles.id')
            ->where('users.id', session('user')->id)
            ->get()->getResult()[0];

        echo view('users/perfile',[ 'data' => $data, 'validation' => $validation]);
    }

    public function updateUser()
    {
        if ($this->validate([
            'name'              => 'required|max_length[45]',
            'username'          => 'required|max_length[40]',
            'email'             => 'required|valid_email|max_length[100]',
        ], [
            'name' => [
                'required'      => 'El campo Nombres y Apellidos es obrigatorio.',
                'max_length'    => 'El campo Nombres Y Apellidos no debe terner mas de 45 caracteres.'
            ],
            'username' => [
                'required'      => 'El campo Nombre de Usuario es obligatorio',
                'max_length'    => 'El campo Nombre de Usuario no puede superar mas de 20 caracteres.'
            ],
            'email' => [
                'required'      => 'El campo Correo Electronico es obrigatorio.',
            ]

        ])) {
            $data = [
                'name'          => $this->request->getPost('name'),
                'username'      => $this->request->getPost('username'),
                'email'         => $this->request->getPost('email'),
            ];



            $user = new User();
            $user->set($data)->where(['id' => session('user')->id])->update();
            return redirect()->to('/perfile')->with('success', 'Datos guardado correctamente.');
        } else {
            return redirect()->to('/perfile')->withInput();
        }
    }

    public function update_perfil_doc(){
        $id = $this->request->getPost('id');
        $validation = Services::validation();
        $rule = [
            'cedula' => 'required|is_unique[users.cedula, id, '.$id.']',
            'email' => 'required|is_unique[users.email, id, '.$id.']',
            'phone' => 'required|is_unique[users.phone, id, '.$id.']',
            'ciudad' => 'required',
            'direccion' => 'required',
            'etnia' => 'required',
            'genero' => 'required',
            'name' => 'required',
        ];
        $messages = [
            'cedula' => [
                'required'      => 'La cédula es obligatorio.',
                'is_unique'     => 'La cédula ya se encuentra registrada.'
            ],
            'email' => [
                'required'      => 'El correo electrónico es obligatorio.',
                'is_unique'     => 'El correo ya se encuentra registrado.'
            ],
            'phone' => [
                'required'      => 'El  número de teléfono es obligatorio.',
                'is_unique'     => 'El número de teléfono ya se encuentra registrado.'
            ],
            'name' => [
                'required'      => 'El nombre es obligatorio.',
            ],
            'ciudad' => [
                'required'      => 'La ciudad es obligatorio.'
            ],
            'direccion'      => [
                'required'      => 'La dirección es obligatorio.',
            ],
            'etnia' => [
                'required'      => 'El grupo etnico es obligatorio.',
            ],
            'genero' => [
                'required'      => 'El género es obligatorio.',
            ]
        ];
        if($this->validate($rule, $messages)){
            $data = [
                'cedula' => $this->request->getPost('cedula'),
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'genero_id' => $this->request->getPost('genero'),
                'grupo_etnia_id' => $this->request->getPost('etnia'),
                'ciudad' => $this->request->getPost('ciudad'),
                'direccion' => $this->request->getPost('direccion'),
                'phone' => $this->request->getPost('phone'),
            ];
            $userM = new User();
            $validation = $this->request->getPost('validation');
            if($validation == 'false')
                $userM->set($data)->where(['id' => $id])->update();
            return json_encode(['update' => true]);
        }else{
            return json_encode(['update' => false, 'messages' => $validation->getErrors()]);
        }
    }

    public function create_perfil_doc(){
        $validation = Services::validation();
        $userM = new User();
        $user = $userM->where(['cedula' => $this->request->getPost('cedula')])->get()->getFirstRow();
        // return json_encode(['update' => false, 'messages' => $user]);
        if(empty($user)){
            $rule = [
                'cedula' => 'required|is_unique[users.cedula]',
                'email' => 'required|is_unique[users.email]',
                'phone' => 'required|is_unique[users.phone]',
                'ciudad' => 'required',
                'direccion' => 'required',
                'etnia' => 'required',
                'genero' => 'required',
                'name' => 'required',
            ];
            $messages = [
                'cedula' => [
                    'required'      => 'La cédula es obligatorio.',
                    'is_unique'     => 'La cédula ya se encuentra registrada.'
                ],
                'email' => [
                    'required'      => 'El correo electrónico es obligatorio.',
                    'is_unique'     => 'El correo ya se encuentra registrado.'
                ],
                'phone' => [
                    'required'      => 'El  número de teléfono es obligatorio.',
                    'is_unique'     => 'El número de teléfono ya se encuentra registrado.'
                ],
                'name' => [
                    'required'      => 'El nombre es obligatorio.',
                ],
                'ciudad' => [
                    'required'      => 'La ciudad es obligatorio.'
                ],
                'direccion'      => [
                    'required'      => 'La dirección es obligatorio.',
                ],
                'etnia' => [
                    'required'      => 'El grupo etnico es obligatorio.',
                ],
                'genero' => [
                    'required'      => 'El género es obligatorio.',
                ]
            ];
            if($this->validate($rule, $messages)){
                $username = $this->request->getPost('email');
                $username = explode('@', $username);
                $username = $username[0];
                $data = [
                    'cedula'            => $this->request->getPost('cedula'),
                    'name'              => $this->request->getPost('name'),
                    'email'             => $this->request->getPost('email'),
                    'username'          => $username,
                    'password'          => password_hash($this->request->getPost('cedula'), PASSWORD_DEFAULT),
                    'status'            => 'active',
                    'role_id'           => 3,
                    'genero_id'         => $this->request->getPost('genero'),
                    'grupo_etnia_id'    => $this->request->getPost('etnia'),
                    'ciudad'            => $this->request->getPost('ciudad'),
                    'direccion'         => $this->request->getPost('direccion'),
                    'phone'             => $this->request->getPost('phone'),
                    'sedes_id'          => session('user')->sedes_id
                ];
                // $validation = $this->request->getPost('validation');
                // if($validation == 'false')
                    $userM->set($data)->insert();
                return json_encode(['update' => true]);
            }else{
                return json_encode(['update' => false, 'messages' => $validation->getErrors()]);
            }
        }else{
            $rule = [
                'cedula' => 'required',
            ];
            $messages = [
                'cedula' => [
                    'required'      => 'La cédula es obligatorio.',
                ]
            ];
            if($this->validate($rule, $messages)){
                return json_encode(['update' => true]);
            }else{
                return json_encode(['update' => false, 'messages' => $validation->getErrors()]);
            }
        }
    }


    public function updatePhoto()
    {
        $user = new User();
        if($img = $this->request->getFile('photo')){
            $newName = $img->getRandomName();
            $img->move('upload/images', $newName);
        }
        if($user->update(['photo' => $newName], ['id' => session('user')->id])){
            session('user')->photo = $newName;
            return redirect()->to('/perfile');
        }
    }
}