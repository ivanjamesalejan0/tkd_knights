$(function () {
  $.validate({});

  Webcam.set({
    width: 320,
    height: 240,
    image_format: 'jpeg',
    jpeg_quality: 90
  });

  $('#camera-modal').on('shown.bs.modal', function () {
    Webcam.attach('#webcam');
  });

  $('#camera-modal').on('hidden.bs.modal', function () {
    Webcam.reset('#my_camera');
  });

  $('#app-form').on('submit', function (e) {
    return false;
  })

  $('#submit-form').on('click', function (e) {
    e.preventDefault();
    $.ajax({
        url: $('#app-form').attr('action'),
        type: 'POST',
        dataType: 'json',
        data: $('#app-form').serialize(),
        beforeSend: function (xhr) {
          $('#app-form').submit();
          if ($('#app-form').find('.has-error .error').length > 0) {
            xhr.abort();
          }
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
  })

});

function take_snapshot() {
  // take snapshot and get image data
  Webcam.snap(function (data_uri) {
    // display results in page
    document.getElementById('results').innerHTML =
      '<img id="imageprev" src="' + data_uri + '"/>';
  });

  var base64image = document.getElementById("imageprev").src;
  upload(base64image, 'members/upload-image');
}

function upload(image_data_uri, target_url) {
  // submit image data to server using binary AJAX
  var form_elem_name = 'webcam';

  // detect image format from within image_data_uri
  var image_fmt = '';
  if (image_data_uri.match(/^data\:image\/(\w+)/))
    image_fmt = RegExp.$1;
  else
    throw "Cannot locate image format in Data URI";

  // extract raw base64 data from Data URI
  var raw_image_data = image_data_uri.replace(/^data\:image\/\w+\;base64\,/, '');

  // create a blob and decode our base64 to binary
  var blob = new Blob([base64DecToArr(raw_image_data)], {
    type: 'image/' + image_fmt
  });

  // stuff into a form, so servers can easily receive it as a standard file upload
  var formData = new FormData();
  formData.append(form_elem_name, blob, form_elem_name + "." + image_fmt.replace(/e/, ''));
  formData.append('_token', $('input[name="_token"]').val());

  $.ajax({
    url: target_url,
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
    console.log('Save successfully: ',data);
    $('input[name="image"]').val(data.image);
  })
  .fail(function (data) {
    console.error('Failed image upload');
  });
}

function base64DecToArr(sBase64, nBlocksSize) {
  // convert base64 encoded string to Uintarray
  // from: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
  var sB64Enc = sBase64.replace(/[^A-Za-z0-9\+\/]/g, ""), nInLen = sB64Enc.length,
    nOutLen = nBlocksSize ? Math.ceil((nInLen * 3 + 1 >> 2) / nBlocksSize) * nBlocksSize : nInLen * 3 + 1 >> 2, 
    taBytes = new Uint8Array(nOutLen);
  
  for (var nMod3, nMod4, nUint24 = 0, nOutIdx = 0, nInIdx = 0; nInIdx < nInLen; nInIdx++) {
    nMod4 = nInIdx & 3;
    nUint24 |= b64ToUint6(sB64Enc.charCodeAt(nInIdx)) << 18 - 6 * nMod4;
    if (nMod4 === 3 || nInLen - nInIdx === 1) {
      for (nMod3 = 0; nMod3 < 3 && nOutIdx < nOutLen; nMod3++, nOutIdx++) {
        taBytes[nOutIdx] = nUint24 >>> (16 >>> nMod3 & 24) & 255;
      }
      nUint24 = 0;
    }
  }
  return taBytes;
}
	
function b64ToUint6(nChr) {
  // convert base64 encoded character to 6-bit integer
  // from: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Base64_encoding_and_decoding
  return nChr > 64 && nChr < 91 ? nChr - 65
    : nChr > 96 && nChr < 123 ? nChr - 71
    : nChr > 47 && nChr < 58 ? nChr + 4
    : nChr === 43 ? 62 : nChr === 47 ? 63 : 0;
}