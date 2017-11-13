<!-- Nama Pegawai -->
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->requestedBy->employee_name }} ({{ $usage->nip }})</h6>
<p class="card-text text-secondary">
  <small>Nama Pegawai (Pemohon)</small>
</p>

<!-- Jabatan & Divisi Pegawai -->
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->requestedBy->employee_position }} / {{ $usage->requestedBy->division }}</h6>
<p class="card-text text-secondary">
  <small>Jabatan / Divisi</small>
</p>

<!-- Data Sopir -->
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->drivenBy->driver_name }} ({{ $usage->drivenBy->company }})</h6>
<p class="card-text text-secondary">
  <small>Nama Sopir</small>
</p>

<!-- Data Sopir Pengganti (Jika ada) -->
@if (!is_null($usage->backup_driver_id))
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->backupDrivenBy->driver_name }} ({{ $usage->backupDrivenBy->company }})</h6>
<p class="card-text text-secondary">
  <small>Sopir Pengganti</small>
</p>
@endif

<!-- Data Kendaraan yang dipakai -->
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->car_plat_number }} ({{ $usage->carStatus->theCar->car_name }})</h6>
<p class="card-text text-secondary">
  <small>Kendaraan yang dipakai</small>
</p>

<!-- Jumlah Penumpang -->
<h6 class="card-title" style="margin-bottom: 0.3em">{{ $usage->total_passengers }} orang</h6>
<p class="card-text text-secondary">
  <small>Jumlah penumpang</small>
</p>

<!-- Keperluan -->
<h6 class="card-title" style="margin-bottom: 0">{{ $usage->necessity }}</h6>
<p class="card-text text-secondary">
  <small>Keperluan</small>
</p>

<!-- Keperluan -->
<h6 class="card-title" style="margin-bottom: 0">{{ $usage->fuel_status }} ({{ $usage->fuel_usage }} L)</h6>
<p class="card-text text-secondary">
  <small>Status BBM</small>
</p>

<!-- Waktu keberangkatan -->
<h6 class="card-title" style="margin-bottom: 0">{{ $usage->desire_time }}</h6>
<p class="card-text text-secondary">
  <small>Waktu keberangkatan yang diinginkan</small>
</p>

<!-- Perkiraan waktu pemakaian -->
<h6 class="card-title" style="margin-bottom: 0">{{ $usage->estimates_time }} hari</h6>
<p class="card-text text-secondary">
  <small>Perkiraan waktu pemakaian kendaraan</small>
</p>

<!-- Keterangan tambahan -->
<h6 class="card-title" style="margin-bottom: 0">
  @if(!empty($usage->additional_description))
    {{ $usage->additional_description }}
  @else
    -
  @endif
</h6>
<p class="card-text text-secondary">
  <small>Keterangan tambahan</small>
</p>
