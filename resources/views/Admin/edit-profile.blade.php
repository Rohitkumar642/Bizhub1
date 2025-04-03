@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <form id="editProfileForm">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ session('admin_email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">New Password (leave blank if not changing)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
    $(document).ready(function () {
        $('#editProfileForm').submit(function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.updateProfile') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {
                    alert(response.message);
                },
                error: function (xhr) {
                    alert("Error updating profile!");
                }
            });
        });
    });
</script>
@endsection
