@extends('layouts.app')


@section('hero')
<div class="container-sm container">
    <div class="slider">
        <div class="bg-container">
            <img src="{{ asset('images/wallpaper4.jpg') }}">
            <div class="absolute">
                <h1><span class="power">POWER</span><span class="volt">VOLT</span><span class="mag">MAG</span>.RO</h1>
                <h2>Camere si sisteme de securitate.</h2>
                <h3>Suport tehnic si instalari la domiciliu.</h3>
            </div>
        </div>
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
                            <span class="new-price">{{ $product->new_price }} Ron</span>
                        </div>
                        <p style="margin: 0 auto;"><small>Pretul contine TVA</small></p>
                        <div class="buttons">
                            @if (\App\Cart::hasItem($product->id))
                                <button class="btn btn-danger btn-sm addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-trash"></i> <span>Elimina din Cos</span></button>
                            @else
                                <button class="btn btn-danger btn-sm addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-shopping-cart"></i> <span>Adauga in Cos</span></button>
                            @endif
                            <a href="{{ route('products.show', ['category' => $product->category->slug, 'product' => $product->slug]) }}" class="btn btn-info btn-sm">Detalii</a>
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
