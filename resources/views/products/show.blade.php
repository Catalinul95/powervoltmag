@extends('layouts.app')

@section('styles')
<link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
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
                <ul class="list-group list-group-flush categories">
                @foreach ($categories as $categoryItem)
                    <li class="list-group-item category" @if ($category->slug == $categoryItem->slug || $category->parent_category_id == $categoryItem->id) style="background-color: #ffc107;" @endif>
                        <a href="{{ route('products.index', ['category' => $categoryItem->slug]) }}">{{ $categoryItem->name }}</a> <i class="fas fa-chevron-right" aria-hidden="true"></i>
                        @if ($categoryItem->hasSubCategories())
                            <div class="custom-dropdown">
                                <ul class="list-group list-group-flush">
                                    @foreach ($categoryItem->subCategories() as $subCategory)
                                        <li class="list-group-item category" @if ($category->slug == $subCategory->slug) style="background-color: #ffc107;" @endif><a href="{{ route('products.index', ['category' => $subCategory->slug]) }}">{{ $subCategory->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </li>
                @endforeach
                </ul>
                </ul>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="card products-card products-page-card">
            <div class="card-header products-page-card-header">
                <a href="/"><i class="fa fa-home" aria-hidden="true"></i></a>
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                <a href="/{{ $category->slug }}">{{ $category->name }}</a>
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                <a href="/{{ $category->slug }}/{{ $product->slug }}">{{ $product->title }}</a>
            </div>
            <div class="card-body">
                <div class="row product-details">
                    <div class="col-md-5">
                        <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
                            @foreach ($product->getImages() as $image)
                                <img src="{{ Storage::url('/' . $image) }}">
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h1>{{ $product->title }}</h1>
                        <div class="details-wrapper">
                            <p>Producator: <strong>{{ $product->manufacturer }}</strong></p>
                            <p>Cod produs: <strong>{{ $product->product_code }}</strong></p>
                            <p>
                                {!! $product->short_description !!}
                            </p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 price-details">
                                @if ($product->old_price) <p class="old-price">{{ $product->old_price }} Lei</p> @endif
                                <p class="new-price">{{ $product->new_price }} Lei</p>
                                <p><small>Pretul include TVA.</small></p>
                                <p class="stock-status">In stoc <i class="fas fa-thumbs-up"></i></p>       
                            </div>
                            <div class="col-md-6">
                                <div class="product-tools">
                                    @if (\App\Cart::hasItem($product->id))
                                    <button class="btn btn-danger mb-2 addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-trash"></i> <span>Elimina din Cos</span></button>
                                    @else 
                                    <button class="btn btn-danger mb-2 addToCartButton product{{$product->id}}" data-id="{{ $product->id }}"><i class="fas fa-shopping-cart"></i> <span>Adauga in Cos</span></button>
                                    @endif
                                    <button class="btn btn-secondary"><i class="fas fa-cog"></i> Vreau Instalare</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="details-bar" style="border-top: 1px solid #f1f1f1;">
                <div class="details-item"><i class="fas fa-truck-moving"></i> <span>Transport gratuit la comenzi > 500 Lei</span></div>
                <div class="details-item"><i class="fas fa-cog"></i> <span>Instalare oriunde in Romania</span></div>
                <div class="details-item"><i class="fas fa-headset"></i> <span>Suport Tehnic gratuit</span></div>
              </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header product-description-header tabs">
                  <span class="tab tab1 active">Descriere</span>
                  <span class="tab tab2">Documentatie</span>
                </div>
                <div class="card-body">
                  <div id="tab1" class="tab-body">{!! $product->description !!}</div>
                  <div id="tab2" class="tab-body">ssds2</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
  <script>
    $('#categoriesButton').click(function (e) {
      if ($($(this).children()[0]).hasClass('fas fa-chevron-down')) {
        $($(this).children()[0]).attr('class', 'fas fa-chevron-up');
      } else {
        $($(this).children()[0]).attr('class', 'fas fa-chevron-down');
      }
      
      $('#categoriesBody').toggle();
    });

    $('.category').click(function (e) {
      if ($( window ).width() <= 750) {
        var dropdown = $(this).children()[2];

        var dropdowns = $('.custom-dropdown');

        if ($(dropdown).css('display') == 'block') {
          $(dropdown).css('display', 'none');
        } else {
          for (var i = 0; i < dropdowns.length; i++) {
            $(dropdowns[i]).css('display', 'none');
          }

          $(dropdown).css('display', 'block');
          $(this).css('background-color', '#fff');
        }
      }
    
    });

    $(document).ready(function () {
      var tabs = $('.tabs').children();

      for (var i = 0; i < tabs.length; i++) {
          if ($(tabs[i]).hasClass('active')) {
              var tab = tabs[i];
              var tabBody = $('#'+tab.className.split(' ')[1]);
              tabBody.css('display', 'block');
          }
      }

      $('.tab').on('click', function (e) {
          for (var i = 0; i < tabs.length; i++) {
              var tab = tabs[i];
              $(tabs[i]).removeClass('active');
              var tabBody = $('#'+tab.className.split(' ')[1]);
              tabBody.css('display', 'none');
          }

          $(this).addClass('active');
          $('#'+$(this).attr('class').split(' ')[1]).css('display', 'block');
      });
  });
  </script>

  @endsection