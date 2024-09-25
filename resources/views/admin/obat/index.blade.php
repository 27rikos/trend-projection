@extends('partials.main')
@section('title', 'Obat')
@section('main')
    <div class="content-wrapper">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('medicine.index') }}">Data Obat</a></li>
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
        </nav>
        <div class="card">
            <div class="card-header">
                <div class="">
                    <a href="{{ route('medicine.create') }}" class="btn btn-primary btn-sm">Tambah</a>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success text-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#import">
                        Import
                    </button>

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
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger text-light"
                                        data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary">Import</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive pt-3">
                    <table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Obat</th>
                                <th>Jenis Obat</th>
                                <th>Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> 1 </td>
                                <td> Herman Beck </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%"
                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 77.99 </td>
                                <td> May 15, 2015 </td>
                            </tr>
                            <tr>
                                <td> 2 </td>
                                <td> Messsy Adam </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 75%"
                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $245.30 </td>
                                <td> July 1, 2015 </td>
                            </tr>
                            <tr>
                                <td> 3 </td>
                                <td> John Richards </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 90%"
                                            aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $138.00 </td>
                                <td> Apr 12, 2015 </td>
                            </tr>
                            <tr>
                                <td> 4 </td>
                                <td> Peter Meggik </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 77.99 </td>
                                <td> May 15, 2015 </td>
                            </tr>
                            <tr>
                                <td> 5 </td>
                                <td> Edward </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: 35%"
                                            aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 160.25 </td>
                                <td> May 03, 2015 </td>
                            </tr>
                            <tr>
                                <td> 6 </td>
                                <td> John Doe </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 65%"
                                            aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 123.21 </td>
                                <td> April 05, 2015 </td>
                            </tr>
                            <tr>
                                <td> 7 </td>
                                <td> Henry Tom </td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 20%"
                                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </td>
                                <td> $ 150.00 </td>
                                <td> June 16, 2015 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
