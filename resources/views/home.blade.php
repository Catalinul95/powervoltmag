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
        <a href="#" class="btn btn-warning font-weight-bold"><i class="fas fa-question-circle"></i> Comanda si te contactam noi: 0725391572</a>
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
                            <span class="old-price">{{ $product->old_price }} lei</span>
                            <span class="new-price">{{ $product->new_price }} lei</span>
                        </div>
                        <div class="buttons">
                            <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-shopping-cart"></i> Adauga in Cos</a>
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


@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
@endsection