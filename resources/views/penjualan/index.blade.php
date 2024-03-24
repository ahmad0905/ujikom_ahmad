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
        <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Penjualan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <a href="javascript:void(0)" class="btn btn-success mb-2" id="btn-create-penjualan">TAMBAH</a>
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">


                            <thead>
                                <tr>
                                    <th>Tanggal penjualanan</th>
                                    <th>Total Harga</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-penjualans">
                                @foreach($penjualans as $penjualan)
                                <tr id="index_{{ $penjualan->id }}">
                                    <td>{{ $penjualan->tanggal_penjualanan }}</td>
                                    <td>{{ $penjualan->total_harga }}</td>
                                    <td>{{ optional($penjualan->user)->name }}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" id="btn-edit-penjualan" data-id="{{ $penjualan->id }}" class="btn btn-primary btn-sm">EDIT</a>
                                        <a href="javascript:void(0)" id="btn-delete-penjualan" data-id="{{ $penjualan->id }}" class="btn btn-danger btn-sm">DELETE</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
    </table>
                            </div>
                        </div>
                    </div>

                </div>
    <!-- @include('penjualan.create') --> 
    @include('penjualan.edit') 
    @include('penjualan.delete')
    @endsection
</body>
</html>