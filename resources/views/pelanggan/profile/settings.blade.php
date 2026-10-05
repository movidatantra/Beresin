@extends('layouts.pelanggan')

@section('content')

<div class="container py-4">

    <div class="row g-4">

        <!-- SIDEBAR -->
        <div class="col-lg-3">

            @include('pelanggan.profile.sidebar')

        </div>

        <!-- CONTENT -->
        <div class="col-lg-9">

            <div class="card profile-card">

                <div class="card-body p-5">

                    <h2 class="fw-bold">

                        Pengaturan Akun

                    </h2>

                    <p class="text-muted">

                        Kelola keamanan dan pengaturan akun Anda.

                    </p>

                    <hr>

                    <div class="alert alert-danger rounded-4">

                        <h5 class="fw-bold">

                            <i class="bi bi-trash-fill me-2"></i>

                            Hapus Akun

                        </h5>

                        <p class="mb-4">

                            Jika akun dihapus, seluruh data tidak dapat dikembalikan lagi.

                        </p>

                        <form
                            id="deleteForm"
                            action="/hapus-akun"
                            method="POST">

                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                id="deleteBtn"
                                class="btn btn-danger rounded-pill px-4">

                                <i class="bi bi-trash-fill me-2"></i>

                                Hapus Akun

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@include('pelanggan.profile.style')

<!-- SWEETALERT -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document
.getElementById('deleteBtn')
.addEventListener('click',function(){

    Swal.fire({

        title:'Hapus akun?',

        text:'Semua data akun Anda akan dihapus dan tidak bisa dikembalikan.',

        icon:'warning',

        showCancelButton:true,

        confirmButtonColor:'#dc3545',

        cancelButtonColor:'#6c757d',

        confirmButtonText:'Ya, hapus akun',

        cancelButtonText:'Batal'

    }).then((result)=>{

        if(result.isConfirmed)
        {
            document
            .getElementById('deleteForm')
            .submit();
        }

    });

});

</script>

@endsection