// Datatables
$(document).ready(() => {
  $('#dtp').daterangepicker({
    locale: {
      format: 'YYYY-MM-DD'
    }
  });

  $('#dt-history-usage').dataTable({
    "info": false,
    "language": {
      "lengthMenu": "Tampilkan _MENU_ baris"
    }
  })
})
