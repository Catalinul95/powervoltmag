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
                    @if (!is_null($cart))
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
        </div>
        <div class="col-md-4">
            <div class="card login-card">
                <div class="card-header login-card-header">Sumar Comanda</div>
                <div class="card-body">
                    <h5>Cost Livrare: <strong style="color: #EA2027;">15.00 Ron</strong></h5>
                    <hr>
                    <h5>
                        <span>TOTAL( TVA inclus ):</span> <strong style="color: #EA2027;">
                            @php $total = 0; @endphp
                            @foreach ($cart as $key => $item)
                                @php $total += $item['price'] * $item['quantity']; @endphp
                            @endforeach
                            {{ number_format($total + ( $total / 100 * 19), 2) }}
                        </strong>
                    </h5>
                </div>
            </div>
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

            if (quantity < 0) {
                location.reload();
            }

            if (quantity == 0) {
                $(tr).remove();
            }

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, 'quantity': quantity, 'type': 'decrease', "_token": "{{ csrf_token() }}",},
                success: function (response) {
                    $(input).val(Number(quantity) - 1);

                    $(priceTd).text( (Number((Number(quantity) - 1) * Number(price)).toFixed(2)) + " Ron");
                }
            });

            console.log(input);
        });
    </script>
@endsection