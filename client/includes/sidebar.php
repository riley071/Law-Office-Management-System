<?php
include 'includes/connection.php'; 
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-1">
    <!-- Brand Logo -->
    <a href="client_dashboard.php" class="brand-link animated swing">
        <img src="../asset/img/logo.png" alt="DSMS Logo" width="200" style="margin-top: 44px; margin-bottom: 2px;">
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="client_dashboard.php" class="nav-link">
                        <i class="nav-icon fa fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="my_appointments.php" class="nav-link">
                        <i class="nav-icon fa fa-calendar-alt"></i>
                        <p>My Appointments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="client_case_updates.php" class="nav-link">
                        <i class="nav-icon fa fa-briefcase"></i>
                        <p>Case Updates</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="client_documents.php" class="nav-link">
                        <i class="nav-icon fa fa-file-alt"></i>
                        <p>My Documents</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="client_payments.php" class="nav-link">
                        <i class="nav-icon fa fa-credit-card"></i>
                        <p>Payments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="my_profile.php" class="nav-link">
                        <i class="nav-icon fa fa-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="client_feedback.php" class="nav-link">
                        <i class="nav-icon fa fa-comments"></i>
                        <p>Send Feedback</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
                
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
