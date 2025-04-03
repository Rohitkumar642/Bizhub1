@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <h2>Vendor List</h2>
    <div class="table-responsive">
        <table id="vendorTable" class="table table-striped table-bordered" style="width:50%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>GST No.</th>
                    <th>Email</th>
                    <th>Legal Name</th>
                    <th>Duty</th>
                    <th>Registration</th>
                    <th>Company Type</th>
                    <th>Status</th>
                    <th>Trade Name</th>
                    <th>District</th>
                    <th>State</th>
                    <th>Pin Code</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<style>
    /* Ensure the table container overlaps navbar */
    .table-responsive {
        overflow-x: auto;
        position: absolute;
        top: 160px; /* Adjust based on navbar height */
        left: 260px;
        width: 78%;
        background: white;
        z-index: 1000; /* Ensures it overlaps navbar */
    }

    /* Enable horizontal swipe */
    #vendorTable {
        min-width: 800px;
    }
</style>

<!-- Include DataTables CSS & JS -->
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
        $('#vendorTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.vendors.data') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'gst_no', name: 'gst_no' },
                { data: 'vendor_email', name: 'vendor_email' },
                { data: 'legal_name', name: 'legal_name' },
                { data: 'duty', name: 'duty' },
                { data: 'registration', name: 'registration' },
                { data: 'company_type', name: 'company_type' },
                { data: 'status', name: 'status' },
                { data: 'trade_name', name: 'trade_name' },
                { data: 'district', name: 'district' },
                { data: 'state', name: 'state' },
                { data: 'pin_code', name: 'pin_code' }
            ],
            scrollX: true,
            dom: 'Bfrtip', // Add export buttons
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
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 8; // Reduce font size
                        doc.pageOrientation = 'landscape'; // Set landscape mode
                        doc.pageSize = 'A3'; // Use A3 for more space
                        doc.content[1].table.widths = 
                            Array(doc.content[1].table.body[0].length + 1).join('*').split(''); // Auto-adjust column width
                    }
                },
                {
                    extend: 'print',
                    text: 'Print',
                    className: 'btn ',
                    title: 'Vendors Data',
                    customize: function(win) {
                        $(win.document.body).find('h1').hide(); // Hide extra elements
                        $(win.document.body).css('font-size', '12px'); // Adjust font size
                        $(win.document.body).find('table').addClass('compact').css('font-size', '12px');
                    }
                }
            ]
        });

        let touchStartX = 0;
        let touchEndX = 0;

        document.querySelector('.table-responsive').addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.querySelector('.table-responsive').addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            if (touchEndX < touchStartX) {
                document.querySelector('.table-responsive').style.left = "-200px"; // Swipe left to move
            } else {
                document.querySelector('.table-responsive').style.left = "0px"; // Swipe right to reset
            }
        });
    });
</script>
@endsection
