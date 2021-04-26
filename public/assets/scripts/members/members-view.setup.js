function attendanceUpdate(id){

  var formData = new FormData();
  formData.append('id', id);

  $.ajax({
    url: `members/${id}/attendance/update`,
    type: 'POST',
    data: formData,
    dataType: 'json',
    processData: false,
    contentType: false,
    beforeSend: function (xhr) {
      xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));
    }
  })
  .success(function (data) {
    if(data.success){
      swal({
        title: "Success!",
        html: "Attendance has been updated",
        type: 'success',
        allowOutsideClick: false
      }).catch(swal.noop);
    }else{
      swal({
        title: "Oops! Something went wrong",
        html: "Failed to update attendance",
        type: 'error',
        allowOutsideClick: false
      }).catch(swal.noop);
    }
    console.log('Save successfully: ',data);
  })
  .fail(function (data) {
    swal({
      title: "Oops! Something went wrong",
      html: "Failed to update attendance",
      type: 'error',
      allowOutsideClick: false
    });
    console.error('Failed image upload');
  });
}