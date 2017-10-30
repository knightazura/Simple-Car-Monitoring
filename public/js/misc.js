// Tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// SweetAlert delete
$(document).on('click', '.delete-button', function (e) {
  e.preventDefault();

  var id = $(this).data('id');
  var token = $(this).data('token');
  SwalDelete(id, token);
});

function SwalDelete(entityId, token) {
  swal({
    title: "Apakah anda yakin ingin menghapus data ini?",
    text: "Sekali dihapus datanya tidak akan bisa dikembalikan!",
    icon: "warning",
    buttons: true,
    dangerMode: true
  })
  .then((willDelete) => {
    if (willDelete) {
      $.ajax({
        type: 'POST',
        url: entityId,
        data: { '_method': 'DELETE', '_token': token }
      })
      .done(function (response) {
        swal(response.data.message, {
          icon: "success",
        }).
        then(function () {
          window.location.href = response.data.redirect_url;
        });
      });
    }
  });
}
