<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Imports\ProjectsImport;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PdfController;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getAllUsers (){

        $entireTable = User::all();
        return $entireTable;
    }

    public function getAllUsersWithoutLicense (){
        $entireTable = User::where('license', '')->get();
        return $entireTable;
    }

    public function login (Request $request){
        $jwtAuth = new JwtAuth();
        $json = array(
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        );
        $validate = Validator::make($json, array(
            'email'    => 'required|email',
            'password' => 'required'
        ));

        if($validate->fails()){
            $data = array (
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Login error',
                'errors'    => $validate->errors()
            );
        } else {
            $pwd = hash('sha256', $json['password']);
            $data = $jwtAuth->signup($json['email'],$pwd);
        }
        return response()->json($data,200);
    }

    public function importExcel(){
        $data = Excel::toArray(new ProjectsImport(), storage_path('../public/licenses.ods'));
        $dataParse= [];
        foreach ($data[0] as $key => $value) {
            $user = array('license' => $value[0],'email' => $value[1]);
            $this->_updateUsersByEmail($user);
            $file = PdfController::generatePDF($user);
            EmailController::sendEmail($user, $file);
            $dataParse[] = $user;
        }
        EmailController::sendFinalEmail('pedro@ba.com');
        EmailController::sendFinalEmail('cmc@ba.com');
        return $dataParse;
    }

    protected function _updateUsersByEmail($data){
        User::where('email', $data['email'])->update(array('license' => $data['license']));
    }

    public function myLicense(Request $request){
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $user = $jwtAuth->checkToken($token, true);

        if($user->role != 'user'){
            $data = array (
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Not valid role',
            );
            return response()->json($data,200);

        } else if($user->license === ''){
            $data = array (
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'No license nº',
            );
            return response()->json($data,200);

        }else{
            $file = '../public/license'.$user->license.'.pdf';
            if(!file_exists($file)){
                $data['email'] = $user->email;
                $data['license'] = $user->license;
                $file = PdfController::generatePDF($data);
            }
            return Response::download($file);
        }

    }

    public function upload(Request $request)
    {
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $user = $jwtAuth->checkToken($token, true);

        if($user->role != 'partner'){
            $data = array (
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Not valid role',
            );
            return response()->json($data,200);
        }
        $file = $request->file('file');
        $path = $file->store('public');
        $data = Excel::toArray(new ProjectsImport(), storage_path('../storage/app/'.$path));
        $dataParse= [];
        foreach ($data[0] as $key => $value) {
            $user = array('license' => $value[0],'email' => $value[1]);
            $this->_updateUsersByEmail($user);
            $file = PdfController::generatePDF($user);
            EmailController::sendEmail($user, $file);
            $dataParse[] = $user;
        }
        EmailController::sendFinalEmail('pedro@ba.com');
        EmailController::sendFinalEmail('cmc@ba.com');
        return $dataParse;

    }

    public function status(Request $request)
    {
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $user = $jwtAuth->checkToken($token, true);

        if($user->role != 'owner'){
            $data = array (
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'Not valid role',
            );
            return response()->json($data,200);
        }else{
            EmailController::sendFinalEmail($user->email);
            $data = array (
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'Summary sended',
            );
            return response()->json($data,200);

        }
    }

    
}
