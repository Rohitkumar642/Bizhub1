@extends('user.layout')

@section('content')
<div class="mt-4" id="inquiry">
        <h4>Make an Inquiry</h4>
        <form id="inquiryForm">
            @csrf
            

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="inquiry_name" name="name" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="inquiry_email" name="email" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" class="form-control" id="inquiry_phone" name="phone" required>
            </div>

            <div class="form-group">
                <label>Message</label>
                <textarea class="form-control" id="inquiry_message" name="message" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Submit Inquiry</button>
        </form>

        <script>
            $(document).ready(function () {
                $("#inquiryForm").submit(function (e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route('inquiry.store') }}",
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        $("#inquiryForm")[0].reset();
                    },
                    error: function () {
                        alert("Error submitting inquiry. Please try again.");
                    }
                });
            });
            });
        </script>
</div>
@endsection