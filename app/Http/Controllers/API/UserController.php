<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'email' => 'required',
            'contraseña' => 'required'
        ]);

        $user = new User();
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;
        $user->contraseña = Hash::make($request->contraseña);

        $user->save();

        return response()->json([
            "status" => 1,
            "msg" => "¡Usuario registrado exitosamente!"
        ]);
    }

    public function     iniciarsesion(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'contraseña' => 'required'
        ]);

        $user = User::where("email", "=", $request->email)->first();

        if (isset($user->id)) {
            if (Hash::check($request->contraseña, $user->contraseña)) {
                $token = $user->createToken("auth_token")->plainTextToken;

                return response()->json([
                    "access_token" => $token
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "msg" => "Contraseña incorrecta"
                ], 404);
            }
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado"
            ], 404);
        }
    }
    public function salir()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => "1",
            "msg" => "Has cerrado sesión"
        ]);
    }

    public function eliminar()
    {
        auth()->user()->delete();
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => "1",
            "msg" => "Usuario borrado con éxito"
        ]);
    }
}
