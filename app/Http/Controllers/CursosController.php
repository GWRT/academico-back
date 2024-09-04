<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    public function index(){
        return Curso::all();
    }
    
    public function store(Request $request){
        $inputs = $request->input();
        $response = Curso::create($inputs);
        return response()->json([
            'data' => $response,
            'message'=> 'Curso agregado con exito.'
        ]);
    }

    public function update(Request $request, $id){
        $curso = Curso::find($id);
        if(isset($curso)){
            $curso->nombre = $request->nombre;
            $curso->horas = $request->horas;

            if ($curso->save()){
                return response()->json([
                    'data' => $curso,
                    'message'=> 'Curso actualizado con exito.'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message'=> 'No se actualizo el curso.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el curso.'
            ]);
        }
    }

    public function show($id) {
        $curso = Curso::find($id);
        if(isset($curso)){
            return response()->json([
                'data' => $curso,
                'message'=> 'Curso se encontro con exito.'
            ]);
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el curso.'
            ]);
        }
    }

    public function destroy($id){
        $curso = Curso::find($id);
        if(isset($curso)){
            if ($curso->delete()){
                return response()->json([
                    'data' => $curso,
                    'message'=> 'Curso eliminado con exito.'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message'=> 'No se elimino el curso.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe el curso.'
            ]);
        }
    }
}
