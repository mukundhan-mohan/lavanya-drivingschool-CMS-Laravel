<script src="{{ url('froala_editor/js/froala_editor.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/align.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/char_counter.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/code_beautifier.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/code_view.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/colors.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/draggable.min.js') }}"></script>

  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/entities.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/file.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/font_size.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/font_family.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/fullscreen.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/image.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/line_breaker.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/inline_class.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/inline_style.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/link.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/lists.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/paragraph_format.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/paragraph_style.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/quick_insert.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/quote.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/table.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/save.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/url.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/video.min.js') }}"></script>
  <script type="text/javascript" src="{{ url('froala_editor/js/plugins/quick_insert.min.js') }}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script type="text/javascript">
     FroalaEditor.DefineIcon('imageInfo', {NAME: 'info', SVG_KEY: 'help'});
    FroalaEditor.RegisterCommand('imageInfo', {
      title: 'Info',
      focus: false,
      undo: false,
      refreshAfterCallback: false,
      callback: function () {
        var $img = this.image.get();
        alert($img.attr('src'));
      }
    });
    
    new FroalaEditor('.ckeditor', {
       key : "{{ env('FROALAKEY') }}",
       fontSize: ['18', '21', '24'],
       attribution : false,
       imageUploadParam: 'image_param',

      // Set the image upload URL.
      imageUploadURL: "{{ url('froala/upload_image') }}",

      // Additional upload params.
      imageUploadParams: {id: 'my_editor'},

      // Set request type.
      imageUploadMethod: 'POST',

      // Set max image size to 5MB.
      imageMaxSize: 5 * 1024 * 1024,

      // Allow to upload PNG and JPG.
      imageAllowedTypes: ['jpeg', 'jpg', 'png'],

      events: {
        'image.beforeUpload': function (images) {
          // Return false if you want to stop the image upload.
        },
        'image.uploaded': function (response) {
          // Image was uploaded to the server.
        },
        'image.inserted': function ($img, response) {
          // Image was inserted in the editor.
        },
        'image.replaced': function ($img, response) {
          // Image was replaced in the editor.
        },
        'image.error': function (error, response) {
          // Bad link.
          console.log(error);
          console.log(response);
          if (error.code == 1) {  }

          // No link in upload response.
          else if (error.code == 2) {  }

          // Error during image upload.
          else if (error.code == 3) {  }

          // Parsing response failed.
          else if (error.code == 4) {  }

          // Image too text-large.
          else if (error.code == 5) {  }

          // Invalid image type.
          else if (error.code == 6) {  }

          // Image can be uploaded only to same domain in IE 8 and IE 9.
          else if (error.code == 7) {  }

          // Response contains the original server response to the request if available.
        }
      },

      fileUploadParam: 'file_param',

      // Set the file upload URL.
      fileUploadURL: "{{ url('froala/upload_file') }}",

      // Additional upload params.
      fileUploadParams: {id: 'my_editor'},

      // Set request type.
      fileUploadMethod: 'POST',

      // Set max file size to 20MB.
      fileMaxSize: 20 * 1024 * 1024,

      // Allow to upload any file.
      fileAllowedTypes: ['*'],

      events: {
        'file.beforeUpload': function (files) {
          // Return false if you want to stop the image upload.
          console.log(files);
        },
        'file.uploaded': function (response) {
          // Image was uploaded to the server.
          console.log(response);
        },
        'file.inserted': function ($img, response) {
          // Image was inserted in the editor.
          console.log(response);
        },
        'file.replaced': function ($img, response) {
          // Image was replaced in the editor.
          console.log(response);
        },
        'file.error': function (error, response) {
          // Bad link.
          console.log(error);
          console.log(response);
          if (error.code == 1) {  }

          // No link in upload response.
          else if (error.code == 2) {  }

          // Error during image upload.
          else if (error.code == 3) {  }

          // Parsing response failed.
          else if (error.code == 4) {  }

          // Image too text-large.
          else if (error.code == 5) {  }

          // Invalid image type.
          else if (error.code == 6) {  }

          // Image can be uploaded only to same domain in IE 8 and IE 9.
          else if (error.code == 7) {  }

          // Response contains the original server response to the request if available.
        }
      },

       videoUploadParam: 'video_param',

      // Set the video upload URL.
      videoUploadURL: "{{ url('froala/upload_video') }}",

      // Additional upload params.
      videoUploadParams: {id: 'my_editor'},

      // Set request type.
      videoUploadMethod: 'POST',

      // Set max video size to 50MB.
      videoMaxSize: 50 * 1024 * 1024,

      // Allow to upload MP4, WEBM and OGG
      videoAllowedTypes: ['webm', 'mp4', 'ogg'],

      events: {
        'video.beforeUpload': function (videos) {
          // Return false if you want to stop the image upload.
        },
        'video.uploaded': function (response) {
          // Image was uploaded to the server.
        },
        'video.inserted': function ($img, response) {
          // Image was inserted in the editor.
        },
        'video.replaced': function ($img, response) {
          // Image was replaced in the editor.
        },
        'video.error': function (error, response) {
          // Bad link.
          console.log(error);
          console.log(response);
          if (error.code == 1) {  }

          // No link in upload response.
          else if (error.code == 2) {  }

          // Error during image upload.
          else if (error.code == 3) {  }

          // Parsing response failed.
          else if (error.code == 4) {  }

          // Image too text-large.
          else if (error.code == 5) {  }

          // Invalid image type.
          else if (error.code == 6) {  }

          // Image can be uploaded only to same domain in IE 8 and IE 9.
          else if (error.code == 7) {  }

          // Response contains the original server response to the request if available.
        }
      },

      // Set image buttons, including the name
      // of the buttons defined in customImageButtons.
      imageEditButtons: ['imageReplace', 'imageAlign', 'imageRemove', '|', 'imageLink', 'linkOpen', 'linkEdit', 'linkRemove', '-', 'imageDisplay', 'imageAlt', 'imageSize'],
      // Define new inline styles.
      inlineClasses: {
        'fr-class-code': 'Code',
        'fr-class-highlighted': 'Highlighted',
        'fr-class-transparency': 'Transparent'
      },
      inlineStyles: {
        'Big Red': 'font-size: 20px; color: red;',
          'Small Blue': 'font-size: 14px; color: blue;',
          'Big green': 'font-size: 20px; color: green;',
      },

      linkStyles: {
          "cta-download": 'Download',
          "fr-info": 'Info'
      },
      paragraphFormat: {
        N: 'Normal',
        H1: 'Heading 1',
        H2: 'Heading 2',
        H3: 'Heading 3'
      }
    });
  </script>