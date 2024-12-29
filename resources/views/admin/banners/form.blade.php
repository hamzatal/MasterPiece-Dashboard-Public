<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $banner->title ?? '') }}" required>
</div>

<div class="form-group">
    <label for="description">description</label>
    <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $banner->description ?? '') }}">
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control">
    @isset($banner)
        <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" width="100">
    @endisset
</div>

<div class="form-group">
    <label for="link">Link</label>
    <input type="text" name="link" id="link" class="form-control" value="{{ old('link', $banner->link ?? '#') }}">
</div>

<div class="form-group form-check">
    <input
        type="checkbox"
        name="active"
        id="active"
        value="1"
        class="form-check-input"
        {{ old('active', isset($banner) && $banner->active ? 'checked' : '') }}>
    <label for="active" class="form-check-label">Active</label>
</div>
