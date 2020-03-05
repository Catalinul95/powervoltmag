@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
@endsection

@section('hero')
<div class="container-sm container">
    <div class="slider">
        <div><img src="https://cdn.spy-shop.ro/media/wysiwyg/bannere/concurs-newsletter-subs-NEW.jpg"></div>
        <div><img src="https://cdn.spy-shop.ro/media/wysiwyg/bannere/concurs-newsletter-subs-NEW.jpg"></div>
        <div><img src="https://cdn.spy-shop.ro/media/wysiwyg/bannere/concurs-newsletter-subs-NEW.jpg"></div>
    </div>
    <div class="details-bar">
        <div class="details-item"><i class="fas fa-truck-moving"></i> <span>Transport gratuit la comenzi > 500 Lei</span></div>
        <div class="details-item"><i class="fas fa-cog"></i> <span>Instalare oriunde in Romania</span></div>
        <div class="details-item"><i class="fas fa-headset"></i> <span>Suport Tehnic gratuit</span></div>
    </div>
    <div class="products-callus hideDesktop">
        <a href="#" class="btn btn-warning btn-block font-weight-bold"><i class="fas fa-question-circle"></i> Comanda si te contactam noi: 0725391572</a>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row">
    <div class="col-md-3">
        <div class="card categories-card">
        <div class="card-header categories-card-header" id="categoriesButton">
            Categorii <i class="fas fa-chevron-down" aria-hidden="true"></i>
        </div>
        <div class="card-body categories-card-body" id="categoriesBody">
            <ul class="list-group list-group-flush categories">
            @foreach ($categories as $category)
                <li class="list-group-item category">
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a> <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    @if ($category->hasSubCategories())
                        <div class="custom-dropdown">
                            <ul class="list-group list-group-flush">
                                @foreach ($category->subCategories() as $subCategory)
                                    <li class="list-group-item category">
                                        <a href="{{ route('products.index', ['category' => $category->slug]) }}">{{ $subCategory->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
            @endforeach
            </ul>
        </div>
        </div>
    </div>
    <div class="col-md-9 products-wrapper">
        <div class="products-callus hideMobile">
        <a href="#" class="btn btn-warning font-weight-bold"><i class="fas fa-question-circle"></i> Comanda si te contactam noi: 07XXXXXXXX</a>
        </div>
        <div class="card products-card">
            <div class="card-header products-card-header">
                <img src="images/camerax.png"> Cele Mai Recente Produse
            </div>
            <div class="card-body products-card-body">
            @if (count($products))
                @foreach ($products as $product)
                    <div class="product">
                            <img src="{{ Storage::url('/' . $product->getImages()[0]) }}">
                        <h2>{{ $product->title }}</h2>
                        <div class="price">
                            @if ($product->old_price) <span class="old-price">{{ $product->old_price }} lei</span> @endif
                            <span class="new-price">{{ $product->new_price }} lei</span>
                        </div>
                        <div class="buttons">
                            @if (\App\Cart::hasItem($product->id))
                                <button class="btn btn-danger btn-sm addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-trash"></i> <span>Elimina din Cos</span></button>
                            @else
                                <button class="btn btn-danger btn-sm addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-shopping-cart"></i> <span>Adauga in Cos</span></button>
                            @endif
                            
                            <a href="{{ route('products.show', ['category' => $category->slug, 'product' => $product->slug]) }}" class="btn btn-info btn-sm">Detalii</a>
                        </div>
                    </div>
                @endforeach
            @else 
                <p>Momentan nu exista produse adaugate.</p>
            @endif
            </div>
        </div>
    </div>
    </div>
</div>
@endsection


@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

    <script>
        $('.addToCartButton').click(function (e) {
            var productId = $(this).data('id');
            var self = this;

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, "_token": "{{ csrf_token() }}",},
                success: function (response) {
                    var child = $(self).children()[0];
                    var child1 = $(self).children()[1];

                    if ($(child).attr('class') == 'fas fa-trash') {
                        $(child).attr('class', 'fas fa-shopping-cart');
                        $(child1).text('Adauga in Cos');

                        $('.product-cart-item' + productId).remove();
                    } else {
                        $(child).attr('class', 'fas fa-trash');
                        $(child1).text('Elimina din Cos');
                        $('.no-item-message').css('display', 'none');
                    }

                    if (response.itemsCount == 0) {
                        $('.no-item-message').css('display', 'block');
                    }

                    $('.cartItems').text(response.itemsCount);
                },
                dataType: 'json',
            });
        });

        $('.smallIconRemoveFromCart').click(function (e) {
            var productId = $(this).data('id');
            var self = this;

            $.ajax({
                type: 'POST',
                url: "{{ route('cart.store') }}",
                data: {'id': productId, "_token": "{{ csrf_token() }}",},
                success: function (response) {   
                    var product = $('.product' + productId);
                    var child = $(product).children()[0];
                    var child1 = $(product).children()[1];

                    if ($(child).attr('class') == 'fas fa-trash') {
                        $(child).attr('class', 'fas fa-shopping-cart');
                        $(child1).text('Adauga in Cos');
                        $('.product-cart-item' + productId).remove();
                    } else {
                        $(child).attr('class', 'fas fa-trash');
                        $(child1).text('Elimina din Cos');
                        $('.no-item-message').css('display', 'none');
                    }

                    if (response.itemsCount == 0) {
                        $('.no-item-message').css('display', 'block');
                    }


                    $('.cartItems').text(response.itemsCount);
                },
                dataType: 'json',
            });
        });
    </script>
@endsection