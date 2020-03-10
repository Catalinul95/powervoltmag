@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card login-card">
                <div class="card-header login-card-header">
                    <a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    <a href="{{ route('cart.index') }}">Cosul meu de cumparaturi</a>
                </div>
                <div class="card-body">
                    <h1 class="mb-4"><i class="fas fa-shopping-cart"></i> Cosul meu de cumparaturi</h1>
                    @if (!is_null($cart) && count($cart))
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Imagine</th>
                            <th scope="col">Titlu</th>
                            <th scope="col">Cantitate</th>
                            <th scope="col">Pret</th>
                            <th scope="col">Total</th>
                            <th>Actiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $key => $item)
                                <tr data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}" data-stock="{{ $item['stock'] }}">
                                    <td>#</td>
                                    <td><img src="{{ Storage::url($item['image']) }}" alt="" style="width: 100px; height: 100px;"></td>
                                    <td>{{ $item['title'] }}</td>
                                    <td style="display: flex;">
                                        <button class="decreaseQuantity">-</button>
                                        <input style="width: 35px; padding-left: .7rem;" type="text" value="{{ $item['quantity'] }}">
                                        <button class="increaseQuantity">+</button></td>
                                    <td>{{ $item['price'] }} Lei</td>
                                    <td>{{ number_format($item['quantity'] * $item['price'], 2) }} Ron</td>
                                    <td><button class="btn btn-danger removeItemFromCart"><i class="fas fa-trash" aria-hidden="true"></i></button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else 
                        <p>Nu ai produse in cosul tau de cumparaturi.</p>
                    @endif
                </div>
            </div>
            @if (isset($cart) && count($cart))
            <div class="card login-card">
                <div class="card-header login-card-header">
                    Finalizare comanda
                </div>
                <div class="card-body">
                    @if (!Auth::guest())
                    <form action="#" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="company_name">Nume Firma</label>
                            <input type="text" name="company_name" class="form-control" aria-describedby="emailHelp" placeholder="Numele firmei...">
                        </div>
                        <div class="form-group">
                            <label for="fiscal_code">Cod fiscal</label>
                            <input type="text" name="fiscal_code" class="form-control" aria-describedby="emailHelp" placeholder="Cod fiscal...">
                        </div>
                        <div class="form-group">
                            <label for="register_number">Nr.inregistrare</label>
                            <input type="text" name="register_number" class="form-control" aria-describedby="emailHelp" placeholder="Numar inregistrare...">
                        </div>
                        <div class="form-group">
                            <label for="bank">Banca</label>
                            <input type="text" name="bank" class="form-control" aria-describedby="emailHelp" placeholder="Banca...">
                        </div>
                        <div class="form-group">
                            <label for="iban">IBAN</label>
                            <input type="text" name="iban" class="form-control"aria-describedby="emailHelp" placeholder="IBAN...">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="judet_company">Judetul sediului firmei</label>
                                <select name="judet" id="" class="form-control">
                                    <option value="">Alege judetul..</option>
                                    @foreach ($judete as $judet)
                                        <option value="{{ $judet['auto'] }}|{{ $judet['nume'] }}">{{ $judet['nume'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                            <label for="localitate_company">Localitate sediului firmei</label>
                            <select name="judet" id="" class="form-control">
                                    <option value="">Alege localitatea..</option>
                                    @foreach ($orase as $oras)
                                        <option value="{{ $oras['nume'] }}">{{ $oras['nume'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="postal_code_company">Cod Postal</label>
                            <input type="text" name="postal_code" class="form-control" aria-describedby="emailHelp" placeholder="Cod postal...">
                        </div>
                        <div class="form-group">
                            <label for="company_address">Adresa sediului firmei</label>
                            <input type="text" name="company_address" class="form-control"aria-describedby="emailHelp" placeholder="Adresa sediului firmei...">
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Nume</label>
                            <input type="text" name="first_name" class="form-control" id="inputEmail4" placeholder="Nume..." value="{{ $user->first_name }}">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Prenume</label>
                            <input type="text" name="last_name" class="form-control" id="inputPassword4" placeholder="Prenume..." value="{{ $user->last_name }}">
                        </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree">
                            <label for="agree">Sunt de acord cu <a href="#">Termenii si conditile</a></label>   
                        </div>
                        <button class="btn btn-success">Trimite comanda!</button>  
                    </form>
                    @else 
                        <p>Pentru a putea finaliza comanda este necesar un cont.</p>
                        <a href="/login" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Autentificare</a>
                        <a href="/register" class="btn btn-primary"><i class="fas fa-user-plus"></i> Inregistrare</a>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @if (isset($cart) && count($cart))
        <div class="col-md-4">
            <div class="card login-card">
                <div class="card-header login-card-header">Sumar Comanda</div>
                <div class="card-body">
                    <h5>Cost Livrare: <strong style="color: #EA2027;">15.00 Ron</strong></h5>
                    <hr>
                    <h5>
                        <span>TOTAL( TVA inclus ):</span> <strong style="color: #EA2027;" id="totalPrice">
                            @php $total = 0; @endphp
                            @foreach ($cart as $key => $item)
                                @php $total += $item['price'] * $item['quantity']; @endphp
                            @endforeach
                            {{ number_format($total, 2) }}
                        </strong>
                    </h5>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

    <script>
        $('.removeItemFromCart').click(function (e) {
            var tr = $($(this).parent()).parent();
            var productId = $(tr).data('id');

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, "_token": "{{ csrf_token() }}",},
                success: function (response) {
                    $(tr).remove();
                    $('.product-cart-item' + productId).remove();
                    $('.cartItems').text(response.itemsCount);

                    if (response.totalPrice) {
                        $('#totalPrice').text(response.totalPrice);
                    }

                    if (response.itemsCount == 0) {
                        $('.no-item-message').css('display', 'block');
                        $('.dropdown-wrapper').css('display', 'none');
                        window.location.href = '/';
                    }
                }
            });
        });

        $('.increaseQuantity').click(function (e) {
            var tr = $($(this).parent()).parent();
            var td = $(this).parent();
            var input = $(td).children()[1];
            var quantity = $(input).val();
            var price = (tr).data('price');
            var productId = $(tr).data('id');
            var stock = Number($(tr).data('stock'));

            var priceTd = $(tr).children()[5];

            if(isNaN(quantity)){
                location.reload();
            }
            quantity = Number(quantity);

            if (quantity < 0) {
                location.reload();
            }

            if (quantity == 0) {
                $(tr).remove();
            }

            if (Number(quantity + 1) > stock) {
                alert('Ne pare rau, nu exista destule produse de acest fel in stoc.');
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, 'quantity': quantity, 'type': 'increase', "_token": "{{ csrf_token() }}",},
                success: function (response) {
                    $(input).val(Number(quantity) + 1);

                    $(priceTd).text( (Number((Number(quantity) + 1) * Number(price)).toFixed(2)) + " Ron");

                    if (response.totalPrice) {
                        $('#totalPrice').text(response.totalPrice);
                    }
                }
            });
        });

        $('.decreaseQuantity').click(function (e) {
            var tr = $($(this).parent()).parent();
            var td = $(this).parent();
            var input = $(td).children()[1];
            var quantity = $(input).val();
            var price = (tr).data('price');
            var productId = $(tr).data('id');
            

            var priceTd = $(tr).children()[5];

            if(isNaN(quantity)){
                location.reload();
            }
            quantity = Number(quantity);

            
            if ((quantity - 1) < 0) {
                return;
            }

            if ((quantity - 1) == 0) {
                return;
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, 'quantity': quantity, 'type': 'decrease', "_token": "{{ csrf_token() }}",},
                success: function (response) {
                    $(input).val(Number(quantity) - 1);

                    $(priceTd).text( (Number((Number(quantity) - 1) * Number(price)).toFixed(2)) + " Ron");

                    if (response.totalPrice) {
                        $('#totalPrice').text(response.totalPrice);
                    }
                }
            });
        });
    </script>
@endsection