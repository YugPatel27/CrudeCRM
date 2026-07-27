<!DOCTYPE html>
<?php include_once 'header.php'; ?>

  <!-- Page Wrapper -->
  <div class="layout-wrapper">

    <!-- Sidebar -->
    <aside class="main-menu">
      <?php include_once 'sidebar.php'; ?>
    </aside>

    <main class="app-content py-4">
      <div class="container-fluid">

        <!-- Top Stats Row -->
        <div class="row g-3 mb-4">
          <!-- Progress Stats -->
          <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-dark">Progress Stats</h6>
                  <h4 class="fw-bold text-success">78%</h4>
                  <small class="text-dark">Overall project completion</small>
                </div>
                <i class="ft-pie-chart text-danger fs-1"></i>
              </div>
            </div>
          </div>

          <!-- Clients Stats -->
          <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-dark">Active Clients</h6>
                  <h4 class="fw-bold text-primary">1,240</h4>
                  <small class="text-dark">Engaged in last 30 days</small>
                </div>
                <i class="ft-users text-info fs-1"></i>
              </div>
            </div>
          </div>

          <!-- Sales Stats -->
          <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-dark">Total Sales</h6>
                  <h4 class="fw-bold text-warning">$45,000</h4>
                  <small class="text-dark">This month’s revenue</small>
                </div>
                <i class="ft-shopping-cart text-warning fs-1"></i>
              </div>
            </div>
          </div>

          <!-- Pending Invoices -->
          <div class="col-lg-3 col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="text-dark">Pending Invoices</h6>
                  <h4 class="fw-bold text-danger">12</h4>
                  <small class="text-dark">Awaiting payment</small>
                </div>
                <i class="ft-file-text text-danger fs-1"></i>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content Row 1 -->
        <div class="row g-3 mb-4">
          <!-- Customer Management -->
          <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-header bg-white">
                <h5 class="mb-0">Customer Management</h5>
              </div>
              <div class="card-body">
                <p>
                  Manage and organize customer profiles, track contact info, and monitor purchase history effectively.
                </p>
                <ul class="list-unstyled mb-0">
                  <li><i class="ft-users text-success me-2"></i> Segment clients as <b>B2B, B2C, Refineries, or Distributors</b></li>
                  <li><i class="ft-map-pin text-danger me-2"></i> Filter by <b>location, contract type, or volume</b></li>
                  <li><i class="ft-trending-up text-primary me-2"></i> Optimize crude oil sales pipelines</li>
                  <li><i class="ft-message-circle text-info me-2"></i> Integrated <b>customer communication</b> system</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Sales Pipeline -->
          <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales Pipeline</h5>
                <span class="badge bg-primary">Active</span>
              </div>
              <div class="card-body">
                <div id="carousel-area" class="carousel slide" data-bs-ride="carousel">
                  <div class="carousel-inner rounded">
                    <div class="carousel-item active">
                      <img class="d-block w-100" src="theme-assets/images/carousel/08.jpg" alt="Lead Tracking">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="theme-assets/images/carousel/03.jpg" alt="Pipeline Overview">
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-end">
                <a href="track_leads.php" class="btn btn-sm btn-primary">Track Leads</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Main Content Row 2 -->
        <div class="row g-3">
          <!-- Orders & Invoices -->
          <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-header bg-white">
                <h5 class="mb-0">Order & Invoice Overview</h5>
              </div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex align-items-center">
                    <img src="theme-assets/images/portrait/small/avatar-s-7.png" class="rounded-circle me-3" width="40">
                    <div>
                      <strong>KR Oil Refinery</strong><br>
                      <small class="text-muted">Invoice #CO-23001 — <span class="text-success">Paid</span></small>
                    </div>
                    <span class="ms-auto badge bg-success">Delivered</span>
                  </li>
                  <li class="list-group-item d-flex align-items-center">
                    <img src="theme-assets/images/portrait/small/avatar-s-8.png" class="rounded-circle me-3" width="40">
                    <div>
                      <strong>PetroMax Distributors</strong><br>
                      <small class="text-muted">Invoice #CO-23002 — <span class="text-warning">Pending</span></small>
                    </div>
                    <span class="ms-auto badge bg-warning text-dark">Processing</span>
                  </li>
                  <li class="list-group-item d-flex align-items-center">
                    <img src="theme-assets/images/portrait/small/avatar-s-9.png" class="rounded-circle me-3" width="40">
                    <div>
                      <strong>Alpha Crude Supplies</strong><br>
                      <small class="text-muted">Invoice #CO-23003 — <span class="text-danger">Overdue</span></small>
                    </div>
                    <span class="ms-auto badge bg-danger">On Hold</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Quick Actions -->
          <div class="col-lg-4">
            <div class="card h-100 shadow-sm border-0 rounded-3 bg-light-red">
              <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
              </div>
              <div class="card-body">
                <ul class="list-unstyled">
                  <li><a href="add_client.php" class="btn btn-sm btn-outline-primary w-100 mb-2"><i class="ft-user-plus me-2"></i> Add New Client</a></li>
                  <li><a href="create_invoice.php" class="btn btn-sm btn-outline-warning w-100 mb-2"><i class="ft-file-text me-2"></i> Generate Invoice</a></li>
                  <li><a href="reports.php" class="btn btn-sm btn-outline-success w-100 mb-2"><i class="ft-bar-chart-2 me-2"></i> View Reports</a></li>
                  <li><a href="support.php" class="btn btn-sm btn-outline-danger w-100"><i class="ft-help-circle me-2"></i> Customer Support</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>

  <style>
    /* Layout Fix */
    body {
      margin: 0;
      padding: 0;
      overflow-x: hidden;
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .layout-wrapper {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }

    .main-menu {
      width: 250px;
      flex-shrink: 0;
      background: #fff;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      overflow-y: auto;
      border-right: 1px solid #ddd;
      z-index: 1050;
    }

    .app-content {
      margin-left: 250px;
      flex-grow: 1;
      padding: 20px;
    }

    .card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    .bg-light-red {
      background: #fff5f5 !important; /* light red */
    }

    /* Mobile View */
    @media (max-width: 768px) {
      .main-menu {
        left: -250px;
        transition: all 0.3s ease;
      }

      .main-menu.active {
        left: 0;
      }

      .app-content {
        margin-left: 0 !important;
      }
    }
  </style>

  <?php include 'footer.php'; ?>
</body>
</html>
