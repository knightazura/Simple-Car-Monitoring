<?php $no = 1; ?>
@if ($car_usages->isNotEmpty())
    <div class="card">
        <div class="card-header">
            <span style="font-size: 16pt"><b>Dashboard</b></span>
            <a href="{{ route('car-usage-history-index') }}" class="btn btn-sm btn-dark float-right">Rekap</a>
        </div>

        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <p class="card-text">
                Selamat datang {{ $username }} di aplikasi Web Monitoring.
                Berikut daftar status pemakaian kendaraan yang masih berlangsung sampai saat ini.
            </p>
        </div>
        <table class="table table-hover table-responsive">
            <thead>
                <th class="text-center">#</th>
                <th>Pegawai</th>
                <th>Sopir</th>
                <th>Mobil</th>
                <th>Tujuan</th>
            </thead>
            <tbody>
                @foreach($car_usages as $usage)
                <tr>
                    <td class="text-center align-middle" scope="head">
                        <a href="{{ route('car-usage.show', $usage->id) }}">{{ $no++ }}</a>
                    </td>
                    <td class="align-middle">{{ $usage->requestedBy->employee_name }}</td>
                    <td class="align-middle">{{ $usage->drivenBy->driver_name }}</td>
                    <td class="align-middle">{{ $usage->carStatus->theCar->car_name }} ({{ $usage->car_plat_number }})</td>
                    <td class="align-middle">{{ $usage->destination }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="card-footer">
            <a href="{{ route('car-usage.index') }}" class="float-right">
                <small>Selengkapnya</small>
            </a>
        </div>
    </div>
@else
    <div class="card text-white bg-warning">
        <div class="card-header">
            <span style="font-size: 16pt;"><b>Dashboard</b></span>
            <a href="{{ route('car-usage-history-index') }}" class="btn btn-sm btn-dark float-right">Rekap</a>
        </div>
        <div class="card-body">
            {{ Auth::user()->name }}, selamat datang di aplikasi Web Monitoring Kendaraan. <br>
            Untuk saat ini tidak ada catatan untuk permohonan pemakaian kendaraan.
        </div>
    </div>
@endif
