@extends('layouts.admin')
@section('title')
Les prix bas !
@stop

@section('stylesheets')
@stop

@section('head_javascripts')
@stop

@section('children')
<div class="container">
    <h2 class="text-center my-5">
        Images
        <a href="{{ route('images.create') }}" class="btn btn-outline-primary" alt="Créer" title="Créer">
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
    </h2>
    <table class="table table-striped table-sm table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">URL</th>
                <th scope="col">Alt</th>
                <th scope="col">Title</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @foreach ($images as $item)
            <tr>
                <th>
                    <a href="javascript:void(0)" class="btn btn-outline-warning" alt="Editer {{ $item->id }}" title="Editer {{ $item->id }}">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </a>
                </th>
                <td><img src="{{ $item->url }}" width="50" /></td>
                <td>{{ $item->alt }}</td>
                <td>{{ $item->title }}</td>
                <td>
                    <a href="javascript:void(0)" class="btn btn-outline-danger" alt="Supprimer" title="Supprimer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center mt-5">
    {{ $images->links('vendor.pagination.custom') }}
</div>
@stop

@section('body_javascripts')
@stop