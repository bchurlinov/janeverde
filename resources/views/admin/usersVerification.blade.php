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
                  <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                </div>
                <div class="card-body">
                    @if(count($users) == 0)
                        <p>No pending users for verification</p>
                    @else
                    <div class="card shadow mb-4">
                        <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Lastname</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Registration date</th>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">&nbsp;</th>
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
                                        <a href="#" class="img" data-toggle="modal" data-target="#myModal" >
                                            View uploaded picture
                                            <img height="0" width="0" id="{{$user->id}}" src="{{asset('/pictureID/'.$user->id_pic_name)}}" />

                                        </a>
                                    </td>
                                    <td>
                                        <a href="/approve"
                                           onclick="event.preventDefault(); document.getElementById('{{$user->id}}').submit();">
                                            Approve</a>
                                        <form id="{{$user->id}}" action="/approve" method="POST" style="display: none;">
                                            <input type="hidden" name="id" value="{{$user->id}}" >
                                            @csrf
                                        </form></td>
                                    <td>
                                        <a href="/decline"
                                           onclick="event.preventDefault(); document.getElementById('{{$user->id. '_' . $user->id}}').submit();">
                                        Decline</a>
                                        <form id="{{$user->id. '_' . $user->id}}" action="/decline" method="POST" style="display: none">
                                            <input type="hidden" name="id" value="{{$user->id. '_' . $user->id}}" >
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
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <img class="showimage img-responsive" src="" width="400" height="300" />
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
<style type="text/css">
    .modal-dialog{text-align:center;}
    .modal-content{display:inline-block;}
</style>
  <script>
      $(document).ready(function () {
          $('.img').on('click', function (e) {
              var image = $(this).children('img').attr('src');
              //alert(image);
              console.log(image);
              $('#myModal').on('show.bs.modal', function () {
                  $(".showimage").attr('src', image);
              });
          });
      });
    </script>
</body>

</html>

