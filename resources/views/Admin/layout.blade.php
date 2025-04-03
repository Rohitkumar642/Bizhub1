<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <style>
        body {
            display: flex;
            font-size: 12px;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar .active {
            background: #495057;
        }
        .sidebar .submenu {
            display: none;
            padding-left: 15px;
        }
        .sidebar .submenu a {
            font-size: 14px;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        .navbar {
            background: #007bff;
            color: white;
        }
        .submenu-active {
            display: block !important;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
    <div class="main_header_logo">
        <figure>
            <a href="#" title="Bizhub India"><img src="img/bizhub-india-logo.png" alt="logo" style=""></a>                        
        </figure>
    </div>
        <h4 class="text-center">Admin Panel</h4>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.editProfile') }}">Edit Profile</a>
        <a href="{{ route('admin.vendors') }}">Vendor List</a>
        
        <a href="#" id="subscriberMenu">Subscriber</a>
        <div class="submenu" id="subscriberSubMenu">
            <a href="{{ route('Subscribers') }}">Subscribers</a>
            <a href="{{ route('UnSubscribers') }}">Unsubscribers</a>
        </div>

        <a href="{{ route('Inquiry') }}">Inquiry</a>
        <a href="{{ route('admin.logout') }}" class="text-danger">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Admin Dashboard</span>
            </div>
        </nav>
        
        <div class="container mt-3">
            @yield('content')
        </div>
    </div>

    <script>
        document.getElementById('subscriberMenu').addEventListener('click', function() {
            document.getElementById('subscriberSubMenu').classList.toggle('submenu-active');
        });
    </script>
</body>
</html>
