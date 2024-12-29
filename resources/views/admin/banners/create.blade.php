<div class="container">
    <h1 class="mb-4">Create New Banner</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="form-group mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter banner title" required value="{{ old('title') }}">
        </div>

        <!-- Subtitle -->
        <div class="form-group mb-3">
            <label for="subtitle" class="form-label">Subtitle (Optional)</label>
            <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Enter banner subtitle" value="{{ old('subtitle') }}">
        </div>

        <!-- Image -->
        <div class="form-group mb-3">
            <label for="image" class="form-label">Banner Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <!-- Link -->
        <div class="form-group mb-3">
            <label for="link" class="form-label">Link (Optional)</label>
            <input type="url" name="link" id="link" class="form-control" placeholder="Enter banner link" value="{{ old('link') }}">
        </div>

        <!-- Active -->
        <div class="form-group form-check">
            <input type="hidden" name="active" value="0">
            <input type="checkbox" name="active" id="active" class="form-check-input"
                {{ old('active', $banner->active ?? false) ? 'checked' : '' }} value="1">
            <label for="active" class="form-check-label">Active</label>
        </div>


        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Banner</button>
        </div>
    </form>
</div>