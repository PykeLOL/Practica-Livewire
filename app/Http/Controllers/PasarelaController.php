<?php

namespace App\Http\Controllers;
use App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasarelaController extends Controller
{
    public $cartItems;
    public $totalPrice;

    public function index(Request $request)
    {
        $cartItems = Session::get('cartItems', []);
        return view('pasarela.index', compact('cartItems'));
    }

    public function PagarPayU()
    {

    }
}
