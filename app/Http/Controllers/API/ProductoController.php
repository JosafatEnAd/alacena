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
            'cb' => 'required',
            'nombre' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
        ]);

        $producto = new Producto();
        $producto->cb = $request->cb;
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
            'cb' => 'required',
            'nombre' => 'required',
            'precio' => 'required',
            'cantidad' => 'required',
        ]);

        $cb = $request->cb;
        $nombre = $request->nombre;
        $precio = $request->precio;
        $cantidad = $request->cantidad;
        $update = DB::table('productos')->where('cb', $cb)->update(['nombre' => $nombre, 'precio' => $precio, 'cantidad' => $cantidad]);

        return response()->json([
            "Status" => 1,
            "msg" => "Producto editado exitosamente",
        ]);
    }

    public function borrar(Request $request)
    {
        $request->validate([
            'cb' => 'required',
            //'nombre' => 'required',
            //'precio' => 'required',
            //'cantidad' => 'required',
        ]);

        $cb = $request->cb;
        $producto =  Producto::find($cb);
        DB::table('productos')->where('cb', $cb)->delete();


        return response()->json([
            "Status" => 1,
            "msg" => "Producto borrado exitosamente",
        ]);
    }

    public function agregar(Request $request)
    {
        $request->validate([
            'cb' => 'required',
            //'cantidad' => 'required',
        ]);

        $cb = $request->cb;
        $producto =  Producto::find($cb);
        DB::table('productos')->where('cb', $cb)->increment('cantidad', 1);


        return response()->json([
            "Status" => 1,
            "msg" => "Operación realizada exitosamente",
        ]);
    }

    public function quitar(Request $request)
    {
        $request->validate([
            'cb' => 'required',
            //'nombre' => 'required',
            //'precio' => 'required',
            //'cantidad' => 'required',
        ]);

        $cb = $request->cb;
        DB::table('productos')->where('cb', $cb)->decrement('cantidad', 1);


        return response()->json([
            "Status" => 1,
            "msg" => "Operación quitar exitosa",
        ]);
    }
    public function mostrar(Request $request)
    {
        $show = Producto::all('cb', 'nombre', 'precio', 'cantidad');
        return response()->json([
            "Status" => 1,
            $show
        ]);
    }
    public function pocaE(Request $request)
    {
        $show = DB::table('productos')->where('cantidad', '>=', 1)->where('cantidad', '<=', 20)->get(['cb', 'nombre', 'cantidad', 'precio']);
        return response()->json([
            "Status" => 1,
            $show
        ]);
    }
    public function sinE(Request $request)
    {
        $show = DB::table('productos')->where('cantidad', '<=', 0)->get(['cb', 'nombre', 'cantidad', 'precio']);
        return response()->json([
            "Status" => 1,
            $show
        ]);
    }
}
