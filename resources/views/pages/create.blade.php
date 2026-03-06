<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Sayfa Oluştur</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Facebook Auto Poster</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Yeni Sayfa Oluştur</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pages.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="profile_id" class="form-label">Profil</label>
            <select class="form-select @error('profile_id') is-invalid @enderror"
                    id="profile_id" name="profile_id" required>
                <option value="">-- Profil Seçiniz --</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}" {{ old('profile_id') == $profile->id ? 'selected' : '' }}>
                        {{ $profile->name }}
                    </option>
                @endforeach
            </select>
            @error('profile_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="page_id" class="form-label">Sayfa ID</label>
            <input type="text" class="form-control @error('page_id') is-invalid @enderror"
                   id="page_id" name="page_id" value="{{ old('page_id') }}" required>
            @error('page_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Sayfa Adı</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="access_token" class="form-label">Erişim Tokeni</label>
            <input type="text" class="form-control @error('access_token') is-invalid @enderror"
                   id="access_token" name="access_token" value="{{ old('access_token') }}">
            @error('access_token')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Oluştur</button>
            <a href="{{ route('pages.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
