@extends('user.layout')

@section('content')
<div class="mt-3" id="subscribeForm" style="">
        <h4>Subscribe to Our Newsletter</h4>
        <form id="subscriberForm">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="subscriber_email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Subscribe</button>
        </form>
</div>

<script>
    $(document).ready(function() {
        $("#subscriberForm").submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('subscribe.store') }}",
                data: formData,
                success: function (response) {
                    alert(response.message);
                    $("#subscriberForm")[0].reset();
                    //$("#subscribeForm").hide();
                },
                error: function (xhr) {
                    alert("Subscription failed! Please Try Again.");
                }
            });
        });
    })
</script>
@endsection