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
    <link href="{{asset('css/app.css') }}" rel="stylesheet">
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
                            <h6 class="m-0 font-weight-bold text-primary">Active users</h6>
                        </div>
                        <div class="card-body">
                            @if(count($users) == 0)
                                <p>No users in database</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table table-striped" style="width:100%" id="active">
                                            <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Lastname</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Registration date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $id => $user)
                                                <tr scope="row">
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->lastname}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{ucfirst($user->role)}}</td>
                                                    <td>{{$user->created_at}}</td>
                                                    <td>
                                                        @php
                                                        /*
                                                             * -1: user is denied of the upload, and has to re-upload picture id
                                                             * 0 : user is created, hasn't uploaded picture id
                                                             * 1 : user is created, uploaded id and verified(approved by admin)
                                                             * 2 : user is created, uploaded id, awaiting verification*/
                                                            switch($user->is_verified){
                                                            case '-1':
                                                                echo "Denied ID, needs to reupload";
                                                                break;
                                                            case '0':
                                                                echo 'No picture ID uploaded';
                                                                break;
                                                            case '1':
                                                                echo 'Verified';
                                                                break;
                                                            case '2':
                                                                echo 'Pending verification';
                                                                break;
                                                            }
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        <a href="/delete"
                                                           onclick="event.preventDefault(); document.getElementById('{{$user->id}}').submit();">
                                                            <button type="button" class="close" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </a>
                                                        <form id="{{$user->id}}" action="/delete" method="POST" style="display: none;">
                                                            <input type="hidden" name="id" value="{{$user->id}}" >
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

                <div class="row">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Deleted users</h6>
                        </div>
                        <div class="card-body">
                            @if(count($deleted) == 0)
                                <p>No deleted users</p>
                            @else
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <table class="table table-striped" style="width:100% !important;" id="deleted">
                                            <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Lastname</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Registration date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($deleted as $id => $user)
                                                <tr scope="row">
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->lastname}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>{{ucfirst($user->role)}}</td>
                                                    <td>{{$user->created_at}}</td>
                                                    <td>
                                                        @php
                                                            /*
                                                                 * -1: user is denied of the upload, and has to re-upload picture id
                                                                 * 0 : user is created, hasn't uploaded picture id
                                                                 * 1 : user is created, uploaded id and verified(approved by admin)
                                                                 * 2 : user is created, uploaded id, awaiting verification*/
                                                                switch($user->is_verified){
                                                                case '-1':
                                                                    echo "Denied ID, needs to reupload";
                                                                    break;
                                                                case '0':
                                                                    echo 'No picture ID uploaded';
                                                                    break;
                                                                case '1':
                                                                    echo 'Verified';
                                                                    break;
                                                                case '2':
                                                                    echo 'Pending verification';
                                                                    break;
                                                                }
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        <a href="/restore"
                                                           onclick="event.preventDefault(); document.getElementById('{{$user->id . '_' . $user->id}}').submit();">
                                                            <button type="button" class="close" aria-label="Close">
                                                                <i class="fa fa-undo" aria-hidden="true"></i>
                                                            </button>
                                                        </a>
                                                        <form id="{{$user->id . '_' . $user->id}}" action="/restore" method="POST" style="display: none;">
                                                            <input type="hidden" name="id" value="{{$user->id . '_' . $user->id}}" >
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
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148323450-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-148323450-1');
    $(document).ready(function() {
        $('#active').DataTable();
        $('#deleted').DataTable();
    });
</script>

</body>

</html>

