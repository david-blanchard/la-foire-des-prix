@extends('layouts.admin')
@section('title')
LesPrixBas Admin UI
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
        Produits
        <a href="{{ route('products.create') }}" class="btn btn-outline-primary" alt="Créer" title="Créer">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    </h2>
    <table class="table table-striped table-hover table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Détails</th>
                <th scope="col">Prix</th>
                <th scope="col">Marque</th>
                <th scope="col">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $item)
            <tr>
                <th>
                    <a href="{{ route('products.edit', $item->id) }}" class="btn btn-outline-warning" alt="Editer {{ $item->id }}" title="Editer {{ $item->id }}">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                </th>
                <td>
                    <a href="{{ route("product", $item->slug) }}" title="Tester le produit" >
                    {{ $item->name }}
                    </a>
                </td>
                <td>
                    <a href="{{ route("product", $item->slug) }}" title="Tester le produit" >
                    {{ $item->description }}
                    </a>
                </td>
                @php
                    $infos = explode(';', $item->more_infos);
                @endphp
                <td>
                    <ul>
                    @foreach($infos as $detail) 
                    <li>
                        {{ $detail }}
                    </li>
                    @endforeach
                    </ul>
                </td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->brand }}</td>
                <td>
                    <button type="button"
                        class="btn btn-outline-danger"
                        onclick="document.querySelector('#delete-modal-{{ $item->id }}').style.display='block'"
                    >
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method("DELETE")
                        <div id="delete-modal-{{ $item->id }}" class="modal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Attention: la suppression est définitive</h5>
                                    <button type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Fermer"
                                        onclick="document.querySelector('#delete-modal-{{ $item->id }}').style.display='none'"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Voulez-vous vraiment supprimer "{{ $item->name }}" ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" 
                                        class="btn btn-secondary" 
                                        data-dismiss="modal"
                                        onclick="document.querySelector('#delete-modal-{{ $item->id }}').style.display='none'"
                                    >
                                        Annuler
                                    </button>
                                    <button type="submit" class="btn btn-primary">Supprimer</button>
                                </div>
                                </div>
                            </div>
                        </div>

             
                    </form>
                </td>
            </tr>
            @endforeach
        </thead>
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-5">
    {{ $products->links('vendor.pagination.custom') }}
</div>
@stop

@section('body_javascripts')
@stop