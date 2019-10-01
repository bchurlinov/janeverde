<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Password change</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('/bt/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('/bt/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
@if(Gate::check('isAdmin'))
    <!-- Sidebar -->
        @include('partials.admin.sidebar')
        <!-- End of Sidebar -->
    @else
        @include('partials.layout')
    @section('css_links')
    @endsection

    <div align="right">
        {{"Welcome " .auth()->user()->name . " to your dashboard | "}}
        <a href="{{route('home')}}">Home</a>
        <a href="/changePassword">Change password</a>
        @can('isVerified')
            @can('isBuyer')
                <a href="/myproducts">My purchased items</a>

            @endcan
        @endcan
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
       document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div><br /><br />
@endif
<!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
        @if(Gate::check('isAdmin'))
            <!-- Topbar -->
                @include('partials.admin.navbar')
        @endif
        <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Update post data</div>

                                <div class="card-body">
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" method="POST" action="/pupdate">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$product->id}}" />
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label for="title" class="col-md-4 control-label">Title</label>

                                            <div class="col-md-6">
                                                <input id="title" type="text" class="form-control" name="title" value ="{{$product->title}}" required>

                                                @if ($errors->has('title'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('title') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description" class="col-md-4 control-label">Description</label>
                                            <div class="col-md-6">
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span><br />
                                                @endif
                                                    <textarea class="form-control" rows="5" cols="10" id="description" name="description">{{$product->description}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @if(Gate::check('isAdmin'))
        <!-- End of Main Content -->
            <div style="display:none;">
                <div id="embed-api-auth-container"></div>
                <div id="view-selector-container"></div>
                <div id="main-chart-container"></div>
                <div id="breakdown-chart-container"></div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; JaneVerde {{date('Y')}}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        @endif
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