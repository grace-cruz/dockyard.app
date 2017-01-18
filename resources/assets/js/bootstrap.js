
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

require('blueimp-file-upload');
$(function () {
  var url = $('.file-uploader').attr('data-url');
  $('.file-uploader').fileupload({
    url: url,
    dataType: 'json',
    done: function (e, data) {
      $.each(data.result.files, function (index, file) {
        if (file.error) {
          $('<p class="text-danger" />').text(file.name + ' - ' + file.error).appendTo('#files');
        } else {
          $('<p class="text-success" />').text(file.name + ' -uploaded').appendTo('#files');
        }
      });
    },
    progressall: function (e, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      $('#progress .progress-bar').css(
      'width',
      progress + '%'
      );
    }
  }).prop('disabled', !$.support.fileInput)
  .parent().addClass($.support.fileInput ? undefined : 'disabled');
  $('.file-uploader').bind('fileuploadsubmit', function (e, data) {
    $('#progress .progress-bar').animate({width: 0}, 0);
  return true;
  });
  $('.file-uploader').bind('fileuploadalways', function (e, data) {
    $('#progress .progress-bar').css('width', 0);
  });
});

require('select2');
$(".user-select").select2();
/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

// window.Vue = require('vue');
// require('vue-resource');

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */

// Vue.http.interceptors.push((request, next) => {
//     request.headers.set('X-CSRF-TOKEN', Laravel.csrfToken);
//
//     next();
// });

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
