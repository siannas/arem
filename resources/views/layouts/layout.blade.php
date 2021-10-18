@include('layouts.sidebar')


@php
$role= Auth::user()->getRole->role;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Aplikasi Remaja | @yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href=" {{ asset('public/plugins/fontawesome-free/css/all.min.css') }} " rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('public/css/sb-admin-2.min.css?v=kjhkawhd') }}" rel="stylesheet">
    <!-- Custom styles for validasi -->
    <link href="{{ asset('public/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('public/css/custom.css') }}" rel="stylesheet">
    <!-- Select2 custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @yield('sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    
                    @if($role==='Siswa')
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <button class="btn btn-link d-md-none rounded-circle mr-3 dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" id="menuDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bars"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="menuDropdown">
                            <li><a href="{{ url('/') }}" class="btn btn-light" style="border-color:#fff; width:100%;">Home</a></li>
                            <li><a href="{{ url('/formulir') }}" class="btn btn-light" style="border-color:#fff; width:100%;">Form</a></li>
                            <li><a href="{{ url('/kie') }}" class="btn btn-light" style="border-color:#fff; width:100%;">KIE</a></li>
                        </div>
                    </button>

                    <!-- Topbar Search -->
                    <div
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <a href="{{ url('/') }}" class="btn btn-light" style="border-color:#fff;">Home</a>
                        <a href="{{ url('/formulir') }}" class="btn btn-light">Form</a>
                        <a href="{{ url('/kie') }}" class="btn btn-light">KIE</a>
                    </div>
                    @else
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    @endif
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('publicimg/undraw_profile_1.svg')}}"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{asset('publicimg/undraw_profile_2.svg')}}"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ asset('publicimg/undraw_profile_3.svg') }}"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama }}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('public/img/undraw_profile.svg')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil {!! session()->exists('no-profil') ? '<br><i class="text-danger">*Belum mengisi profil</i>' : '' !!}
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ubahModal">
                                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ubah Password
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Aplikasi Remaja <?php echo date("Y");?></span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Ubah Password Modal-->
    <div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form id="ubah-form" action="{{ url('/ubah-password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Password Lama</b></label>
                        <input type="password" class="form-control" placeholder="Masukkan Password Lama" name="pass_sekarang" id="pass_sekarang">
                    </div>
                    <div class="form-group">
                        <label><b>Password Baru</b></label>
                        <input type="password" class="form-control" placeholder="Masukkan Password Baru" name="pass_baru" id="pass_baru">
                    </div>
                    <div class="form-group">
                        <label><b>Konfirmasi Password Baru</b></label>
                        <input type="password" class="form-control" placeholder="Masukkan Password Baru" name="pass_baru_konfirm" id="pass_baru_konfirm">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
                    <button class="btn btn-primary" type="submit">Ubah</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- Loading Modal -->
    <div class="modal fade" id="loading" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="loadingTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="justify-content: center;">
            <div class="spinner-border text-primary" role="status" style="font-size: 45px;width: 3rem;height: 3rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('public/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('public/plugins/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/js/sb-admin-2.min.js') }}"></script>

    <!-- Dashboard plugins -->
    <script src="{{ asset('public/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- Dashboard custom scripts -->
    <script src="{{ asset('public/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('public/js/demo/chart-pie-demo.js') }}"></script>

    <!-- Tables plugins -->
    <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Tables custom scripts -->
    <script src="{{ asset('public/js/demo/datatables-demo.js') }}"></script>

    <!-- Select2 custom scripts -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('script')
    @stack('scripts')
    
    <script>
        function getFormData($form){
            var unindexed_array = $form.serializeArray();
            var indexed_array = {};

            $.map(unindexed_array, function(n, i){
                var key =n['name'];
                var is_arr=false;
                if(/(\[\d+\])$/.test(key)){
                    key = key.replace( /(\[\d+\])$/, "");
                    is_arr=true;
                }else if(/(\[\])$/.test(key)){
                    key = key.replace( /(\[\])$/, "");
                    is_arr=true;
                }

                if(is_arr && !(key in indexed_array)) indexed_array[key] = [];            
                if(typeof n['value'] === 'string') n['value']=n['value'].trim()

                if(is_arr){
                    indexed_array[key].push( n['value']);
                }else{
                    if(n['value'].length || !(key in indexed_array)){
                        indexed_array[key] = n['value'];
                    }
                }
                
            });

            return indexed_array;
        }

        function getRandomString(length) {
            var randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var result = '';
            for ( var i = 0; i < length; i++ ) {
                result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
            }
            return result;
        }
        
        const myRequest = {
            get: function(url){
                return $.ajax({
                    url: url,
                    type: 'GET',
                });
            },
            post: function(url, data){
                data["_token"] = "{{ csrf_token() }}"
                return $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                });
            },
            delete: function(url){
                const data = {"_token" : "{{ csrf_token() }}"}
                return $.ajax({
                    url: url,
                    method: 'DELETE',
                    data: data,
                });
            },
            put: function(url, data){
                data["_token"] = "{{ csrf_token() }}"
                return $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data,
                });
            },
            upload: function(url, formdata){
                console.log(url)
                // return
                return $.ajax({
                    xhr : function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e){
                            if(e.lengthComputable){
                                // console.log('Bytes Loaded : ' + e.loaded);
                                // console.log('Total Size : ' + e.total);
                                // console.log('Persen : ' + (e.loaded / e.total));
                                
                                // var percent = Math.round((e.loaded / e.total) * 100);
                                
                                // $('#progressBar').attr('aria-valuenow', percent).css('width', percent + '%').text(percent + '%');
                            }
                        });
                        return xhr;
                    },
                    url: url,
                    method: 'POST',
                    data: formdata,
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                });
            },
        }
    </script>
</body>

</html>