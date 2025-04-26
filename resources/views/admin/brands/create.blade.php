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
        Ajouter une marque
    </h2>
    <form method="POST" action="{{ route('brands.store') }}">
        @csrf
        <div class="col-12">
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="name" class="form-control" placeholder="Nom de la marque" />
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