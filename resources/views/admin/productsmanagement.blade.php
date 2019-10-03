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
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" defer></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" defer></script>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('partials.admin.sidebar')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('partials.admin.navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <div class="row">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Active posts</h6>
                        </div>
                        <div class="card-body">
                            @if(count($products) == 0)
                                <p>No posts</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table table-striped" style="width:100%" id="active">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Location</th>
                                                <th>Price</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($products as $id => $product)
                                                <tr>
                                                    <td>{{$product->title}}</td>
                                                    <td>{{substr($product->description, 0, 120)}}...</td>
                                                    <td>{{$product->location}}</td>
                                                    <td>${{$product->price}}</td>
                                                    <td><a href="/view/{{$product->id}}">View details</a></td>
                                                    <td><a href="/pupdate/{{$product->id}}">Edit</a></td>
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

                <div class="row" style="width:100% !important;">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Deleted posts</h6>
                        </div>
                        <div class="card-body">
                            @if(count($deleted) == 0)
                                <p>No deleted posts</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table table-striped" style="width:100% !important;" id="deleted">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Location</th>
                                                <th>Price</th>
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
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
                                                        </form>
                                                    </td>
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
    $(document).ready(function() {
        $('#active').DataTable();
        $('#deleted').DataTable();
    });
</script>
</body>

</html>

