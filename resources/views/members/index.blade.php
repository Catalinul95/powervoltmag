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
                <a href="{{ route('members.index') }}">Contul meu</a>
            </div>
            <div class="card-body">
                <h1><i class="fas fa-user"></i> Contul Meu</h1>
                <hr>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <form action="{{ route('members.update') }}" method="POST">
                @method('PATCH')
                @csrf
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
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="inputAddress" placeholder="Email..." value="{{ $user->email }}">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="phone">Telefon</label>
                          <input type="text" name="phone" class="form-control" id="inputPassword4" placeholder="Numar telefon..." value="{{ $user->phone }}">
                        </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                          <label for="password">Parola Mea</label>
                          <input type="password" name="password" class="form-control" id="inputAddress" placeholder="Parola...">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="new_password">Parola Noua</label>
                        <input type="password" name="new_password" class="form-control" id="inputPassword4" placeholder="Parola noua...">
                      </div>
                  </div>
                    <div class="form-group">
                        <input type="radio" name="individual" value="on"  @if ($user->individual) checked @endif> <label for="">Persoana Fizica</label>
                        <input type="radio" name="individual" value="off" @if (!$user->individual) checked @endif> <label for="">Persoana Juridica</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifica</button>
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