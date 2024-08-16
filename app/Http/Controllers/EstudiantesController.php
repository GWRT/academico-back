<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;

class EstudiantesController extends Controller
{
    public function index(){
        return Estudiante::all();
    }

    public function store(Request $request){
        $inputs = $request->input();
        $response = Estudiante::create($inputs);
        return response()->json([
            'data' => $response,
            'message'=> 'Estudiante agregado con exito.'
        ]);
    }

    public function update(Request $request, $id){
        $est = Estudiante::find($id);
        if(isset($est)){
            $est->nombre = $request->nombre;
            $est->apellido = $request->apellido;
            $est->foto = $request->foto;

            if ($est->save()){
                return response()->json([
                    'data' => $est,
                    'message'=> 'Estudiante actualizado con exito.'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message'=> 'No se actualizo el estudiante.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el estudiante.'
            ]);
        }
    }

    public function show($id){ 
        $est = Estudiante::find($id);
        if(isset($est)){
            return response()->json([
                'data' => $est,
                'message'=> 'Estudiante se encontro con exito.'
            ]);
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el estudiante.'
            ]);
        }
    }

    public function destroy($id){
        $est = Estudiante::find($id);
        if(isset($est)){
            $res = Estudiante::destroy($id);
            if($res){
                return response()->json([
                    'data' => $est,
                    'message'=> 'Estudiante eliminado con exito.'
                ]);
            }else{
                return response()->json([
                    'data' => $est,
                    'message'=> 'Estudiante no se elimino con exito.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el estudiante.'
            ]);
        }
    }
}
