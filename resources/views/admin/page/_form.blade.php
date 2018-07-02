<input type="hidden" name="lang" value="en">
<div class="form-group">
  <label for="title">Title</label>
  <input type="text" name="title" class="form-control" placeholder="Enter a Title" value="{{ old('title', $page->title) }}">
  <small id="titleHelp" class="form-text text-muted">Enter a title for your page</small>
</div>
<div class="form-group">
  <label for="slug">URL</label>
  <input type="text" name="slug" class="form-control" placeholder="Enter a URL" value="{{ old('slug', $page->slug) }}">
  <small id="slugHelp" class="form-text text-muted">Enter a URL for this page</small>
</div>
<div class="form-group">
  <label for="meta_description">Description</label>
  <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
</div>
<button type="submit" class="btn btn-primary">{{ isset($buttonText) ? $buttonText : 'Create Page' }}</button>
