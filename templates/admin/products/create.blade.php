@extends('layouts.admin')
@section('title')
Les prix bas !
@stop

@section('stylesheets')
@stop

@section('head_javascripts')
@stop

@php
@endphp

@section('children')
<div class="container">
    <h2 class="text-center my-5">
        Ajouter un produit
    </h2>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="col-12">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nom du produit" />
                @error("name")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control w-100 @error('description') is-invalid @enderror" placeholder="Décrivez le produit en un paragraphe de 1000 caractères maximum"></textarea>
                @error("description")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Compléments d'information (liste énumérée)</label>
                <textarea name="more_infos" class="form-control w-100" placeholder="Entrez de petites phrases séparées par des point-virgules"></textarea>
                @error("more_infos")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Prix</label>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="0,00" />
                @error("price")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror   
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label>Marque</label>
                <select name="brand" class="form-control" >
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">
                        {{ $brand->name }}
                    </option>
                @endforeach
                </select>
                @error("brand")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-center mb-5">
                <button type="submit" class="btn btn-outline-primary">Valider</button>
            </div>
        </div>
    </form>
</div>
@stop