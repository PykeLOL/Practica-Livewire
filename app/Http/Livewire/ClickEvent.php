<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClickEvent extends Component
{
    public $message;
    public $products;
    public $showAddForm = false; // Variable para controlar la visibilidad del formulario
    public $name;
    public $description;
    public $price;
    public $showProducts = false;
    public $showCarrito = false;
    public $tituloCarrito;
    public $quantity;
    public $cart = [];
    public $item;
    public $totalPrice;
    public $cartItems = [];
    public $showCart = false;
    public $referenceCode;
    public $merchantId;
    public $iva;
    public $tax;
    public $taxReturnBase;
    public $api_key;
    public $moneda;
    public $signature;

    public function mount()
    {
        $this->cart = session('cart', []);
        $this->cartItems = Session::get('cartItems', []);

    }

    public function render()
    {
        return view('livewire.click-event')->extends('layouts.app');
    }

    public function productos()
    {
        $this->showProducts = true;
        $this->message = "Lista de Productos: ";
        $this->products = Products::get();
        $this->showAddForm = false;
    }

    public function addproducto()
    {
        $this->showAddForm = true;
        $this->showProducts = false;
    }

    // Función para ocultar el formulario de agregar producto
    public function cancelAddProducto()
    {
        $this->showAddForm = false;
    }

    public function borrarProducto($id)
    {
        $product = Products::find($id);
        $product->delete();

        $this->products = Products::all();
    }

    public function guardarProducto()
    {
        Products::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price
        ]);

        $this->name = '';
        $this->description = '';

        $this->showAddForm = false;
    }

    public function agregarProductoCarrito($product)
    {

        // // $quantity = $request->input('quantity');
        // $product = Products::findOrFail($id);
        // $cart = session()->get('cart', []);

        // if (isset($cart[$id])) {
        //     $cart[$id]['quantity']++;
        // } else {
        //     // Si el producto no está en el carrito, agregarlo
        //     $cart[$id] = [
        //         'product_id' => $product->id,
        //         'name' => $product->name,
        //         'price' => $product->price,
        //         // 'image_path' => $product->image_path,
        //         'quantity' => 1
        //     ];
        // }
        // // Actualizar el carrito en la sesión
        // session()->put('cart', $cart);

    }

    public function carrito()
    {
        $this->showCarrito = true;
        // $this->tituloCarrito = "Productos:";
        // $this->cart;
        $this->showCart = !$this->showCart;
    }

    public function ocultarCarrito()
    {
        $this->showCarrito = false;
    }

    public function borrarProductoCarrito()
    {

    }

    public function addToCart($productId)
    {
        $product = Products::find($productId);
        // $cartItems = session()->get('cartItems', []);
        // $cartItems = $this->cartItems;
        // Verificar si el producto ya está en el carrito
        $existingItem = array_search($productId, array_column($this->cartItems, 'product_id'));
        if ($existingItem !== false) {
            $this->cartItems[$existingItem]['quantity']++;
        } else {
            $this->cartItems[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        // $this->cartItems = $cartItems;
        Session::put('cartItems', $this->cartItems);
    }

    // Método para eliminar un producto del carrito
    public function removeFromCart($productId)
    {
        $this->cartItems = array_filter($this->cartItems, function ($item) use ($productId) {
            return $item['product_id'] !== $productId;
        });
        Session::put('cartItems', $this->cartItems);

        // Recalcular el total a pagar después de eliminar el producto
        $this->calculateTotal();
    }

    // Método para calcular el total a pagar
    private function calculateTotal()
    {
        $this->totalPrice = array_reduce($this->cartItems, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);
    }
}

