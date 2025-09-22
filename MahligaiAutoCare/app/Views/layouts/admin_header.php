<?php
// app/Views/layouts/admin_header.php
// Header admin (termasuk <head>, <body> pembuka, dan awal struktur #wrapper)

use App\Core\Application;
$base_url = Application::$app->getConfig('base_url');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Admin - Mahligai AutoCare</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Dashboard Admin Mahligai AutoCare" name="keywords">
    <meta content="Halaman administrasi untuk Mahligai AutoCare" name="description">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($base_url) ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($base_url) ?>/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6f42c1;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }

        body {
            background-color: #f4f7f6;
            font-family: 'Poppins', sans-serif;
        }

        #wrapper {
            display: flex;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
            background-color: var(--dark-color);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.0rem 1.25rem;
            font-size: 1.2rem;
            color: #fff;
            background-color: #212529;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
            flex-grow: 1;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        /* --- STYLING KARTU MODERN --- */
        .dashboard-card {
            border: none;
            border-radius: 15px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        
        .dashboard-card .card-body {
            z-index: 1;
        }

        .dashboard-card .card-icon {
            font-size: 4rem;
            opacity: 0.15;
            position: absolute;
            right: 15px;
            bottom: 5px;
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover .card-icon {
            transform: scale(1.1) rotate(-10deg);
        }

        .dashboard-card .text-value {
            font-size: 2.2rem;
            font-weight: 700;
        }

        .dashboard-card .text-label {
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Palet Warna Kartu */
        .dashboard-card[data-card-type="total-bookings"] { background: linear-gradient(45deg, #17a2b8, #138496); }
        .dashboard-card[data-card-type="completed-bookings"] { background: linear-gradient(45deg, #28a745, #218838); }
        .dashboard-card[data-card-type="total-customers"] { background: linear-gradient(45deg, #6f42c1, #5a32a3); }
        .dashboard-card[data-card-type="total-users"] { background: linear-gradient(45deg, #007bff, #0056b3); }

        /* General Card Styling */
        .card {
            border: none;
            border-radius: 12px;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 600;
            color: var(--primary-color);
        }

        /* Table & Badge Styling */
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge {
            padding: 0.5em 0.9em;
            border-radius: 50rem;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .status-pending { background-color: var(--warning-color); color: #fff; }
        .status-confirmed { background-color: var(--info-color); color: #fff; }
        .status-completed { background-color: var(--success-color); color: #fff; }
        .status-cancelled, .status-rejected { background-color: var(--danger-color); color: #fff; }

        .animated {
            animation-duration: 0.8s;
        }
    </style>

</head>
<body class="sb-nav-fixed">
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="wrapper">