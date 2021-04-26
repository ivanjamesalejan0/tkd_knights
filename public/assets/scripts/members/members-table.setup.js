$(function () {
  // datatable with paging options and live search
  $('#featured-datatable').dataTable({
    sDom: "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
  });
});

function deleteMember(id) {
  swal({
    title: 'Archive Member',
    text: 'Are you sure you want to archive this member?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#F9354C',
    cancelButtonColor: '#41B314',
    confirmButtonText: 'Archive',
    allowOutsideClick: false
  }).then(function () {
    $.ajax({
        url: 'members/' + id,
        type: 'DELETE',
        dataType: 'json',
        data: $('#app-form').serialize(),
        beforeSend: function (xhr) {
          xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
        }
      })
      .success(function (data) {
        if (data.success === true) {
          var message = $("<div class='text-left'></div>").html(data.message);
          var ul = $("<ul></ul>");
          $.each(data.data, function (index, val) {
            ul.append('<li><strong>' + index + '</strong></li>');
            var ul_ul = $("<ul></ul>");
            $.each(val, function (i, v) {
              ul_ul.append('<li>' + v + '</li>');
            });
            ul.append(ul_ul);
          });
          message.append(ul);
          swal({
            title: data.title,
            html: message,
            type: 'success',
            allowOutsideClick: false
          }).then(function () {
            loadView(returnURL);
          }).catch(swal.noop);
        } else {
          $('#app-form .help-block.form-error').remove();
          $('#app-form .form-control-container').removeClass('has-error');
          var message = $("<div class='text-left'></div>").html(data.message);
          var ul = $("<ul></ul>");
          $.each(data.errors, function (index, val) {
            ul.append('<li><strong>' + index + '</strong></li>');
            var ul_ul = $("<ul></ul>");
            $.each(val, function (i, v) {
              ul_ul.append('<li>' + v + '</li>');
              $('#app-form *[name="' + index + '"]').parents('.form-control-container').append('<div class="help-block form-error">' + v + '</div>');
            });
            $('#app-form *[name="' + index + '"]').parents('.form-control-container').addClass('has-error');
            ul.append(ul_ul);
          });
          message.append(ul);
          swal({
            title: data.title,
            html: message,
            type: 'error',
            allowOutsideClick: false
          }).catch(swal.noop);
        }
        $('#submit-form').removeClass('disabled');
      })
      .fail(function (data) {
        if (data.statusText != "canceled") {
          if (data.status === 422) {
            $('#app-form .help-block.form-error').remove();
            $('#app-form .form-control-container').removeClass('has-error');
            var message = $("<div class='text-left'></div>").html(data.responseJSON.message);
            var ul = $("<ul></ul>");
            $.each(data.responseJSON.errors, function (index, val) {
              ul.append('<li><strong>' + index + '</strong></li>');
              var ul_ul = $("<ul></ul>");
              $.each(val, function (i, v) {
                ul_ul.append('<li>' + v + '</li>');
                $('#app-form *[name="' + index + '"]').parents('.form-control-container').append('<div class="help-block form-error">' + v + '</div>');
              });
              $('#app-form *[name="' + index + '"]').parents('.form-control-container').addClass('has-error');
              ul.append(ul_ul);
            });
            message.append(ul);
            swal({
              title: "Oops! Something went wrong",
              html: message,
              type: 'error',
              allowOutsideClick: false
            }).catch(swal.noop);
          } else {
            swal({
              title: "Oops! Something went wrong",
              html: "Please try again",
              type: 'error',
              allowOutsideClick: false
            }).catch(swal.noop);
          }
          $('#submit-form').removeClass('disabled');
        }
      })
      .complete(function (v) {});
  }).catch(swal.noop);

}