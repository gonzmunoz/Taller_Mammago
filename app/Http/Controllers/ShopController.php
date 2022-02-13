<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\Articulo;
use App\Models\ArticulosPedidos;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Mecanico;
use App\Models\Pedidos;
use App\Models\TipoUsuario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDF;

class ShopController extends Controller
{
    public function shop($category)
    {

        // MUESTRO LA VISTA PRINCIPAL DE LA TIENDA OCULTANDO O NO ARTÍCULOS SEGÚN EL TIPO DE USUARIO

        if (session('userLogged')['id_tipo_usuario'] == 4) {
            $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                ->where('articulos.visible', '=', 1)
                ->paginate(4)->withQueryString();
        } else {
            $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                ->paginate(4)->withQueryString();
        }

        if ($category != "all") {
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.visible', '=', 1)
                    ->where('categorias.nombre', $category)
                    ->paginate(4)->withQueryString();
            } else {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('categorias.nombre', $category)
                    ->paginate(4)->withQueryString();
            }

        }

        $_data['articles'] = $articles;
        $_data['categories'] = Categoria::all();
        $_data['categoryName'] = $category;
        $_data['brands'] = Marca::all();
        $_data['searched'] = null;

        return view('shop.shop', $_data);
    }

    public function searchShop(Request $request)
    {
        // MUESTRO LOS ARTÍCULOS SEGÚN LA BÚSQUEDA DEL USUARIO (POR NOMBRE DE ARTÍCULO)

        $validatedData = $request->validate([
            'searchProducts' => 'required',
        ], [
            'searchProducts.required' => trans('messages.searchProductsRequired'),
        ]);

        unset($request['_token']);
        $data = $request->all();


        if ($data['category'] != "all") {
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.visible', '=', 1)
                    ->where('categorias.nombre', $data['category'])
                    ->where('articulos.nombre', 'LIKE', '%' . $request['searchProducts'] . '%')
                    ->paginate(4)->withQueryString();
            } else {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('categorias.nombre', $data['category'])
                    ->where('articulos.nombre', 'LIKE', '%' . $request['searchProducts'] . '%')
                    ->paginate(4)->withQueryString();
            }

        } else {
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.visible', '=', 1)
                    ->where('articulos.nombre', 'LIKE', '%' . $request['searchProducts'] . '%')
                    ->paginate(4)->withQueryString();
            } else {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.nombre', 'LIKE', '%' . $request['searchProducts'] . '%')
                    ->paginate(4)->withQueryString();
            }

        }


        $_data['articles'] = $articles;
        $_data['categories'] = Categoria::all();
        $_data['categoryName'] = $data['category'];
        $_data['brands'] = Marca::all();
        $_data['searched'] = $request['searchProducts'];
        return view('shop.shop', $_data);

    }

    public function searchShopEngine(Request $request)
    {
        // MUESTRO LOS ARTÍCULOS SEGÚN LA BÚSQUEDA DEL USUARIO (POR TIPO DE MOTOR)

        $validatedData = $request->validate([
            'marca' => 'required|not_in:selectBrand',
            'modelo' => 'required|not_in:selectModel',
            'motor' => 'required|not_in:selectEngine',
        ], [
            'marca.required' => trans('messages.brandRequired'),
            'marca.not_in' => trans('messages.brandNotIn'),
            'modelo.required' => trans('messages.modelRequired'),
            'modelo.not_in' => trans('messages.modelNotIn'),
            'motor.required' => trans('messages.engineRequired'),
            'motor.not_in' => trans('messages.engineNotIn'),
        ]);

        if ($request['category'] != "all") {
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('categorias.nombre', $request['category'])
                    ->where('articulos.visible', '=', 1)
                    ->where('articulos.id_motor', $request['motor'])
                    ->paginate(4)->withQueryString();
            } else {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('categorias.nombre', $request['category'])
                    ->where('articulos.id_motor', $request['motor'])
                    ->paginate(4)->withQueryString();
            }
        } else {
            if (session('userLogged')['id_tipo_usuario'] == 4) {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.visible', '=', 1)
                    ->where('articulos.id_motor', $request['motor'])
                    ->paginate(4)->withQueryString();
            } else {
                $articles = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as Categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
                    ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
                    ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
                    ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
                    ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
                    ->where('articulos.id_motor', $request['motor'])
                    ->paginate(4)->withQueryString();
            }
        }


        $_data['articles'] = $articles;
        $_data['categories'] = Categoria::all();
        $_data['brands'] = Marca::all();
        $_data['categoryName'] = $request['category'];
        $_data['searched'] = null;
        return view('shop.shop', $_data);

    }

    public function articleDetails($id)
    {
        // MUESTRO LA VISTA CON LOS DETALLES DEL ARTÍCULO

        $id = Crypt::decryptString($id);
        $_data['article'] = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as categoria', 'marcas_coche.nombre as marca', 'modelos_coche.nombre as modelo', 'motorizaciones_coche.nombre as motor')
            ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
            ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->where('articulos.id', $id)
            ->first()->toArray();

        return view('shop.articleDetails', $_data);
    }

    public function newArticle()
    {
        // MUESTRO LA VISTA PARA AÑADIR UN NUEVO ARTÍCULO

        $_data['categories'] = Categoria::all();
        $_data['brands'] = Marca::all();

        return view('shop.newArticle', $_data);
    }

    public function storeArticle(Request $request)
    {
        // VALIDO LOS DATOS DE UN NUEVO ARTÍCULO ANTES DE GUARDARLO EN LA BASE DE DATOS

        $validatedData = $request->validate([
            'marca' => 'required|not_in:selectBrand',
            'modelo' => 'required|not_in:selectModel',
            'motor' => 'required|not_in:selectEngine',
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:1',
            'id_categoria' => 'required',
            'stock' => 'required|numeric|min:1',
            'visible' => 'required',
            'imagen' => 'required|mimes:jpeg,png,jpg',
        ], [
            'marca.required' => trans('messages.brandRequired'),
            'marca.not_in' => trans('messages.brandNotIn'),
            'modelo.required' => trans('messages.modelRequired'),
            'modelo.not_in' => trans('messages.modelNotIn'),
            'motor.required' => trans('messages.engineRequired'),
            'motor.not_in' => trans('messages.engineNotIn'),
            'nombre.required' => trans('messages.articleNameRequired'),
            'descripcion.required' => trans('messages.articleDescriptionRequired'),
            'precio.required' => trans('messages.articlePriceRequired'),
            'precio.numeric' => trans('messages.articlePriceNumeric'),
            'precio.min' => trans('messages.articlePriceMin'),
            'id_categoria.required' => trans('messages.idCategoryRequired'),
            'stock.required' => trans('messages.stockRequired'),
            'stock.numeric' => trans('messages.stockNumeric'),
            'stock.min' => trans('messages.stockMin'),
            'imagen.required' => trans('messages.articleImageRequired'),
            'imagen.mimes' => trans('messages.errorMimes'),
        ]);

        // Comprobar si el nombre ya está en uso
        if ((Articulo::where('nombre', $request['nombre'])->first()) != null) {
            return redirect()->back()->withInput($request->all());
        }

        unset($request['_token']);

        $data = array('id_motor' => $request['motor'], 'nombre' => $request['nombre'], 'descripcion' => $request['descripcion'], 'precio' => str_replace(',', '.', $request['precio']),
            'id_categoria' => $request['id_categoria'], 'stock' => $request['stock'], 'imagen' => '', 'visible' => $request['visible']);

        // Establezco el id en la base de datos para que la imagen vaya asociada con el id del artículo

        if (count(Articulo::all()) < 1) {
            $lastArticle = 0;
        } else {
            $lastArticle = (DB::table('articulos')->latest('id')->first())->id;
        }

        $data['id'] = $lastArticle + 1;

        // Subir la imagen al servidor
        $imageExtension = $request->file('imagen')->extension();
        $data['imagen'] = 'images/articles/' . 'articulo' . ($lastArticle + 1) . '.' . $imageExtension;

        $path = $request->file('imagen')->storeAs('', $data['imagen'], 'public');

        $data['imagen'] = substr($data['imagen'], 16);
        Articulo::insert($data);

        // Mensaje de cuenta creada
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.articleSaved');
        $msg['text'] = trans('messages.articleSuccessfullySaved');
        $request->session()->flash('response-form', $msg);
        return redirect()->route('shop', 'all');

    }

    public function editArticle($id)
    {
        // MUESTRO LA VISTA CON LOS DATOS DEL ARTTÍCULO PARA ACTUALIZARLO

        $id = Crypt::decryptString($id);
        $_data['article'] = Articulo::select('articulos.id as idArticulo', 'categorias.id as idCategoria', 'articulos.nombre', 'articulos.descripcion', 'articulos.precio', 'articulos.id_categoria', 'articulos.imagen', 'articulos.stock', 'articulos.visible', 'categorias.nombre as categoria', 'marcas_coche.id as id_marca', 'modelos_coche.id as id_modelo', 'motorizaciones_coche.id as id_motor')
            ->join('categorias', 'articulos.id_categoria', '=', 'categorias.id')
            ->join('motorizaciones_coche', 'articulos.id_motor', '=', 'motorizaciones_coche.id')
            ->join('modelos_coche', 'motorizaciones_coche.id_modelo', '=', 'modelos_coche.id')
            ->join('marcas_coche', 'modelos_coche.id_marca', '=', 'marcas_coche.id')
            ->where('articulos.id', $id)
            ->first()->toArray();
        $_data['categories'] = Categoria::all();
        $_data['brands'] = Marca::all();

        return view('shop.editArticle', $_data);

    }

    public function updateArticle(Request $request)
    {
        // VALIDO LOS DATOS DEL ARTÍCULO Y LO ACTUALIZO

        $validatedData = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'precio' => 'required|numeric|min:1',
            'id_categoria' => 'required',
            'stock' => 'required|numeric|min:0',
            'imagen' => 'mimes:jpeg,png,jpg|max:2048',
        ], [
            'nombre.required' => trans('messages.articleNameRequired'),
            'descripcion.required' => trans('messages.articleDescriptionRequired'),
            'precio.required' => trans('messages.articlePriceRequired'),
            'precio.numeric' => trans('messages.articlePriceNumeric'),
            'precio.min' => trans('messages.articlePriceMin'),
            'id_categoria.required' => trans('messages.idCategoryRequired'),
            'stock.required' => trans('messages.stockRequired'),
            'stock.numeric' => trans('messages.stockNumeric'),
            'stock.min' => trans('messages.stockMin'),
            'imagen.mimes' => trans('messages.errorMimes'),
        ]);

        $article = Articulo::where('nombre', $request['nombre'])->first()->toArray();

        // Comprobar si el nombre ya está en uso
        if ((Articulo::where('nombre', $request['nombre'])->where('id', '!=', $article['id'])->first()) != null) {
            return redirect()->back()->withInput($request->all());
        }

        unset($request['_token']);

        $data = array('id_motor' => $request['motor'], 'nombre' => $request['nombre'], 'descripcion' => $request['descripcion'], 'precio' => str_replace(',', '.', $request['precio']),
            'id_categoria' => $request['id_categoria'], 'stock' => $request['stock'], 'imagen' => '', 'visible' => $request['visible']);

        $data['precio'] = str_replace(',', '.', $data['precio']);

        if ($request['imagen'] != null) {
            // Subir la imagen al servidor
            $imageExtension = $request->file('imagen')->extension();
            $data['imagen'] = 'images/articles/' . 'articulo' . $article['id'] . '.' . $imageExtension;
            //dd($data['imagen']);
            $path = $request->file('imagen')->storeAs('', $data['imagen'], 'public');

            $data['imagen'] = substr($data['imagen'], 16);
        } else {
            $data['imagen'] = $article['imagen'];
        }

        Articulo::where('id', $article['id'])->update($data);

        // Mensaje de cuenta creada
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.articleUpdated');
        $msg['text'] = trans('messages.articleSuccessfullyUpdated');
        $request->session()->flash('response-form', $msg);
        return redirect()->back();

    }

    public function deleteArticle(Request $request)
    {
        // BORRO UN ARTÍCULO (NO SE UTILIZA PORQUE LOS ARTÍCULOS SOLO SE OCULTARÁN , NO SE BORRAN)
        $id = Crypt::decryptString($request['id']);
        Articulo::where('id', $id)->delete();
    }

    public function listOrders()
    {
        // MUESTRO TODOS LOS PEDIDOS QUE HAY EN LA BASE DE DATOS

        $_data['orders'] = Pedidos::select('pedidos.id as idPedido', 'pedidos.fecha', DB::raw('SUM(articulos_pedidos.cantidad) as articulos'), DB::raw('SUM(articulos_pedidos.precio * articulos_pedidos.cantidad) as precioTotal'), 'usuarios.id as idCliente', 'usuarios.nombre', 'usuarios.apellidos')
            ->join('articulos_pedidos', 'pedidos.id', '=', 'articulos_pedidos.id_pedido')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            ->groupBy('pedidos.id', 'pedidos.fecha', 'usuarios.id', 'usuarios.nombre', 'usuarios.apellidos')
            ->get()->toArray();

        return view('shop.listOrders', $_data);
    }

    public function myOrders()
    {
        // MUESTRO TODOS LOS PEDIDOS QUE HA HECHO UN CLIENTE

        $_data['orders'] = Pedidos::select('pedidos.id as idPedido', 'pedidos.fecha', DB::raw('SUM(articulos_pedidos.cantidad) as articulos'), DB::raw('SUM(articulos_pedidos.precio * articulos_pedidos.cantidad) as precioTotal'))
            ->join('articulos_pedidos', 'pedidos.id', '=', 'articulos_pedidos.id_pedido')
            ->where('pedidos.id_usuario', session('userLogged')['id'])
            ->groupBy('pedidos.id', 'pedidos.fecha')
            ->get()->toArray();

        return view('shop.myOrders', $_data);
    }

    public function viewOrder($id)
    {
        // MUESTRO LA VISTA PARA VER UN PEDIDO DETALLADAMENTE

        $id = Crypt::decryptString($id);
        $_data['order'] = Pedidos::select('pedidos.id as idPedido', 'pedidos.fecha', DB::raw('SUM(articulos_pedidos.precio * articulos_pedidos.cantidad) as precioTotal'))
            ->join('articulos_pedidos', 'pedidos.id', '=', 'articulos_pedidos.id_pedido')
            ->where('pedidos.id', $id)
            ->groupBy('pedidos.id', 'pedidos.fecha')
            ->get()->toArray();
        $_data['articles'] = ArticulosPedidos::select('articulos_pedidos.cantidad', 'articulos_pedidos.precio', 'articulos.nombre', 'articulos.imagen')
            ->join('articulos', 'articulos_pedidos.id_articulo', '=', 'articulos.id')
            ->where('articulos_pedidos.id_pedido', $id)
            ->get()->toArray();

        return view('shop.orderDetails', $_data);
    }

    public function printOrder($id)
    {
        // SACO EL PDF DE LA FACTURA DE UN PEDIDO

        $id = Crypt::decryptString($id);
        $_data['order'] = Pedidos::select('pedidos.id as idPedido', 'pedidos.fecha', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion', DB::raw('SUM(articulos_pedidos.precio * articulos_pedidos.cantidad) as precioTotal'))
            ->join('articulos_pedidos', 'pedidos.id', '=', 'articulos_pedidos.id_pedido')
            ->join('usuarios', 'pedidos.id_usuario', '=', 'usuarios.id')
            ->where('pedidos.id', $id)
            ->groupBy('pedidos.id', 'pedidos.fecha', 'usuarios.nombre', 'usuarios.apellidos', 'usuarios.direccion')
            ->get()->toArray();
        $_data['articles'] = ArticulosPedidos::select('articulos_pedidos.cantidad', 'articulos_pedidos.precio', 'articulos.nombre', 'articulos.imagen')
            ->join('articulos', 'articulos_pedidos.id_articulo', '=', 'articulos.id')
            ->where('articulos_pedidos.id_pedido', $id)
            ->get()->toArray();
        $pdf = PDF::loadView('pdfs.myOrderPDF', $_data);

        return $pdf->download(trans('messages.orderPdf'));
    }

}
