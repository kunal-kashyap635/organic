<?php

session_start();
if(isset($_GET['logout']))
{
    session_destroy();
    header("location: adminlogin.php");
}
$_SESSION['aid'] ?? header("location: adminlogin.php") ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
     <!-- Bootstrap 5 JS Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: #4e73df;
            --sidebar-bg: #343a40;
            --sidebar-hover: #495057;
        }
        
        body {
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        
        #sidebar ul.components {
            padding: 20px 0;
            margin: 0;
            list-style: none;
        }
        
        #sidebar ul li a {
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover {
            color: white;
            background: var(--sidebar-hover);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        #sidebar ul li.active > a {
            color: white;
            background: var(--primary-color);
        }
        
        #content {
            width: calc(100% - var(--sidebar-width));
            min-height: 100vh;
            margin-left: var(--sidebar-width);
            transition: all 0.3s;
            position: relative;
        }
        
        #navbar {
            height: var(--header-height);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
            background: white;
        }
        
        #main-content {
            padding: 20px;
            height: calc(100vh - var(--header-height));
            overflow: hidden;
        }
        
        .iframe-container {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }
        
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -var(--sidebar-width);
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                margin-left: 0;
            }
            #content.active {
                margin-left: var(--sidebar-width);
                width: calc(100% - var(--sidebar-width));
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Admin Panel</h3>
        </div>
        
        <ul class="components">
            <li class="active">
                <a href="#addProduct" data-url="http://localhost/organic/addproduct.php"><i class="fas fa-plus-circle"></i> Add Product</a>
            </li>
            <li>
                <a href="#addCategory" data-url="http://localhost/organic/addcategory.php"><i class="fas fa-tags"></i> Add Category</a>
            </li>
            <li>
                <a href="#viewProducts" data-url="http://localhost/organic/viewprod.php"><i class="fas fa-boxes"></i> View Products</a>
            </li>
            <li>
                <a href="#orders" data-url="http://localhost/organic/orders.php"><i class="fas fa-shopping-cart"></i> Orders</a>
            </li>
            <li>
                <a href="#customers" data-url="http://localhost/organic/customer.php"><i class="fas fa-users"></i> Customers</a>
            </li>
            <li>
                <a href="#reports" data-url="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
            </li>
            <li>
                <a href="#settings" data-url="settings.php"><i class="fas fa-cog"></i> Settings</a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content">
        <!-- Top Navigation -->
        <nav id="navbar" class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="d-flex align-items-center ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> Admin User
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="?logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div id="main-content">
            <iframe id="contentFrame" class="iframe-container" src="http://localhost/organic/addproduct.php" frameborder="0"></iframe>
            <iframe id="contentFrame" class="iframe-container" src="http://localhost/organic/addcategory.php" frameborder="0"></iframe>
        </div>
    </div>
 
    <script>
        $(document).ready(function() {
            // 1. SIDEBAR TOGGLE FUNCTIONALITY
            $('#sidebarCollapse').on('click', function() {
                // Toggle active class on sidebar and content
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            // 2. HANDLE SIDEBAR LINK CLICKS
            $('#sidebar a').on('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all menu items
                $('#sidebar li').removeClass('active');
                
                // Add active class to clicked item
                $(this).parent().addClass('active');
                
                // Load the clicked page in iframe
                var pageUrl = $(this).data('url');
                $('#contentFrame').attr('src', pageUrl);
                
                // On mobile, close sidebar after selection
                if ($(window).width() < 768) {
                    $('#sidebar').removeClass('active');
                    $('#content').removeClass('active');
                }
            });

            // 3. SET PROPER IFRAME HEIGHT
            function adjustIframeHeight() {
                var navbarHeight = $('#navbar').outerHeight();
                var windowHeight = $(window).height();
                $('#contentFrame').height(windowHeight - navbarHeight);
            }

            // Call on load and when window resizes
            $(window).on('load resize', adjustIframeHeight);
        });
    </script>
</body>
</html>