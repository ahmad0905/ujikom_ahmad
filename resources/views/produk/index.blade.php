<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Toko Ahmad</title>
    <style>
        body {
            background-color: lightgray !important;
        }

    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@extends('layouts.dashboard')
<body>
@section('content')
   <!-- Page Heading -->
   <h1 class="h3 mb-2 text-gray-800">Data Produk</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6> -->
        <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-produk">TAMBAH</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th>Nama Produk</th>
                    
                        <th>Deskripsi</th>
                        <th>image</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-produks">
                    @foreach($produks as $produk)
                    <tr id="index_{{ $produk->id }}">
                        <td>{{ $produk->nama }}</td>
                        
                        <td>{{ $produk->deskripsi }}</td>
                        <td>
                        <img src="{{ asset('image/' . $produk->image) }}" class="img-fluid" width="150px">
                        </td>
                        <td>{{ number_format ($produk->harga) }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-produk" data-id="{{ $produk->id }}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-produk" data-id="{{ $produk->id }}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    @include('produk.create')
    @include('produk.edit')
    @include('produk.delete')
    @endsection
</body>
</html>