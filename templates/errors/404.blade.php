@extends('layouts.app')
@section('title')
Les prix bas !
@stop

@section('stylesheets')
@stop

@section('head_javascripts')
@stop

@section('children')
<div class="container">
    <div class="row my-5 justify-content-center">
        <h1 class="text-center">
            Oops!<br /> Nous n'avons pas ce produit en magasin...
        </h1>
    </div>

    <div class="row   justify-content-center">
        
        <img src="/assets/images/lesprixbas_404.webp" width="500" height="500" alt="404 page not found" />
    </div>
</div>
@stop

@section('body_javascripts')
@stop