<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Görev Düzenle</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Facebook Auto Poster</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">Görev Düzenle</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Görev Adı</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                   id="name" name="name" value="{{ old('name', $task->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="facebook_profile_id" class="form-label">Profil</label>
            <select class="form-select @error('facebook_profile_id') is-invalid @enderror"
                    id="facebook_profile_id" name="facebook_profile_id" required>
                <option value="">-- Profil Seçiniz --</option>
                @foreach($profiles as $profile)
                    <option value="{{ $profile->id }}"
                        {{ old('facebook_profile_id', $task->facebook_profile_id) == $profile->id ? 'selected' : '' }}>
                        {{ $profile->name }}
                    </option>
                @endforeach
            </select>
            @error('facebook_profile_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="content_id" class="form-label">İçerik</label>
            <select class="form-select @error('content_id') is-invalid @enderror"
                    id="content_id" name="content_id" required>
                <option value="">-- İçerik Seçiniz --</option>
                @foreach($contents as $content)
                    <option value="{{ $content->id }}"
                        {{ old('content_id', $task->content_id) == $content->id ? 'selected' : '' }}>
                        {{ $content->title }}
                    </option>
                @endforeach
            </select>
            @error('content_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Sayfalar</label>
            @foreach($pages as $page)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="page_ids[]"
                           value="{{ $page->id }}" id="page_{{ $page->id }}"
                           {{ in_array($page->id, old('page_ids', $task->pages->pluck('id')->toArray())) ? 'checked' : '' }}>
                    <label class="form-check-label" for="page_{{ $page->id }}">{{ $page->name }}</label>
                </div>
            @endforeach
            @error('page_ids')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Durum</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                <option value="scheduled" {{ old('status', $task->status) === 'scheduled' ? 'selected' : '' }}>Planlandı</option>
                <option value="processing" {{ old('status', $task->status) === 'processing' ? 'selected' : '' }}>İşleniyor</option>
                <option value="completed" {{ old('status', $task->status) === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                <option value="failed" {{ old('status', $task->status) === 'failed' ? 'selected' : '' }}>Başarısız</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="scheduled_at" class="form-label">Planlanan Tarih/Saat</label>
            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror"
                   id="scheduled_at" name="scheduled_at"
                   value="{{ old('scheduled_at', $task->scheduled_at ? $task->scheduled_at->format('Y-m-d\TH:i') : '') }}">
            @error('scheduled_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
