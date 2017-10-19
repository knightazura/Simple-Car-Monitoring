<div class="card" id="home-main-form">
  <div class="card-header">
    <b>Form Permohonan Peminjaman Kendaraan</b>
  </div>
  <div class="card-body">    
    <form action="{{ route('car-usage.store') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="employeeName">Nama Pemohon (Pegawai)</label>
        <example-component></example-component>
      </div>
      <div class="form-group">
        <label for="company">Mobil</label>
        <input type="text" name="company" class="form-control" id="company" aria-describedby="company" placeholder="Contoh: PT. IPS">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
