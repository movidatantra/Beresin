@extends('layouts.mitra')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-body p-4">

        <h4 class="fw-bold mb-4">

            Tambah Layanan

        </h4>

        <form action="/services"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- NAMA -->

            <div class="mb-3">

                <label class="fw-semibold">
                    Nama Layanan
                </label>

                <input type="text"
                       name="name"
                       class="form-control rounded-3">

            </div>

            <!-- KATEGORI -->
            <div class="mb-3">
<label class="fw-semibold">
                    Kategori
                </label>

            <select name="category"
        class="form-select rounded-4">

    <option value="Service AC">
        Service AC
    </option>

    <option value="Service Pompa Air">
        Service Pompa Air
    </option>

    <option value="Service Mesin Cuci">
        Service Mesin Cuci
    </option>

    <option value="Sofa Cleaning">
        Sofa Cleaning
    </option>

    <option value="Cuci Kasur">
        Cuci Kasur
    </option>

    <option value="Cuci Karpet">
        Cuci Karpet
    </option>

    <option value="Laundry">
        Laundry
    </option>

</select></div>

            <!-- HARGA -->

            <div class="mb-3">

                <label class="fw-semibold">
                    Harga
                </label>

                <input type="number"
                       name="price"
                       class="form-control rounded-3">

            </div>

            <!-- DURASI -->

            <div class="mb-3">

                <label class="fw-semibold">
                    Estimasi Pengerjaan
                </label>

                <input type="text"
                       name="duration"
                       placeholder="Contoh: 2 Jam"
                       class="form-control rounded-3">

            </div>

            <!-- STATUS -->

            <div class="mb-3">

                <label class="fw-semibold">
                    Status
                </label>

                <select name="status"
                        class="form-control rounded-3">

                    <option value="aktif">
                        Aktif
                    </option>

                    <option value="nonaktif">
                        Nonaktif
                    </option>

                </select>

            </div>

            <!-- GAMBAR -->

            <div class="mb-3">

                <label class="fw-semibold">
                    Gambar Layanan
                </label>

                <input type="file"
                       name="image"
                       class="form-control rounded-3">

            </div>

            <!-- DESKRIPSI -->

            <div class="mb-4">

                <label class="fw-semibold">
                    Deskripsi
                </label>

                <textarea name="description"
                          rows="5"
                          class="form-control rounded-3"></textarea>

            </div>

            <button class="btn btn-primary rounded-3 px-4">

                Simpan Layanan

            </button>

        </form>

    </div>

</div>

@endsection