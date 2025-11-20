<?php
// Check login session
session_start();
if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
$user_name = isset($_SESSION['full_name']) ? $_SESSION['full_name'] : 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fa-solid fa-boxes-packing"></i> <span>SMS Admin</span>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="nav-link active" data-tab="dashboard"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                    <li><a href="#" class="nav-link" data-tab="suppliers"><i class="fa-solid fa-users"></i> Suppliers</a></li>
                    <li><a href="reports/generate_pdf.php" target="_blank" class="nav-link"><i class="fa-solid fa-file-pdf"></i> Reports</a></li>
                    <li><a href="#" class="nav-link" data-tab="settings"><i class="fa-solid fa-gear"></i> Settings</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-bar">
                <div class="page-title">
                    <h1 id="page-title">Dashboard</h1>
                </div>
                <div class="user-profile">
                    <span><?php echo htmlspecialchars($user_name); ?></span>
                    <div class="avatar"><i class="fa-solid fa-user"></i></div>
                    <a href="api/logout.php" class="btn-logout" title="Logout"><i class="fa-solid fa-sign-out-alt"></i></a>
                </div>
            </header>

            <div class="content-wrapper">
                
                <!-- Dashboard Tab -->
                <div id="tab-dashboard" class="tab-content active">
                <!-- Stats cards -->
                <div class="stats-grid">
                    <div class="card stat-card">
                        <div class="stat-icon bg-blue">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Suppliers</h3>
                            <p id="total-suppliers">0</p>
                        </div>
                    </div>
                    <div class="card stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fa-solid fa-check-circle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Active Suppliers</h3>
                            <p id="active-suppliers">0</p>
                        </div>
                    </div>
                </div>

                <!-- Main Card -->
                <div class="card">
                    <div class="card-header">
                        <h2>Supplier Management</h2>
                        <div class="card-actions">
                            <select id="status-filter" class="status-filter">
                                <option value="">All Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Suspended">Suspended</option>
                            </select>
                            <div class="search-box">
                                <i class="fa-solid fa-search"></i>
                                <input type="text" id="search-input" placeholder="Search suppliers...">
                            </div>
                            <button id="btn-add-supplier" class="btn-primary"><i class="fa-solid fa-plus"></i> Add New</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert-message" class="alert" style="display:none;"></div>
                        <div class="table-responsive">
                            <table id="suppliers-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Company</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
                <!-- End Dashboard Tab -->

                <!-- Suppliers Tab -->
                <div id="tab-suppliers" class="tab-content">
                    <div class="card">
                        <div class="card-header">
                            <h2><i class="fa-solid fa-users"></i> Supplier Directory</h2>
                            <div class="card-actions">
                                <select id="status-filter-suppliers" class="status-filter">
                                    <option value="">All Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                                <div class="search-box">
                                    <i class="fa-solid fa-search"></i>
                                    <input type="text" id="search-input-suppliers" placeholder="Search suppliers...">
                                </div>
                                <button id="btn-add-supplier-tab" class="btn-primary"><i class="fa-solid fa-plus"></i> Add New</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="alert-message-suppliers" class="alert" style="display:none;"></div>
                            <div class="table-responsive">
                                <table id="suppliers-table-tab">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company</th>
                                            <th>Contact Person</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Suppliers Tab -->

                <!-- Settings Tab -->
                <div id="tab-settings" class="tab-content">
                    <div class="stats-grid">
                        <div class="card">
                            <div class="card-header">
                                <h2><i class="fa-solid fa-user-circle"></i> User Profile</h2>
                            </div>
                            <div class="card-body" style="padding: 24px;">
                                <div class="settings-item">
                                    <label>Username:</label>
                                    <span><?php echo htmlspecialchars($user_name); ?></span>
                                </div>
                                <div class="settings-item">
                                    <label>Role:</label>
                                    <span class="badge badge-success">Administrator</span>
                                </div>
                                <div class="settings-item">
                                    <label>Status:</label>
                                    <span class="badge badge-success">Active</span>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h2><i class="fa-solid fa-database"></i> System Information</h2>
                            </div>
                            <div class="card-body" style="padding: 24px;">
                                <div class="settings-item">
                                    <label>Database Status:</label>
                                    <span id="db-status-settings" class="badge badge-success">Connected</span>
                                </div>
                                <div class="settings-item">
                                    <label>Database Name:</label>
                                    <span>supplier_db</span>
                                </div>
                                <div class="settings-item">
                                    <label>Total Records:</label>
                                    <span id="total-records-settings">0</span>
                                </div>
                                <div class="settings-item">
                                    <label>Auto-Provisioning:</label>
                                    <span class="badge badge-success">Enabled</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-header">
                            <h2><i class="fa-solid fa-info-circle"></i> Application Info</h2>
                        </div>
                        <div class="card-body" style="padding: 24px;">
                            <div class="settings-item">
                                <label>Version:</label>
                                <span>1.0.0</span>
                            </div>
                            <div class="settings-item">
                                <label>Framework:</label>
                                <span>PHP + jQuery + AJAX</span>
                            </div>
                            <div class="settings-item">
                                <label>PDF Library:</label>
                                <span>FPDF</span>
                            </div>
                            <div class="settings-item">
                                <label>Responsive:</label>
                                <span class="badge badge-success">Yes</span>
                            </div>
                            <div class="settings-item" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                                <label>Developer:</label>
                                <span><strong>Mark Angelo L. Mingala</strong></span>
                            </div>
                            <div class="settings-item">
                                <label>Class:</label>
                                <span>3A-WMAD</span>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-top: 20px;">
                        <div class="card-body" style="padding: 24px; text-align: center;">
                            <a href="api/logout.php" class="btn-primary" style="display: inline-block; padding: 12px 32px; text-decoration: none; font-size: 16px; background-color: #dc2626; border-color: #dc2626;">
                                <i class="fa-solid fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Settings Tab -->

            </div>
        </main>
    </div>

    <!-- Modal -->
    <!-- Add/Edit modal -->
    <div id="supplier-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Add Supplier</h2>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <form id="supplier-form">
                    <input type="hidden" id="supplier_id" name="id">
                    
                    <div class="form-group">
                        <label for="company_name">Company Name</label>
                        <input type="text" id="company_name" name="company_name" required>
                    </div>

                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person" required>
                    </div>

                    <div class="form-group-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-secondary close-modal-btn">Cancel</button>
                        <button type="submit" class="btn-primary">Save Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
