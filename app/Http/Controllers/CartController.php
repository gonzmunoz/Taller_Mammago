<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CartController extends Controller
{

    public function cartIndex()
    {
        // MUESTRO TODO LO QUE TIENE EL CARRITO DE LA COMPRA ACTUALMENTE

        $cartCollection = \Cart::getContent();
        $_data['cart'] = $cartCollection->sort();

        return view('shop.cart.index', $_data);
    }

    public function cartAdd(Request $request)
    {
        // AÑADO UNA UNIDAD DE UN ARTÍCULO AL CARRITO DE LA COMPRA

        $id = Crypt::decryptString($request['idArticle']);
        $article = Articulo::where('id', $id)->first()->toArray();
        $cartAmount = \Cart::get($article['id']);

        if ($cartAmount != null) {

            if ($article['stock'] <= $cartAmount['quantity']) {
                $msg['icon'] = 'error';
                $msg['title'] = trans('messages.cantAddUnit');
                $msg['text'] = trans('messages.noEnoughStock');
                $request->session()->flash('response-form', $msg);
                return redirect()->back();
            } else {
                $data = ['id' => $article['id'], 'name' => $article['nombre'], 'price' => $article['precio'], 'quantity' => 1, 'attributes' => array('imagen' => $article['imagen'], 'stock' => $article['stock'])];
            }
        } else {
            $data = ['id' => $article['id'], 'name' => $article['nombre'], 'price' => $article['precio'], 'quantity' => 1, 'attributes' => array('imagen' => $article['imagen'], 'stock' => $article['stock'])];
        }

        \Cart::add($data);
        // Mensaje de producto añadido
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.articleAdded');
        $msg['text'] = trans('messages.articleSuccessfullyAdded');
        $request->session()->flash('response-form', $msg);
        return redirect()->back();
    }

    public function cartAddAmount(Request $request)
    {
        // AÑADO UNA CANTIDAD CONCRETA DE UN ARTÍCULO AL CARRITO DE LA COMPRA

        $id = Crypt::decryptString($request['idArticle']);
        $article = Articulo::where('id', $id)->first()->toArray();

        $data = ['id' => $article['id'], 'name' => $article['nombre'], 'price' => $article['precio'], 'quantity' => $request['quantity'], 'attributes' => array('imagen' => $article['imagen'], 'stock' => $article['stock'])];
        \Cart::add($data);

        // Mensaje de producto añadido
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.articleAdded');
        $msg['text'] = trans('messages.articleSuccessfullyAdded');
        $request->session()->flash('response-form', $msg);
        return redirect()->back();
    }

    public function updateCartArticle(Request $request)
    {
        // ACTUALIZO LA CANTIDAD DE UN ARTÍCULO DEL CARRITO DE LA COMPRA

        $articleData = [];
        $id = Crypt::decryptString($request['id']);
        $article = Articulo::where('id', $id)->first()->toArray();
        \Cart::update($article['id'], array('quantity' => array('relative' => false, 'value' => $request['articleQuantity'])));
        $articleData[] = \Cart::getTotal();
        $articleData[] = \Cart::getTotalQuantity();
        return $articleData;
    }

    public function cartRemoveItem(Request $request)
    {
        // ELIMINO UN ARTÍCULO DEL CARRITO DE LA COMPRA

        $id = Crypt::decryptString($request['id']);
        \Cart::remove($id);
        return \Cart::getTotalQuantity();
    }

    public function cartCheckout()
    {
        // DEVUELVO LA VISTA PARA PROCESAR EL PEDIDO

        return view('shop.cart.checkout');
    }

    public function cartClear(Request $request)
    {
        // ELIMINO TODOS LOS ARTÍCULOS DEL CARRITO DE LA COMPRA

        \Cart::clear();
        // Mensaje de carrito vacío
        $msg['icon'] = 'success';
        $msg['title'] = trans('messages.cartCleared');
        $msg['text'] = trans('messages.cartSuccessfullyCleared');
        $request->session()->flash('response-form', $msg);
        return redirect()->back();
    }


}
