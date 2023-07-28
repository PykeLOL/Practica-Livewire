<div>
    <button type="button" wire:click="addproducto" class="btn btn-danger">Agregar Producto</button>
    <button type="button" wire:click="productos" class="btn btn-danger">Lista de Productos</button>
    <p>{{ $message }}</p>
    @if ($showAddForm)
        <form wire:submit.prevent="guardarProducto">
            <div class="form-group">
                <label for="name">Nombre del Producto:</label>
                <input type="text" wire:model="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Descripción:</label>
                <textarea wire:model="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio:</label>
                <textarea wire:model="price" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
            <button type="button" wire:click="cancelAddProducto" class="btn btn-secondary">Cancelar</button>
        </form>
    @endif

    @if($showProducts)
        @if ($products)
        <table class="table" style="width: 80%;>
            <thead class="thead-dark"><tr>
                <td>ID</td>
                <td>NOMBRE</td>
                <td>DESCRIPTION</td>
                <td>ELIMINAR</td>
                <td>ADD CARRITO</td>
            </tr></thead>
            <tbody>
            @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <button type="button" wire:click="borrarProducto({{$product->id}})" class="btn btn-danger">Borrar</button>
                        </td>
                        <td>
                            <button type="button" wire:click="addToCart({{$product->id}})" class="btn btn-success">Agregar</button>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>

        @endif
    @endif
    <br>
    @if(!$showCarrito)
        <button type="button" wire:click="carrito" class="btn btn-danger">Carrito</button>
    @endif
    @if($showCarrito)
    <button type="button" wire:click="ocultarCarrito" class="btn btn-danger">Carrito</button>
        <div>
            <h2>Carrito de Compras</h2>
            @if (count($cartItems) > 0)
                <table class="table" style="width: 60%;">
                            <tr>
                                <td scope="row">NOMBRE</td>
                                <td>CANTIDAD</td>
                                <td>PRECIO</td>
                                <td>TOTAL</td>
                                <td>ELIMINAR</td>
                            </tr>
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
                                $totalPrice = $totalPrice + ($item['price']*$item['quantity']);
                            @endphp
                    @endforeach
                </table>
                <p>Total a Pagar: ${{ $totalPrice }}</p>
                <button wire:click="checkout">Pagar</button>
                <button class="btn btn-success"><a target="_blank" style="color: white;"   href="{{ route('pasarela.index') }}">Pagar con PayU</a></button>

            @else
                <p>El carrito está vacío.</p>
            @endif
        </div>

    @endif



</div>
