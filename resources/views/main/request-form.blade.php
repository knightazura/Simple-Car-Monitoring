<div class="card" id="home-main-form">
  <div class="card-header">
    <b>Form Pengajuan Pemakaian Kendaraan</b>
  </div>
  <request-form csrf-token="{{ csrf_token() }}" meta="{{ $meta }}" entity_id="{{ $id }}">
    <!-- Main Request form here using VueJS Component -->
  </request-form>
</div>
