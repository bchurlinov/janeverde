<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('/bt/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('/bt/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Administration
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Users</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            
            <a class="collapse-item" href="/usersverification">Verification</a>
            <a class="collapse-item" href="/usersmanagement">Users management</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Products</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="/manageproducts">Manage products</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group" style="display:none;">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name . " " . Auth::user()->lastname}}</span>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('home')}}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Home
                </a>
                  <a class="dropdown-item" href="/changePassword">
                      <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                      Change password
                  </a>
                  <a class="dropdown-item" href="/settings">
                    <i class="fas fa-wrench fa-sm fa-fw mr-2 text-gray-400"></i>
                    Update personal settings
                  </a>
                <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }} 
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->
          <div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total number of users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersData['total']}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Verified</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersData['verified']}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Not verified (pending review)</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$usersData['pending']}}</div>
                        </div>
                        <div class="col">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">No picture ID uploaded</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersData['noIDUploaded']}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Need to re-upload picture ID</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersData['denied']}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Deleted users</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersData['deleted']}}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          
          <!-- Content Row -->

          <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Nr. of products</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$productsData}}</div>
                        </div>
                        <div class="col">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

      </div>
</div>
</div>
      <!-- End of Main Content -->
      <div id="embed-api-auth-container"></div>
      <div id="view-selector-container"></div>
      <div id="main-chart-container"></div>
      <div id="breakdown-chart-container"></div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; JaneVerde {{date('Y')}}</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('/bt/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('/bt/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('/bt/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('/bt/js/sb-admin-2.min.js')}}"></script>
  <script>
    (function(w,d,s,g,js,fs){
      g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
      js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
      js.src='https://apis.google.com/js/platform.js';
      fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
    }(window,document,'script'));
  </script>

  <script>

    gapi.analytics.ready(function() {

      /**
       * Authorize the user immediately if the user has already granted access.
       * If no access has been created, render an authorize button inside the
       * element with the ID "embed-api-auth-container".
       */
      gapi.analytics.auth.authorize({
        container: 'embed-api-auth-container',
        clientid: '506977689590-3uv12urmui081ce60ter5ql2t48nrkd9.apps.googleusercontent.com'
      });


      /**
       * Create a new ViewSelector instance to be rendered inside of an
       * element with the id "view-selector-container".
       */
      var viewSelector = new gapi.analytics.ViewSelector({
        container: 'view-selector-container'
      });

      // Render the view selector to the page.
      viewSelector.execute();

      /**
       * Create a table chart showing top browsers for users to interact with.
       * Clicking on a row in the table will update a second timeline chart with
       * data from the selected browser.
       */
      var mainChart = new gapi.analytics.googleCharts.DataChart({
        query: {
          'dimensions': 'ga:browser',
          'metrics': 'ga:sessions',
          'sort': '-ga:sessions',
          'max-results': '6'
        },
        chart: {
          type: 'TABLE',
          container: 'main-chart-container',
          options: {
            width: '100%'
          }
        }
      });


      /**
       * Create a timeline chart showing sessions over time for the browser the
       * user selected in the main chart.
       */
      var breakdownChart = new gapi.analytics.googleCharts.DataChart({
        query: {
          'dimensions': 'ga:date',
          'metrics': 'ga:sessions',
          'start-date': '7daysAgo',
          'end-date': 'yesterday'
        },
        chart: {
          type: 'LINE',
          container: 'breakdown-chart-container',
          options: {
            width: '100%'
          }
        }
      });


      /**
       * Store a refernce to the row click listener variable so it can be
       * removed later to prevent leaking memory when the chart instance is
       * replaced.
       */
      var mainChartRowClickListener;


      /**
       * Update both charts whenever the selected view changes.
       */
      viewSelector.on('change', function(ids) {
        var options = {query: {ids: ids}};

        // Clean up any event listeners registered on the main chart before
        // rendering a new one.
        if (mainChartRowClickListener) {
          google.visualization.events.removeListener(mainChartRowClickListener);
        }

        mainChart.set(options).execute();
        breakdownChart.set(options);

        // Only render the breakdown chart if a browser filter has been set.
        if (breakdownChart.get().query.filters) breakdownChart.execute();
      });


      /**
       * Each time the main chart is rendered, add an event listener to it so
       * that when the user clicks on a row, the line chart is updated with
       * the data from the browser in the clicked row.
       */
      mainChart.on('success', function(response) {

        var chart = response.chart;
        var dataTable = response.dataTable;

        // Store a reference to this listener so it can be cleaned up later.
        mainChartRowClickListener = google.visualization.events
                .addListener(chart, 'select', function(event) {

                  // When you unselect a row, the "select" event still fires
                  // but the selection is empty. Ignore that case.
                  if (!chart.getSelection().length) return;

                  var row =  chart.getSelection()[0].row;
                  var browser =  dataTable.getValue(row, 0);
                  var options = {
                    query: {
                      filters: 'ga:browser==' + browser
                    },
                    chart: {
                      options: {
                        title: browser
                      }
                    }
                  };

                  breakdownChart.set(options).execute();
                });
      });

    });
  </script>

</body>

</html>

