@extends('layout/front')
@section('title', 'Login Admin')

@section('add_style')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset("assets/css/Login-Form-Dark.css") }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
@endsection

@section('body')
<div class="login-dark" style="height: 730px;">
    <form id="form_login">
        @csrf
        <h1 class="text-center">A D M I N</h1>
        <div class="illustration" style="padding: 0px;"><i class="fa fa-user-secret" style="color: rgb(255,255,255);"></i></div>
        {{-- <div class="form-group">
            <input class="form-control text-center" type="text" name="username" placeholder="Username">
        </div>
        <div class="form-group">
            <input class="form-control text-center" type="password" name="password" placeholder="Password">
        </div> --}}
        <div class="form-group">
            <a onclick="sigin()" class="btn btn-primary btn-block">Sign In</a>
        </div>
    </form>
</div>
@endsection

@section('add_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    function sigin(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/admin',
            timeout: 2000,
            data: {
                // username: $('#form_login input[name=username]').val(),
                // password: $('#form_login input[name=password]').val(),
                username: 'admin',
                password: 'admin',
            },
            beforeSend: function(){
                Swal.fire({
                    title: 'Loading...',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            },
            success: function(data){
                Swal.close();
                window.location.reload();
            },
            error: function(data, errortype){
                Swal.close();
                if(errortype == 'timeout'){
                    Swal.fire({
                        title: 'Connection Time Out!',
                        icon: 'warning',
                        showConfirmButton: true,
                    });
                }else{
                    toastr.options = {
                        "preventDuplicates": true,
                        "timeOut": "1000",
                    };
                    toastr["error"]("User Not Found! or Mismatch!");
                }
            }
        });
    }
</script>
@endsection
