@extends('partials.main')
@section('title', 'Penjualan')
@section('main')
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block card mb-0">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title border-bottom pb-2 mb-2">
                                <h4 class="mb-0">Data Penjualan Obat</h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('sales.index') }}"><i
                                            class="ph ph-house"></i></a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Penjualan Obat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="">
                            <div class=" d-flex justify-content-between">
                                <div class="">
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm"><i
                                            class="fa-solid fa-plus me-1"></i>Tambah</a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success text-light btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#import"><i class="fa-solid fa-file-import me-1"></i>
                                        Import
                                    </button>
                                </div>
                                <a href="{{ route('reset') }}" class="btn btn-danger btn-sm"><i
                                        class="fa-solid fa-trash-can me-1"></i>Drop</a>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Import Data Obat</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('import-sales') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="file" class="form-input" name="file" accept=".xlsx,.csv">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger text-light"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive pt-3">
                            <table class="table table-bordered" id="example" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F Y') }}</td>
                                            <td>
                                                {{ $item->obat }}
                                            </td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('sales.edit', $item->id) }}"
                                                        class="btn btn-info btn-sm">Edit</a>
                                                    <form action="{{ route('sales.destroy', $item->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
