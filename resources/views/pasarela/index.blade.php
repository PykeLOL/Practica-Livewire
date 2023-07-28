<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pasarela de Pago</title>
    @extends('layouts.app')
    <script language="javascript" type="text/javascript">
        function closed() { window.open('','_parent',''); window.close(); }
    </script>
</head>
<body>
    <h1>Estas en la Pasarela de Pago</h1> <br>
                <h2>Carrito de Compras:</h2>
                <table class="table" style="width: 60%;">
                            <tr>
                                <td scope="row">NOMBRE</td>
                                <td>CANTIDAD</td>
                                <td>PRECIO</td>
                                <td>TOTAL</td>
                                <td>ELIMINAR</td>
                            </tr>
                            @php
                                $PricePagar = 0;
                            @endphp
                    @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>$ {{ $item['price'] }}</td>
                                <td>$ {{ $item['price'] * $item['quantity'] }}</td>
                                <!-- Puedes agregar botones para modificar la cantidad o eliminar productos del carrito -->
                                <td><button wire:click="removeFromCart({{ $item['product_id'] }})" class="btn btn-danger">Eliminar</button></td>
                            </tr>
                            @php
                                $PricePagar += $item['quantity'] * $item['price'];
                                $referenceCode =+ $PricePagar * $item['product_id'];
                            @endphp
                    @endforeach
                </table>
            @php
                $iva = 0.16;
                $tax = $PricePagar * $iva;
                $taxReturnBase = $PricePagar - $tax;
                $api_key = "4Vj8eK4rloUd272L48hsrarnUA";
                $merchantId = "508029";
                $moneda = "COP";
                $signature = md5($api_key."~".$merchantId."~".$referenceCode."~".$PricePagar."~".$moneda);
            @endphp
<div>


    <form method="post" action="https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/" target="_blank">
        <input name="merchantId"      type="hidden"  value="{{ $merchantId }}"   >
        <input name="accountId"       type="hidden"  value="512321" >
        <input name="description"     type="hidden"  value="Test PAYU"  >
        <input name="referenceCode"   type="hidden"  value="{{ $referenceCode }}" >
        <input name="amount"          type="hidden"  value="{{ $PricePagar }}">
        <input name="tax"             type="hidden"  value="{{ $tax }}"  >
        <input name="taxReturnBase"   type="hidden"  value="{{ $taxReturnBase }}" >
        <input name="currency"        type="hidden"  value="COP" >
        <input name="signature"       type="hidden"  value="{{ $signature }}"  >
        <input name="test"            type="hidden"  value="0" >
        <input name="buyerEmail"      type="hidden"  value="test@test.com" >
        <input name="responseUrl"     type="hidden"  value="http://localhost:8000/" >
        <input name="confirmationUrl" type="hidden"  value="http://localhost:8000/" >
        <p>Total a Pagar: ${{ $PricePagar }}</p>
        <input name="Submit" class="btn btn-success" type="submit" value="Pagar" >
        <button class="btn btn-danger"><a href="javascript:closed();" style="color: white;">Cancelar</a></button>
      </form>
</div>
</body>
</html>
