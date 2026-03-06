<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Gösterge Paneli</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Facebook Auto Poster</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" href="{{ route('dashboard') }}">Gösterge</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('profiles.index') }}">Profiller</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('pages.index') }}">Sayfalar</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contents.index') }}">İçerikler</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('tasks.index') }}">Görevler</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('proxies.index') }}">Proxy</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Gösterge Paneli</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Toplam Görev</h5>
                    <p class="card-text fs-2">{{ $totalTasks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Tamamlanan Görev</h5>
                    <p class="card-text fs-2">{{ $completedTasks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Bekleyen Görev</h5>
                    <p class="card-text fs-2">{{ $pendingTasks }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Toplam Gönderi</h5>
                    <p class="card-text fs-2">{{ $totalPosts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h5 class="card-title">Toplam Yorum</h5>
                    <p class="card-text fs-2">{{ $totalComments }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
