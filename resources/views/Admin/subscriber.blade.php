@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Subscribers List</h2>
    <table id="subscribersTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->status }}</td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    /* Ensure the table container overlaps navbar */
    .table-responsive {
        overflow-x: auto;
        position: absolute;
        top: 160px; /* Adjust based on navbar height */
        left: 260px;
        width: 80%;
        background: white;
        z-index: 1000; /* Ensures it overlaps navbar */
    }

    /* Enable horizontal swipe */
    #subscribersTable {
        min-width: 800px;
    }
</style>

<!-- DataTables Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#subscribersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn '
                },
                {
                    extend: 'excel',
                    text: 'Export Excel',
                    className: 'btn '
                },
                {
                    extend: 'pdf',
                    text: 'Export PDF',
                    className: 'btn ',
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn ',
                    title: 'Subscriber Data',
                    customize: function(win) {
                        $(win.document.body).find('h1').hide(); // Hide extra elements
                        $(win.document.body).css('font-size', '12px'); // Adjust font size
                        $(win.document.body).find('table').addClass('compact').css('font-size', '12px');
                    }
                }
            ]
        });
    });
</script>
@endsection
