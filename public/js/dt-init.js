// Datatables
$(document).ready(() => {
  $('#dtp').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    }
  });

  $('#dt-history-usage').dataTable({
    "language": {
      "info": "Total rekap data pemakaian kendaraan _TOTAL_",
      "infoFiltered": " - (filter dari _MAX_ data)",
      "infoEmpty": "Tidak ada data rekap pemakaian kendaraan",
      "lengthMenu": "Tampilkan _MENU_ baris"
    }
  })
})
