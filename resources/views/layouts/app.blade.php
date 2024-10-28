<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Inventory</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .wrapper {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            font-size: 1.1em;
            padding: 15px;
            display: block;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar .sidebar-header {
            font-size: 1.5em;
            text-align: center;
            padding-bottom: 30px;
            font-weight: bold;
            color: #f8f9fa;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}">Inventory</a>
            </div>
            <a href="{{ route('categories.index') }}">Categories</a>
            <a href="{{ route('suppliers.index') }}">Suppliers</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('orders.index') }}">Orders</a>
            <a href="{{ route('reports.index') }}">Reports</a>
        </nav>

        <div class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
