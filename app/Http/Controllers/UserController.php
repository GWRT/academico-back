<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs["password"] = Hash::make(trim($request->password));
        $response = User::create($inputs);
        return response()->json([
            'data' => $response,
            'message'=> 'Registrado con exito.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $est = User::find($id);
        if(isset($est)){
            return response()->json([
                'data' => $est,
                'message'=> 'Encontrado con exito.'
            ]);
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe.'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $est = User::find($id);
        if(isset($est)){
            $est->first_name = $request->first_name;
            $est->last_name = $request->last_name;
            $est->email = $request->email;
            $est->password = Hash::make($request->password);

            if ($est->save()){
                return response()->json([
                    'data' => $est,
                    'message'=> 'Actualizado con exito.'
                ]);
            }else{
                return response()->json([
                    'error' => true,
                    'message'=> 'No se actualizo.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $est = User::find($id);
        if(isset($est)){
            $res = User::destroy($id);
            if($res){
                return response()->json([
                    'data' => $est,
                    'message'=> 'Eliminado con exito.'
                ]);
            }else{
                return response()->json([
                    'data' => $est,
                    'message'=> 'No se elimino con exito.'
                ]);
            }
        }else{
            return response()->json([
                'error' => true,
                'message'=> 'No existe.'
            ]);
        }
    }
}
