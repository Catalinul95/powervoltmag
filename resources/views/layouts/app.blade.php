<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PowerVoltMag.ro | Camere de securitate | Instalari sisteme de securitate</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top py-3">
            <div class="container">
            <a class="navbar-brand" href="/">PowerVoltMag.ro</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="col-md-6 py-1 px-2 px-md-0 ml-md-5">
                <input class="form-control form-control-dark" type="text" placeholder="Search here..." aria-label="Search">
            </div>

            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Acasa <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contul Meu</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link cart-link" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-shopping-cart" style="color: red;"></i> <span class="cartItems">
                        <span>{{ App\Cart::countItems() }}</span>
                    </span> Cosul Meu
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-wrapper">
                            @if (App\Cart::countItems())
                                @foreach (App\Cart::getItems() as $product)
                                    <div class="dropdown-item product-cart-item{{$product['id']}}">
                                        <span class="smallIconRemoveFromCart" data-id="{{ $product['id'] }}"><i class="fas fa-trash" aria-hidden="true"></i></span>
                                        <a href="#" class="btn-block" style="color: #222; text-decoration: none;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img src="{{ Storage::url('/' . $product['image']) }}" style="width: 50px; height: 50px;">
                                                </div>
                                                <div class="col-md-9" style="width: 350px;">
                                                    <div class="d-flex flex-column">
                                                        <span style=" white-space: pre-wrap; font-weight: 500;">{{ $product['title'] }}</span>
                                                        <p>1 X <strong>{{ $product['price'] }}</strong></p>
                                                    </div>
                                                </div>      
                                            </div> 
                                        </a>      
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <p class="dropdown-item no-item-message" @if (App\Cart::countItems()) style="display: none;" @endif>Cosul tau este gol.</p>
                        @php $product = null @endphp
                        <div class="dropdown-divider"></div>
                        <div class="dropdown-item">
                        <a class="btn btn-danger btn-block btn-sm" href="#">Cosul Meu</a>
                        </div>
                    </div>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </nav>

        @yield('hero')

        <main class="py-md-4 py-sm-0">
            @yield('content')
        </main>

    <footer class="page-footer font-small blue pt-4">
        <div class="container text-center text-md-left">
            <div class="row">
            <div class="col-md-6 mt-md-0 mt-3">

                <!-- Content -->
                <h5 class="text-uppercase">PowerVoltMag.ro</h5>
                <p>This is just some random text for demo purpose.</p>

            </div>
            <hr class="clearfix w-100 d-md-none pb-3">
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled">
                <li>
                    <a href="#!">Link 1</a>
                </li>
                <li>
                    <a href="#!">Link 2</a>
                </li>
                <li>
                    <a href="#!">Link 3</a>
                </li>
                <li>
                    <a href="#!">Link 4</a>
                </li>
                </ul>

            </div>
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase">Links</h5>

                <ul class="list-unstyled">
                <li>
                    <a href="#!">Link 1</a>
                </li>
                <li>
                    <a href="#!">Link 2</a>
                </li>
                <li>
                    <a href="#!">Link 3</a>
                </li>
                <li>
                    <a href="#!">Link 4</a>
                </li>
                </ul>

            </div>
            </div>
        </div>
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="https://mdbootstrap.com/"> POWERVOLTMAG.Ro</a>
        </div>
    </footer>


    

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a5271ecd44.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $('#categoriesButton').click(function (e) {
            if ($($(this).children()[0]).hasClass('fas fa-chevron-down')) {
                $($(this).children()[0]).attr('class', 'fas fa-chevron-up');
            } else {
                $($(this).children()[0]).attr('class', 'fas fa-chevron-down');
            }
            
            $('#categoriesBody').toggle();
        });

        $('#filtersButton').click(function (e) {
            if ($($(this).children()[0]).hasClass('fas fa-chevron-down')) {
                $($(this).children()[0]).attr('class', 'fas fa-chevron-up');
            } else {
                $($(this).children()[0]).attr('class', 'fas fa-chevron-down');
            }
            
            $('#filtersBody').toggle();
        });

        $(document).ready(function(){
            $('.slider').slick({
                nextArrow: '<button class="nextArrow"><i class="fas fa-chevron-right"></i></button>',
                prevArrow: '<button class="prevArrow"><i class="fas fa-chevron-left"></i></button>',
                arrows: false,
                infinite: true,
                autoplay: true,
            });
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
    </script>
    @yield('scripts')
</body>
</html>
