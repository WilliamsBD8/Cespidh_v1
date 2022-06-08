<?php


namespace App\Filters;


use App\Models\Permission;
use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class PermissionFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {

        $request = Services::request();
        $url = $request->uri->getSegment(1);
        $method =  $request->uri->getSegment(2);
        $permission = new Permission();
        if($url == 'table' || $url == 'config') {
            if(!empty($request->uri->getSegment(3)))
            $method .= '/'.$request->uri->getSegment(3);
            $data = $permission->select('*')
                ->join('menus', 'menus.id = permissions.menu_id')
                ->join('roles', 'roles.id = permissions.role_id')
                ->where(['menus.url' =>  $method, 'role_id' => session('user')->role_id ] )
                ->get()
                ->getResult();
            if(count($data) == 0 && session('user')->role_id != 1) {
               echo  view('errors/html/error_401');
               exit;
            }
        } else {
            if($url != 'home') {
                $url_2 =  $request->uri->getSegment(2);
                $method_2 =  $request->uri->getSegment(3);
                if(!empty($method))
                    $url_2 = $url.'/'.$method_2;
                $data = $permission->select('*')
                ->join('menus', 'menus.id = permissions.menu_id')
                    ->join('roles', 'roles.id = permissions.role_id')
                    ->where(['menus.url' => $url_2, 'role_id' => session('user')->role_id])
                    ->get()
                    ->getResult();
                // var_dump($url . '/' . $method);
                if (!$data && session('user')->role_id != 1 && $method != 'view') {
                    // echo  view('errors/html/error_401');
                    // exit;
                }
            }
        }


    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}