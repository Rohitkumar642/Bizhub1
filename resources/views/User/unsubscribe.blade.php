@extends('user.layout')

@section('content')
<div class="mt-3" id="subscribeForm" style="">
        <h4>UnSubscribe to Our Newsletter</h4>
        <form id="subscriberForm">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="subscriber_email" name="email" required>
            </div>
            <button type="submit" id="unsubscribeBtn" class="btn btn-primary mt-3">UnSubscribe</button>
        </form>
</div>

<script>
    $(document).ready(function() {
        $("#unsubscribeBtn").click(function () {
    let email = $("#subscriber_email").val(); // Get email from input

    if (!email) {
        alert("No email found to unsubscribe.");
        return;
    }

    if (!confirm("Are you sure you want to unsubscribe?")) return;

    $.ajax({
        type: "POST",
        url: "{{ route('unsubscribe.store') }}", // Make sure this route exists
        data: {
            _token: "{{ csrf_token() }}",
            email: email
        },
        success: function (response) {
            alert(response.message);
            $("#subscriberForm")[0].reset();
        },
        error: function () {
            alert("Unsubscription failed! Try again.");
        }
    });
});
    })
</script>
@endsection