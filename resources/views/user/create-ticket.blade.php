@extends('layouts.app')

@section('title', 'Create Ticket')

@section('navbar-buttons')
    <a href="{{ route('user.dashboard') }}" class="btn-create">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2z"/><line x1="3" y1="7" x2="21" y2="7"/></svg>
        Dashboard
    </a>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="btn-logout">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
        </button>
    </form>
@endsection

@section('content')


<div class="container mt-4">

<h3>Create New Ticket</h3>

<div class="card mt-3">
<div class="card-body">

<form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
@csrf

<div class="mb-3">
<label class="form-label">Subject</label>
<input type="text" name="subject" class="form-control" required>
</div>


{{-- <div class="mb-3">
<label class="form-label">Priority</label>

<select name="priority" class="form-control">

<option value="low">Low</option>
<option value="medium">Medium</option>
<option value="high">High</option>

</select>

</div> --}}


<div class="mb-3">
<label class="form-label">Message</label>

<textarea name="message" rows="5" class="form-control" required></textarea>

</div>

<div class="mb-3">
    <label class="form-label">Upload Images (Optional)</label>
    <div class="images-container">
        <div class="image-input mb-2">
            <input type="file" name="images[]" class="form-control" accept="image/*">
        </div>
    </div>
    <button type="button" class="btn btn-sm btn-outline-primary" id="addImage">Add Another Image</button>
    <small class="form-text text-muted">Accepted formats: JPEG, PNG, JPG, GIF (Max 2MB each)</small>
</div>

<button class="btn btn-success">Submit Ticket</button>

</form>

</div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addImage').addEventListener('click', function() {
        const imagesContainer = document.querySelector('.images-container');
        const newImageInput = document.createElement('div');
        newImageInput.className = 'image-input mb-2';
        newImageInput.innerHTML = '<input type="file" name="images[]" class="form-control" accept="image/*"> <button type="button" class="btn btn-sm btn-outline-danger remove-image">Remove</button>';
        imagesContainer.appendChild(newImageInput);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-image')) {
            e.target.closest('.image-input').remove();
        }
    });
});
</script>

@endsection
