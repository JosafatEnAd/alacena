<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Dotenv\Parser\Value;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Int_;

use function GuzzleHttp\Promise\all;

class ProductoController extends Controller
{
    public function crear(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cantidad = $request->cantidad;

        $producto->save();

        return response()->json([
            "Status" => 1,
            "msg" => "Producto registrado exitosamente"
        ]);
    }

    public function editar(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nombre' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
        ]);

        $id = $request->id;
        $producto =  Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->precio = $request->precio;
        $producto->cantidad = $request->cantidad;

        $producto->update();


        return response()->json([
            "Status" => 1,
            "msg" => "Producto registrado exitosamente",
        ]);
    }

    public function borrar(Request $request)
    {
        $request->validate([
            'id' => 'required',
            //'nombre' => 'required',
            //'precio' => 'required',
            //'cantidad' => 'required',
        ]);

        $id = $request->id;
        $producto =  Producto::find($id);

        $producto->delete();


        return response()->json([
            "Status" => 1,
            "msg" => "Producto borrado exitosamente",
        ]);
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'id' => 'required',
            //'nombre' => 'required',
            //'precio' => 'required',
            //'cantidad' => 'required',
        ]);

        $id = $request->id;
        $producto =  DB::table('productos')->where('id', $id)->value('cantidad');
        $cantidad = new Value;
        $producto->cantidad = $cantidad->cantidad;

        return response()->json([
            $producto
        ]);
    }

    public function quitar(Request $request)
    {
        $request->validate([
            'id' => 'required',
            //'nombre' => 'required',
            //'precio' => 'required',
            //'cantidad' => 'required',
        ]);

        $id = $request->id;
        $producto =  Producto::find($id);

        $producto->delete();


        return response()->json([
            "Status" => 1,
            "msg" => "Producto borrado exitosamente",
        ]);
    }
    public function mostrar(Request $request)
    {
        $show = Producto::all('nombre', 'precio', 'cantidad');
        return response()->json([
            "Status" => 1,
            $show
        ]);
    }
}
