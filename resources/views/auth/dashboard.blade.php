<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <title>Dashboard</title>
</head>
<body>

<div class="container" style="margin-top: 25px">
    <div class="row">
    
        <div class="col-md-2">
            <ul class="list-group">
                <li class="list-group-item active">MAIN MENU</li>
                <a href="{{ route('dashboard.index') }}" class="list-group-item" style="color: #212529;">Dashboard</a>
                <li class="list-group-item">Profile</li>
                <a href='/produk' class="list-group-item" style="color: #212529;">Produk</a>
                <a href='/user' class="list-group-item" style="color: #212529;">User</a>
                <a href='/penjualan' class="list-group-item" style="color: #212529;">penjualan</a>
                <a href='/kasir' class="list-group-item" style="color: #212529;">kasir</a>
                <a href='/detail_penjualan' class="list-group-item" style="color: #212529;">detail</a>
                <a href='/transaksi' class="list-group-item" style="color: #212529;">Transaksi</a>
                <div> </div>
                <a href="{{ route('dashboard.logout') }}" class="list-group-item" style="color: #212529;">Logout</a>
            </ul>
        </div>

        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    @yield('content')
                    

                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
</body>
</html>