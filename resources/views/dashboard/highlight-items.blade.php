<?php $current_year = date('Y'); ?>
<!-- Medium & Large viewport -->
<div class="d-none d-sm-none d-md-block">
    <div class="row justify-content-md-center mt-4">
        <div class="col-sm-12 col-md-8">
            <div class="card-deck">
                <!-- 1 -->
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <p class="card-text">JUMLAH MOBIL YANG TERSEDIA</p>
                        <h1 class="display-1">
                            <b>{{ $highlights_data['ac']->count() }}</b>
                        </h1>
                    </div>
                    <div class="card-footer text-right">
                        <a href="#" class="btn btn-sm text-white" data-toggle="modal" data-target="#firstModal">
                            <i class="fa fa-lg fa-bookmark"></i>
                        </a>
                    </div>
                </div>
                <!-- 1 : Modal -->
                <div class="modal fade" id="firstModal" tabindex="-1" role="dialog" aria-labelledby="firstModal" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <table class="table">
                                    <tbody>
                                    @foreach($highlights_data['ac'] as $car)
                                        <tr>
                                            <td>{{ $car->car_plat_number }}</td>
                                            <td>{{ $car->theCar->responsibleBy->withDriver->driver_name }}</td>
                                            <td>
                                                <span class="badge badge-pill badge-{{ $highlights_data['ds'][$car->theCar->responsibleBy->withDriver->status]['class'] }}">
                                                    &nbsp;
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer" style="text-align: left">
                                <small class="text-muted">Keterangan: Badge pada kolom ketiga adalah status Sopir.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div class="card text-white bg-primary">
                    <div class="card-body text-center">
                        <p class="card-text">JUMLAH MOBIL YANG DIPAKAI</p>
                        <h1 class="display-1">
                            <b>{{ $highlights_data['uc']->count() }}</b>
                        </h1>
                    </div>
                    <div class="card-footer text-right">
                        <a href="#" class="btn btn-sm text-white" data-toggle="modal" data-target="#secondModal">
                            <i class="fa fa-lg fa-bookmark"></i>
                        </a>
                    </div>
                </div>
                <!-- 2 : Modal -->
                <div class="modal fade" id="secondModal" tabindex="-1" role="dialog" aria-labelledby="secondModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                @if ($highlights_data['uc']->count() > 0)
                                    <table class="table">
                                        <thead>
                                            <th>KENDARAAN</th>
                                            <th>PEMOHON</th>
                                            <th>KEPERLUAN</th>
                                            <th>TUJUAN</th>
                                            <th>&nbsp;</th>
                                        </thead>
                                        <tbody>
                                        @foreach($highlights_data['uc'] as $car)
                                            <tr>
                                                <td>{{ $car->car_plat_number }}</td>
                                                <td>{{ $car->usage->requestedBy->employee_name }}</td>
                                                <td>{{ $car->usage->necessity }}</td>
                                                <td>{{ $car->usage->destination }}</td>
                                                <td>
                                                    <a href="{{ route('car-usage.show', $car->usage->id) }}">
                                                        <i class="fa fa-bookmark"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="alert alert-info" role="alert">
                                        Tidak ada pemakaian kendaraan.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3 Fuel  -->
                <div class="card text-white bg-info">
                    <div class="card-body text-center">
                        <p class="card-text">SISA BBM BULAN {{ strtoupper(date('F')) }}</p>
                        <h1 class="display-3">
                            <b>{{ $highlights_data['fs'] }} L</b>
                        </h1>
                    </div>
                    @if (Auth::user()->roles[0]->id == 1)
                        <div class="card-footer text-right">
                            <a href="{{ route('fuel-custom-index', $current_year) }}" class="btn btn-sm text-white">
                                <i class="fa fa-lg fa-bookmark"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Small viewport -->
<div class="row d-block d-sm-block d-md-none justify-content-md-center mt-4">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <p class="card-text">JUMLAH MOBIL YANG TERSEDIA</p>
                        <h1 class="text-center display-1">
                            <b>{{ $highlights_data['ac'] }}</b>
                        </h1>
                    </div>
                    <div class="card-footer text-right">
                        <a href="#" class="btn btn-sm text-white" data-toggle="modal" data-target="#firstModal">
                            <i class="fa fa-lg fa-bookmark"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mt-2">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <p class="card-text">JUMLAH MOBIL YANG DIGUNAKAN</p>
                        <h1 class="text-center display-1">
                            <b>{{ $highlights_data['uc'] }}</b>
                        </h1>
                    </div>
                    <div class="card-footer text-right">
                        <a href="#" class="btn btn-sm text-white" data-toggle="modal" data-target="#secondModal">
                            <i class="fa fa-lg fa-bookmark"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mt-2">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <p class="card-text">PEMAKAIAN BBM</p>
                        <h1 class="text-center display-5">
                            378/500 L
                        </h1>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('fuel-custom-index', $current_year) }}" class="btn btn-sm text-white">
                            <i class="fa fa-lg fa-bookmark"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
