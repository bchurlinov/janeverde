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
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
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

                <div class="row">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Active products</h6>
                        </div>
                        <div class="card-body">
                            @if(count($products) == 0)
                                <p>No products</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">&nbsp;</th>
                                                <th scope="col">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($products as $id => $product)
                                                <tr scope="row">
                                                    <td>{{$product->title}}</td>
                                                    <td>{{substr($product->description, 0, 120)}}...</td>
                                                    <td>{{$product->location}}</td>
                                                    <td>${{$product->price}}</td>
                                                    <td><a href="/view/{{$product->id}}">View details</a></td>
                                                    <td>
                                                        <a href="/pdelete"
                                                           onclick="event.preventDefault(); document.getElementById('{{$product->id}}').submit();">
                                                            <button type="button" class="close" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </a>
                                                        <form id="{{$product->id}}" action="/pdelete" method="POST" style="display: none;">
                                                            <input type="hidden" name="id" value="{{$product->id}}" />
                                                            @csrf
                                                        </form></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Deleted products</h6>
                        </div>
                        <div class="card-body">
                            @if(count($deleted) == 0)
                                <p>No deleted products</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Title</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">&nbsp;</th>
                                                <th scope="col">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($deleted as $product)
                                                <tr scope="row">
                                                    <td>{{$product->title}}</td>
                                                    <td>{{substr($product->description, 0, 120)}}...</td>
                                                    <td>{{$product->location}}</td>
                                                    <td>${{$product->price}}</td>
                                                    <td><a href="/view/{{$product->id}}" target="_blank">View details</a></td>
                                                    <td>
                                                        <a href="/prestore"
                                                           onclick="event.preventDefault(); document.getElementById('{{$product->id . '_'.$product->id}}').submit();">
                                                            <i class="fa fa-undo" aria-hidden="true"></i>
                                                        </a>
                                                        <form id="{{$product->id . '_'.$product->id}}" action="/prestore" method="POST" style="display: none;">
                                                            <input type="hidden" name="id" value="{{$product->id . '_'.$product->id}}" />
                                                            @csrf
                                                        </form></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- End of Main Content -->
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">
                        <img src="" id="imagepreview" style="width: 400px; height: 264px; align-self: center;" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
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
    $("#pop").on("click", function() {
        $('#imagepreview').attr('src', $('#imageresource').attr('src'));
        $('#imagemodal').modal('show');
    });
</script>
</body>

</html>

