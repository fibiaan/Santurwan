<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;


class SensoresController extends Controller
{
    /**
     * Api que crea nuevos registros de sensores
     * 
     * Recibe para parametros @lectura el array con datos de la lectura
     * 
     */
    public function crearLectura (Request $request)
    {
        $req = $request->all();
        $lectura = isset($req['lectura']) ? $req['lectura'] : '';
        if ($lectura) {
            $nuevaLectura = DB::table('sensores')->insertGetId([
                'temperatura' => $lectura['temperatura'],
                'humedad' => $lectura['humedad'],
                'uv' => $lectura['uv'],
                'fecha_creacion' => now(),
                'fecha_ult_modif' => now()
            ], 'id_sensores');
            $finalresult = response()->json(['status' => true, 'data' => $nuevaLectura,'message' =>'Lectura guardada satisfactoriamente']);
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }
        return $finalresult;
    }
    /**
     * Api que editar  registros de sensores
     * 
     * Recibe para parametros @lectura el array con datos de la lectura
     * 
     */
    public function editarLectura (Request $request)
    {
        $req = $request->all();
        $lectura = isset($req['lectura']) ? $req['lectura'] : '';
        if ($lectura) {
            $nuevaLectura = DB::table('sensores')
            ->where('id_sensores',$lectura['id_sensores'])
            ->update([
                'temperatura' => $lectura['temperatura'],
                'humedad' => $lectura['humedad'],
                'uv' => $lectura['uv'],
                'fecha_ult_modif' => now()
            ]);
            $finalresult = response()->json(['status' => true, 'data' => $nuevaLectura,'message' =>'Lectura editada satisfactoriamente']);
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }
        return $finalresult;
    }
    /**
     * Api que traer el ultimo registro
     * 
     * NO Recibe parametros
     * 
     */
    public function traerUltimaLectura (Request $request)
    {
        $req = $request->all();
        $nuevaLectura = DB::table('sensores')
            ->orderBy('id_sensores', 'DESC')
            ->take(1)
            ->get();
        $finalresult = response()->json(['status' => true, 'data' => $nuevaLectura,'message' =>'Registro cargado']);
        return $finalresult;
    }
    /**
     * Api que traer registros, los ultimos 50. Valida el login con el id del usuario
     * 
     * Recibe parametros @user con los datos del usuario
     * 
     */
    public function traerLecturas (Request $request)
    {
        $req = $request->all();
        $user = isset($req['user']) ? $req['user'] : '';
        if ($user) {
            $validarUsuario = DB::table('usuario')
                ->where('nickname',$user['nickname'])
                ->whereRaw("BINARY `clave`= ?", [$user['clave']])
                ->where('activo',1)
                ->get();
            $contarSql = $validarUsuario->count();
            if ($contarSql != 0) {
                $nuevaLectura = DB::table('sensores')
                    ->orderBy('id_sensores', 'DESC')
                    ->take(50)
                    ->get();
                $finalresult = response()->json(['status' => true, 'data' => $nuevaLectura,'message' =>'Registro cargado']);
            } else {
                $finalresult = response()->json(['status' => false, 'message' =>'Usuario no validado']);
            }
        } else {
            $finalresult = response()->json(['status' => false,'message' =>'No se enviaron datos ']);
        }
        return $finalresult;
    }
    
}