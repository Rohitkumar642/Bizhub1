<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            display: flex;
            font-size: 14px;
            background-color: #f8f9fa;
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
        .vendor-card {
            width: 200%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 20px;
            transition: transform 0.2s ease-in-out;
        }
        .vendor-card:hover {
            transform: scale(1.03);
        }
        .vendor-header {
            background: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        .vendor-info {
            padding: 15px;
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
        <a href="{{ route('home') }}">Dashboard</a>
        
        <a href="{{ route('subscribe.show') }}">Subscribe</a>
        <a href="{{ route('unsubscribe.show') }}">Unsubscribe</a>
    

        <a href="{{ route('inquiry.show') }}">Inquiry</a>
        <a href="{{ route('user.logout') }}" class="text-danger">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        
        <div class="container mt-3">
            <div class="main_header_logo">
                <figure>
                    <a href="#" title="Bizhub India"><img src="img/bizhub-india-logo.png" alt="logo" style=""></a>                        
                </figure>
            </div>
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
