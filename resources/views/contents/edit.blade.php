<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <title>İçerik Düzenle</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Facebook Auto Poster</a>
    </div>
</nav>

<div class="container mt-4">
    <h1 class="mb-4">İçerik Düzenle</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contents.update', $content) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Başlık</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror"
                   id="title" name="title" value="{{ old('title', $content->title) }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Metin</label>
            <textarea class="form-control @error('text') is-invalid @enderror"
                      id="text" name="text" rows="5" required>{{ old('text', $content->text) }}</textarea>
            @error('text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="media_type" class="form-label">Medya Türü</label>
            <select class="form-select @error('media_type') is-invalid @enderror" id="media_type" name="media_type">
                <option value="">-- Seçiniz --</option>
                <option value="image" {{ old('media_type', $content->media_type) === 'image' ? 'selected' : '' }}>Resim</option>
                <option value="video" {{ old('media_type', $content->media_type) === 'video' ? 'selected' : '' }}>Video</option>
            </select>
            @error('media_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="media_path" class="form-label">Medya Yolu</label>
            <input type="text" class="form-control @error('media_path') is-invalid @enderror"
                   id="media_path" name="media_path" value="{{ old('media_path', $content->media_path) }}">
            @error('media_path')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="link_url" class="form-label">Bağlantı URL</label>
            <input type="url" class="form-control @error('link_url') is-invalid @enderror"
                   id="link_url" name="link_url" value="{{ old('link_url', $content->link_url) }}">
            @error('link_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="comment_enabled"
                   name="comment_enabled" value="1"
                   {{ old('comment_enabled', $content->comment_enabled) ? 'checked' : '' }}>
            <label class="form-check-label" for="comment_enabled">Yorum Ekle</label>
        </div>

        <div class="mb-3">
            <label for="comment_text" class="form-label">Yorum Metni</label>
            <textarea class="form-control @error('comment_text') is-invalid @enderror"
                      id="comment_text" name="comment_text" rows="3">{{ old('comment_text', $content->comment_text) }}</textarea>
            @error('comment_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="comment_link" class="form-label">Yorum Bağlantısı</label>
            <input type="url" class="form-control @error('comment_link') is-invalid @enderror"
                   id="comment_link" name="comment_link" value="{{ old('comment_link', $content->comment_link) }}">
            @error('comment_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="comment_wait_seconds" class="form-label">Yorum Bekleme Süresi (saniye)</label>
            <input type="number" class="form-control @error('comment_wait_seconds') is-invalid @enderror"
                   id="comment_wait_seconds" name="comment_wait_seconds" min="0"
                   value="{{ old('comment_wait_seconds', $content->comment_wait_seconds) }}">
            @error('comment_wait_seconds')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Durum</label>
            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="active" {{ old('status', $content->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $content->status) === 'inactive' ? 'selected' : '' }}>Pasif</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Güncelle</button>
            <a href="{{ route('contents.index') }}" class="btn btn-secondary">İptal</a>
        </div>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
