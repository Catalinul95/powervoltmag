@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
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
                <li class="list-group-item category">
                    <a href="{{ route('products.index', ['category' => $categoryItem->slug]) }}">{{ $categoryItem->name }}</a> <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    @if ($categoryItem->hasSubCategories())
                        <div class="custom-dropdown">
                            <ul class="list-group list-group-flush">
                                @foreach ($categoryItem->subCategories() as $subCategory)
                                    <li class="list-group-item category"><a href="{{ route('products.index', ['category' => $subCategory->slug]) }}">{{ $subCategory->name }}</a></li>
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
    <div class="col-md-9">
    <div class="card login-card">
            <div class="card-header login-card-header">
                <a href="#"><i class="fa fa-home" aria-hidden="true"></i></a>
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                <a href="#">Autentificare</a>
            </div>
            <div class="card-body">
                <h1><i class="fas fa-sign-in-alt"></i> Autentificare</h1>
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Autentificare</button>
                    <div class="mt-2"><a href="{{ route('register') }}">Inca nu ai un cont?</a></div>
                    <div><a href="{{ route('password.request') }}">Ai uitat parola?</a></div>
                </form>
            </div>
          </div>
    </div>
    </div>
</div>
@endsection


@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
@endsection