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
    <div class="products-callus w-100 hideDesktop">
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
            </div>
        </div>
        @if (count($products))
        <div class="card categories-card">
            <div class="card-header categories-card-header" id="filtersButton">
                Filtreaza dupa <i class="fas fa-chevron-down" aria-hidden="true"></i>
            </div>
            <div class="card-body" id="filtersBody">
                <div class="form-group">
                    <label for="control-label">Rezolutie</label>
                    <select name="rezolutie" id="" class="form-control">
                        <option selected>NA</option>
                        <option  @if (isset($filters->rezolutie) && $filters->rezolutie == 'hd-720p-(1-mp)') selected @endif value="hd-720p-(1-mp)">HD 720p (1 Mp)</option>
                        <option @if (isset($filters->rezolutie) && $filters->rezolutie == 'full-hd-1080p-(2---2.4-mp)') selected @endif value="full-hd-1080p-(2---2.4-mp)">FULL HD 1080p (2 - 2.4 Mp)</option>
                        <option @if (isset($filters->rezolutie) && $filters->rezolutie == '4-megapixeli-(2k)') selected @endif value="4-megapixeli-(2k)">4 Megapixeli (2K)</option>
                        <option @if (isset($filters->rezolutie) && $filters->rezolutie == '5-megapixeli-(2k)') selected @endif value="5-megapixeli-(2k)">5 Megapixeli (2K) </option>
                        <option @if (isset($filters->rezolutie) && $filters->rezolutie == '8-megapixeli-(4k)') selected @endif value="8-megapixeli-(4k)">8 Megapixeli (4K) </option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Infrarosu</label>
                    <select name="infrarosu" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '10-metri') selected @endif value="10-metri">10 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '20-metri') selected @endif value="20-metri">20 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '30-metri') selected @endif value="30-metri">30 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '40-metri') selected @endif value="40-metri">40 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '50-metri') selected @endif value="50-metri">50 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '60-metri') selected @endif value="60-metri">60 Metri</option>
                        <option @if (isset($filters->infrarosu) && $filters->infrarosu == '80-metri') selected @endif value="80-metri">80 Metri</option>    
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Tip Camera</label>
                    <select name="tip-camera" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'dome') selected @endif  value="dome">Dome</option>
                        <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'bullet') selected @endif  value="bullet">Bullet</option>
                        <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'speed-demo') selected @endif  value="speed-dome">Speed dome</option>
                        <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'zoom-motorizat') selected @endif  value="zoom-motorizat">Zoom motorizat</option>  
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Tehnologie</label>
                    <select name="tehnologie" id="" class="form-control">
                    <option selected>NA</option>
                        <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'hdcvi') selected @endif value="hdcvi">HDCVI</option>
                        <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'turbo-hd') selected @endif value="turbo-hd">Turbo HD</option>
                        <option @if (isset($filters->tehnologie) &&  $filters->tehnologie == 'ip') selected @endif value="ip">IP</option>
                        <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'cvi-/-ahd-/-turbo-hd-/-analog') selected @endif value="cvi-/-ahd-/-turbo-hd-/-analog">CVI / AHD / TURBO HD / ANALOG</option>
                        <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'turbo-hd-/-ahd-/-analog') selected @endif value="turbo-hd-/-ahd-/-analog">TURBO HD / AHD / ANALOG</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Lentila Varifocala</label>
                    <select name="lentila-varifocala" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,8---12-mm') selected @endif  value="2,8---12-mm">2,8 - 12 mm</option>
                        <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,8---10-mm') selected @endif  value="2,8---10-mm">2,8 - 10 mm</option>
                        <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,7---13,5-mm') selected @endif  value="2,7---13,5-mm">2,7 - 13,5 mm</option>
                        <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,7---12-mm') selected @endif  value="2,7---12-mm">2,7 - 12 mm</option>
                        <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '4,3---129-mm') selected @endif  value="4,3---129-mm">4,3 - 129 mm</option>                                 
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Lentila fixa</label>
                    <select name="lentila-fixa" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == '2.8-mm') selected @endif value="2.8-mm">2.8 mm</option>
                        <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == '3.6-mm') selected @endif value="3.6-mm">3.6 mm</option>
                        <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == 'fisheye') selected @endif value="fisheye">FISHEYE</option>                             
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Nr canale</label>
                    <select name="nr-canale" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '4') selected @endif value="4">4</option>
                        <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '8') selected @endif value="8">8</option>
                        <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '16') selected @endif value="16">16</option>
                        <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '32') selected @endif value="32">32</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Internet</label>
                    <select name="internet" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->internet) && $filters->internet == 'ip-dinamic') selected @endif value="ip-dinamic">IP Dinamic (DDNS)</option>
                        <option @if (isset($filters->internet) && $filters->internet == 'cloud') selected @endif value="cloud">CLOUD</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Nr HDD</label>
                    <select name="nr-hdd" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '1-hdd') selected @endif value="1-hdd">1 HDD</option>
                        <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '2-hdd') selected @endif value="2-hdd">2 HDD</option>
                        <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '4-hdd') selected @endif value="4-hdd">4 HDD</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Poc</label>
                    <select name="poc" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->poc) && $filters->poc == 'da') selected @endif value="da">Da</option>
                        <option @if (isset($filters->poc) && $filters->poc == 'nu') selected @endif value="nu">Nu</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Starlight/Starvis</label>
                    <select name="starlight-starvis" id="" class="form-control">
                        <option selected>NA</option>
                        <option  @if (isset($filters->{"starlight-starvis"}) && $filters->{"starlight-starvis"} == 'da') selected @endif value="da">Da</option>
                        <option  @if (isset($filters->{"starlight-starvis"}) && $filters->{"starlight-starvis"} == 'nu') selected @endif value="nu">Nu</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Intrari Audio</label>
                    <select name="intrari-audio" id="" class="form-control">
                        <option selected>NA</option>
                        <option  @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '1-intrare') selected @endif value="1-intrare">1 intrare</option>
                        <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '4-intrari') selected @endif  value="4-intrari">4 intrari</option>
                        <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '8-intrari') selected @endif  value="8-intrari">8 intrari</option>
                        <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '16-intrari') selected @endif  value="16-intrari">16 intrari</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Audio prin Coaxial</label>
                    <select name="audio-prin-coaxial" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->{"audio-prin-coaxial"}) && $filters->{"audio-prin-coaxial"} == 'audio-prin-hdcvi') selected @endif value="audio-prin-hdcvi">Audio prin HDCVI</option>
                        <option @if (isset($filters->{"audio-prin-coaxial"}) && $filters->{"audio-prin-coaxial"} == 'audio-prin-hdtvi') selected @endif value="audio-prin-hdtvi">Audio prin HDTVI</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Conexiune</label>
                    <select name="conexiune" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->conexiune) && $filters->conexiune == 'wireless') selected @endif value="wirless">Wireless</option>
                        <option @if (isset($filters->conexiune) && $filters->conexiune == 'cablu') selected @endif value="cablu">Cablu</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Material</label>
                    <select name="material" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->material) && $filters->material == 'plastic') selected @endif value="plastic">Plastic</option>
                        <option @if (isset($filters->material) && $filters->material == 'metal') selected @endif value="metal">Metal</option>                                  
                    </select>
                </div>

                <div class="form-group">
                    <label for="control-label">Utilizare</label>
                    <select name="utilizare" id="" class="form-control">
                        <option selected>NA</option>
                        <option @if (isset($filters->utilizare) && $filters->utilizare == 'interior') selected @endif value="interior">Interior</option>
                        <option @if (isset($filters->utilizare) && $filters->utilizare == 'exterior') selected @endif value="exterior">Exterior</option>
                        <option @if (isset($filters->utilizare) && $filters->utilizare == 'mixt') selected @endif value="mixt">Mixt</option>
                        
                    </select>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="col-md-9 products-wrapper">
        
        <div class="products-callus hideMobile">
            <a href="#" class="btn btn-warning font-weight-bold"><i class="fas fa-question-circle"></i> Comanda si te contactam noi: 07XXXXXXXX</a>
        </div>
        <div class="card products-card">
            <div class="card-header products-card-header">
                <img src="/images/camerax.png"> Lista Produse
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
        $('select').change(function (e) {
            var name = $(this).attr('name');
            var value = $(this).val();

            var url = "/{{ $category->slug }}/filtre";

            @if (Str::contains(Request::url(), 'filtre'))
                $('select').each(function () {
                    if (this.value != "NA") {
                        name = this.name;
                        value = this.value;

                        url += '/' + name + ':' + value;
                    }

                    
                });

                $(location).attr('href', url);
            @else
                $(location).attr('href', "/" + "{{ $category->slug }}" + "/filtre/" + name + ':' + value);
            @endif

           
        })

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

