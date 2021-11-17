<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class UserController extends Controller
{
    /**
     * Api que crea nuevos usuarios
     *
     * Recibe para parametros @user el array con datos del usuario
     *
     */
    public function createUser (Request $request)
    {
        $req = $request->all();
        $user = isset($req['user']) ? $req['user'] : '';
        if ($user) {
            $validarNombreUsuario = DB::table('usuario')->where('nickname',$user['nickname'])->get();
            $contarSql = $validarNombreUsuario->count();
            if ($contarSql == 0) {
                $crearUsuario = DB::table('usuario')->insertGetId([
                    'nickname' => $user['nickname'],
                    'clave' => $user['clave'],
                    'nombre_completo' => $user['nombre_completo'],
                    'fecha_creacion' => now(),
                    'fecha_ult_modif' => now(),
                ], 'id_usuario');
                $finalresult = response()->json(['status' => true, 'data' => $crearUsuario,'message' =>'Usuario creado satisfactoriamente']);
            } else {
                $finalresult = response()->json(['status' => false, 'message' =>'Nickname ya esta creado']);
            }
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }
        return $finalresult;
    }
    /**
     * Api para editar usuarios por id_usuario
     *
     * Recibe para parametros @user el array con datos del usuario
     *
     */
    public function editarUser (Request $request)
    {
        $req = $request->all();
        $user = isset($req['user']) ? $req['user'] : '';
        if ($user) {
            $editarUsuario = DB::table('usuario')->where('id_usuario', $user['id_usuario'])->update([
                'clave' => $user['clave'],
                'nombre_completo' => $user['nombre_completo'],
                'fecha_ult_modif' => now()
            ]);
            if ($editarUsuario) {
                $finalresult = response()->json(['status' => true ,'message' =>'Usuario editado satisfactoriamente']);
            } else {
                $finalresult = response()->json(['status' => false ,'message' =>'Error al editar usuario']);
            }
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }
        return $finalresult;
    }
    /**
     * Api para inactivar usuarios por id_usuario
     *
     * Recibe para parametros @user el array con datos del usuario
     *
     */
    public function inactiveUser (Request $request)
    {
        $req = $request->all();
        $status = isset($req['status']) ? $req['status'] : '';
        $user = isset($req['user']) ? $req['user'] : '';
        if ($user) {
            $inactivarUsuario = DB::table('usuario')->where('id_usuario', $user['id_usuario'])->update([
                'activo' => $status,
                'fecha_ult_modif' => now()
            ]);
            if ($inactivarUsuario) {
                $finalresult = response()->json(['status' => true ,'message' =>'Usuario actualizado satisfactoriamente']);
            } else {
                $finalresult = response()->json(['status' => false,'message' =>'Error al inactivar usuario']);
            }
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }

        return $finalresult;
    }
    /**
     * Api para validar Login de usuario
     *
     * Recibe para parametros @user el array con datos del usuario
     *
     */
    public function loginUser (Request $request)
    {
        $req = $request->all();
        $user = isset($req['user']) ? $req['user'] : '';
        if ($user) {
            $loginUsuario = DB::table('usuario')
            ->where('nickname', $user['nickname'])
            ->whereRaw("BINARY `clave`= ?", [$user['clave']])
            ->where('activo',1)
            ->get();
            $contarSql = $loginUsuario->count();
            if ($contarSql != 0) {
                $finalresult = response()->json(['status' => true,'data' =>$loginUsuario[0],'message' =>'Usuario encontrado']);
            } else {
                $finalresult = response()->json(['status' => false,'message' =>'No se encontro el usuario']);
            }
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }

        return $finalresult;
    }
}
