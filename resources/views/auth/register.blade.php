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
                <a href="#">Creare Cont</a>
            </div>
            <div class="card-body">
            <h1><i class="fas fa-user-plus"></i> Creare Cont</h1>
                <hr>
                <form action="{{ route('register') }}" method="POST">
                @csrf
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Nume</label>
                        <input type="text" name="first_name" class="form-control" id="inputEmail4" placeholder="Nume...">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword4">Prenume</label>
                        <input type="text" name="last_name" class="form-control" id="inputPassword4" placeholder="Prenume...">
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAddress">Email</label>
                            <input type="email" name="email" class="form-control" id="inputAddress" placeholder="Email...">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Telefon</label>
                          <input type="text" name="phone" class="form-control" id="inputPassword4" placeholder="Numar telefon...">
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="inputAddress">Parola</label>
                          <input type="password" name="password" class="form-control" id="inputAddress" placeholder="Parola...">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword4">Confirma Parola</label>
                        <input type="password" name="password_confirmation" class="form-control" id="inputPassword4" placeholder="Confirma Parola...">
                      </div>
                  </div>
                    <button type="submit" class="btn btn-primary">Inregistrare</button>
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