/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

var baseurl = $('meta[name="baseurl"]').attr('content');
var csrfToken = $('meta[name="baseurl"]').attr('csrf-token');
var showConsoleLog = false;

$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

 $('.tagsinput').tagsinput({
        confirmKeys: [13, 44],
        freeInput: true,
        typeahead: {                  
            source: function(query) {
              return $.get(window.Laravel.siteBaseUrl+"/ajax/tagnames?term="+query).done(function(data){
                /*if you have add `content-type: application/json` in 
                  server response then no need to parse JSON otherwise,
                  you will need to parse response into JSON.*/
                  console.log(data)
                return data;
              })
            }
        }
   });
  $('.tagsinput').on('itemAdded', function(event) {
      setTimeout(function(){
          $(">input[type=text]",".bootstrap-tagsinput").val("");
      }, 1);
  });
  setTimeout(function(){
    $('.bootstrap-tagsinput input').keydown(function( event ) {
      if ( event.which == 13 ) {
          $(this).blur();
          $(this).focus();
          return false;
      }
  });
  }, 300);

function readURL(input, htmlId) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#'+htmlId).attr('src', e.target.result).show();
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function triggerSingleImagePreview() {
  $(".singleimagepreview").change(function() {
    readURL(this, $(this).attr('data-preview'));
  });
}

triggerSingleImagePreview();

function convertToProgress(buttonId, formId) {
  $("#"+buttonId).addClass("disabled").addClass("btn-progress");
}

function removeErrorClass() {
  $(".form-control").removeClass('has-error');
  $(".help-error").remove();
}
function submitCurrentFrom(formId, buttonId) {
  event.preventDefault();
  var formData = new FormData($('#'+formId)[0]);
  $("#"+buttonId).addClass("disabled").addClass("btn-progress");
  var requestFormat = $("#_request_format").val();
  var modalId = $("#_request_modal").val();
  var requestForm = $("#_request_form").val();
  removeErrorClass();
  $.ajax({
        url: $("#"+formId).attr('action'),
        method: $("#"+formId).attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        success: function(data){
          if(showConsoleLog) {
            console.log(data);
          }
          $("#"+buttonId).removeClass("disabled").removeClass("btn-progress");
          if(requestFormat == 'index') {
            $("#dynamic_table_results").html(data.indexview);
          }
          $("#"+modalId).modal('hide');
          console.log(data.currentRow, requestForm)
          if($("#"+requestForm).length > 0 && data.currentRow) {
            $("#"+requestForm).append(data.currentRow).trigger('change');
          }


        },
        error: function(e) {
            if(showConsoleLog) {
              console.log(data);
            }
            var errors = e.responseJSON.errors;
            $.each(errors, function(key, error) {

                var errorMessage = "";
                $.each(error, function(key, errorname) {
                  console.log(errorname);
                  errorMessage += "<span class='help-error'>"+errorname+"</span>";
                }); 
                $("#"+formId+" #"+key).addClass("has-error").after(errorMessage);
            });

            $("#"+buttonId).removeClass("disabled").removeClass("btn-progress");
        }

  });

	
}

function deleteItem(id) {
	event.preventDefault()
	console.log($("#delete_row_"+id).attr('href'));
	if (confirm('Are you sure want to delete?')) {
      $(".global-popup-loader").show();
    	$.ajax({
	      url: $("#delete_row_"+id).attr('href'),
	      method: 'GET',
	      data: "",
	      success: function(data){
	        if(data.status == 200) {
	        	$("#table_row_"+id).remove();
	        }
          $(".global-popup-loader").hide();
	      },
	      error: function(e) {
	          console.log(e);
            $(".global-popup-loader").hide();
	      }

	    });
	} 
}

if($("#autocomplete").length > 0) {
        var googleplace = new google.maps.places.Autocomplete(document.getElementById('autocomplete'));
        google.maps.event.addListener(googleplace, 'place_changed', function () {
          var place = googleplace.getPlace();
          $('#latitude').val(place.geometry.location.lat());
              $('#longitude').val(place.geometry.location.lng());
                var address = place.address_components;
                var city, state, zip, country;
              if($("#has_other_address").val() == 1) 
              {
                address.forEach(function(component) {
                  var types = component.types;
                  if (types.indexOf('locality') > -1) {
                    city = component.long_name;
                    $('#city').val(city);
                  }
                  
                   if (types.indexOf('postal_town') > -1) {
                    city = component.long_name;
                    $('#city').val(city);
                  }

                  if (types.indexOf('administrative_area_level_1') > -1) {
                    state = component.long_name;
                    console.log(state);
                    $('#state').val(state);
                  }

                  if (types.indexOf('postal_code') > -1) {
                    zip = component.long_name;
                    $('#zip').val(zip);
                  }
                  if (types.indexOf('country') > -1) {
                    country = component.long_name;
                    $('#country').val(country);
                  }
                });
               }
          });
}



function triggerFormCreateUpdate(modalId, requestFormat, method, htmlId, form) {

  event.preventDefault();
  $("#_request_format").val(requestFormat);
  $("#_request_form").val(form);
  $("#"+modalId).modal('show');
  $("#_request_modal").val(modalId);
  var loadUrl = $("#"+htmlId).attr('href');
    $(".global-popup-loader").show();
    $.ajax({
      url: loadUrl,
      method: method,
      data: "",
      success: function(data){
         $("#loadModalDatas").html(data);
        if(data.status == 200) {
          $("#loadModalDatas").html(data);
        }
        $(".global-popup-loader").hide();
        applyRagePicker(); 
      },
      error: function(e) {
          console.log(e);
          $(".global-popup-loader").hide();
      }

    });
}
$(document).ready(function() {
if($(".multipleimageselect").length > 0) {
  if (window.File && window.FileList && window.FileReader) {
    $(document).on('change', 'input.multipleimageselect', function (e) {
    //$(".multiplefileblock .multiplefile").on("change", ".multiplefile.last", function(e) {
    //$(".dynamic-uploaded-image").remove();
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i];
        var fileName = f.name;
        var fileType = f.type;
        console.log(fileType);
        var fileReader = new FileReader();
        fileReader.fileName = fileName;
        fileReader.onload = (function(e) {
          var file = e.target;
          
          //console.log(e.target);
          $("#upload_area_panel").removeClass("one-image-uploaded");
          if($("input.attachedlength").length == 1) {
            $("#upload_area_panel").addClass("one-image-uploaded");
          }
          var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp', 'tiff', 'eps'];
          var pdfExtension = ['pdf', 'pdfs'];
          var splitedImageExtensions = e.target.fileName.split(".").pop();
          var showImage = "<img class=\"imageThumb\" src=\"" + window.Laravel.siteBaseUrl+"/images/icon-uploaded.svg" + "\" title=\"" + file.name + "\" data-name=\"" + e.target.fileName + "\" />" ;
          if(fileType.includes('image')) {
             showImage = "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\" data-name=\"" + e.target.fileName + "\" />" ;
          }else if(fileType.includes('video')) {
             showImage = "<img class=\"imageThumb\" src=\"" + window.Laravel.siteBaseUrl+"/images/video-player.svg" + "\" title=\"" + file.name + "\" data-name=\"" + e.target.fileName + "\" />" ;
          }
          
          checkImageInRemovedImage(e.target.fileName);
          $("<span class=\"dynamic-uploaded-image\" data-name=\"" + e.target.fileName + "\" >" +
            showImage+"<br/>"+
            "<span class='filename'>"+e.target.fileName+"</span>"+
            "<br/><span class=\"dynamic-uploaded-image-remove currentlyuploaded\"><i class='fas fa-trash'></i></i></span>" +
            "</span>").insertAfter("#upload_dynamic_images_here");
          $(".dynamic-uploaded-image-remove.currentlyuploaded").click(function(){
            console.log($(this).parent(".dynamic-uploaded-image").attr('data-name'))
            addRemovedImage($(this).parent(".dynamic-uploaded-image").attr('data-name'));
            if(confirm("Are you sure want to delete this file?")) {
              $(this).parent(".dynamic-uploaded-image").remove();
            }
          });
        });
        fileReader.readAsDataURL(f);
      }
      $(".multiplefileblock .attachments").removeClass('last');
      $('<input type="file" name="attachments[]"  multiple="" class="form-control attachments attachedlength multipleimageselect last" >').insertAfter("#upload_dynamic_files_here");
    });
  } else {
    alert("Your browser doesn't support to File API")
  }

  function checkImageInRemovedImage(image) {
    var removedImages = $("#removedImages").val();
    if(removedImages != "" && removedImages != undefined) {
        var removedImagesArray = removedImages.split(",");
        if($.inArray(image, removedImagesArray) != -1) {
            removedImagesArray.splice( $.inArray(image, removedImagesArray), 1 );
            $("#removedImages").val(removedImagesArray.join(','));
        }
    }
  }

  function addRemovedImage(image) {
    var removedImages = $("#removedImages").val();
    if(removedImages != "" && removedImages != undefined) {
        var images = removedImages.split(',');
        if($.inArray(image, images) === -1) {
            $("#removedImages").val( $("#removedImages").val() + "," + image );
        }
    } else {
        $("#removedImages").val(image);
    }
  }

}

});

function getResortUnitTypes(value) {
  $(".global-popup-loader").show();
      $.ajax({
        url: baseurl+"/koalacmsmgnt/resorts/"+value+"/unit-types",
        method: 'GET',
        data: "",
        success: function(data){
          console.log(data);
          $(".global-popup-loader").hide();
          $("#unit_type_id").html(data.options).select2().removeAttr('disabled');
        },
        error: function(e) {
            console.log(e);
            $(".global-popup-loader").hide();
        }

      });

}

function submitForm(id) {
  $("#"+id).submit();
}

function applyRagePicker() {
        $('.daterangepickerinputnoapply').daterangepicker({
            autoUpdateInput: false,
            //maxDate : new Date()
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

       $('.daterangepickerinput').daterangepicker({
            autoUpdateInput: false,
            //maxDate : new Date()
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

      $('.daterangepickerinputwithfuturedate').daterangepicker({
            autoUpdateInput: false
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

        $('.daterangepickerlav').daterangepicker({
          autoUpdateInput: false,
          //maxDate : new Date()
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

        $('.daterangepickerled').daterangepicker({
          autoUpdateInput: false,
          //maxDate : new Date()
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

        $('.daterangepickerissuedAt').daterangepicker({
          autoUpdateInput: false,
          //maxDate : new Date()
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });

      $('.daterangepickerinputyear').daterangepicker({
            singleDatePicker: true,
            autoUpdateInput: false,
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });
      
       $('.daterangepickerinputyear').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY'));
       });

      $('.daterangepickerinputsingle').daterangepicker({
            format: 'YYYY',
            singleDatePicker: true,
            autoUpdateInput: false,
        }, function(start_date, end_date) {

            //$('.daterangepickerinput').val(start_date.format('MM/DD/YYYY')+' - '+end_date.format('MM/DD/YYYY'));
        });
      
       $('.daterangepickerinputsingle').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY'));
             if($("#advancedSearch-Modal").is(':hidden') || $("#advancedSearch-Modal").length == 0 ) {
                if($("#filter_due_date").length > 0) {
                      $("#filter_due_date").trigger('change');
                    }
            }
       });

       $('.daterangepickerinputnoapply').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
      });

        $('.daterangepickerinput, .daterangepickerinputwithfuturedate').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                if($("#updated_range_quickfilter").length > 0) {
                  $("#updated_range_quickfilter").trigger('change');
                } else {

            }
      });

      $('.daterangepickerinput, .daterangepickerinputwithfuturedate, .daterangepickerinputnoapply').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
      });

      $('.daterangepickerlav').on('apply.daterangepicker', function(ev, picker) {
        $('#from').val("");
        $('#to').val("");
        $(this).val(picker.startDate.format('MM-DD-YYYY') + ' - ' + picker.endDate.format('MM-DD-YYYY'));
        $('#from').val(picker.startDate.format('MM-DD-YYYY'));
        $('#to').val(picker.endDate.format('MM-DD-YYYY'));
        var start = moment(picker.startDate.format('MM-DD-YYYY'),'M/D/YYYY');
        var start_date = moment(picker.startDate.format('MM-DD-YYYY'));
        var start_last_date = moment(picker.startDate.format('MM-DD-YYYY'));
        var first_splitup = start_date.subtract(10, "days").format('MM-DD-YYYY');   
        var second_splitup = start_last_date.subtract(5, "days").format('MM-DD-YYYY');        
        /*$('#invoice_split_up_due_date_1').val(first_splitup);
        $('#invoice_split_up_due_date_2').val(second_splitup);*/
        var dow = start.day();
        if(dow=='0'){
            dow = 7;
        }
    });
    $('.daterangepickerlav').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      $('#from').val("");
      $('#to').val("");
    });

    $('.daterangepickerled').on('apply.daterangepicker', function(ev, picker) {
      $('#exp').val("");
      $(this).val(picker.startDate.format('MM-DD-YYYY') + ' - ' + picker.endDate.format('MM-DD-YYYY'));
      $('#exp').val(picker.startDate.format('MM-DD-YYYY'));
  });
  $('.daterangepickerled').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
    $('#exp').val("");
  });

  $('.daterangepickerissuedAt').on('apply.daterangepicker', function(ev, picker) {
    $('#issuedat').val("");
    $(this).val(picker.startDate.format('MM-DD-YYYY') + ' - ' + picker.endDate.format('MM-DD-YYYY'));
    $('#issuedat').val(picker.startDate.format('MM-DD-YYYY'));
});
$('.daterangepickerissuedAt').on('cancel.daterangepicker', function(ev, picker) {
  $(this).val('');
  $('#issuedat').val("");
});
  

}


 $(document).ready(function () {
        var baseurl = $('meta[name="baseurl"]').attr('content');
        $(".popup-loader").hide();
      
       applyRagePicker();


    });

 function searchMedia() {
    

     var project_category_id = $.trim($("#filter_project_category_id").val());
     var created_range_quickfilter = $.trim($("#filter_created_range_quickfilter").val());
     var filter_name = $.trim($("#filter_name").val());
     var search_place = $.trim($("#filter_search_place").val());

       $(".global-popup-loader").show();
       $("#media_manager_library").show().html("");
          $.ajax({
            url: window.Laravel.siteBaseUrl+"/file-manager/search",
            method: 'GET',
            data: "project_category_id="+project_category_id+"&created_at="+created_range_quickfilter+"&name="+filter_name+"&search_place="+search_place,
            success: function(res){
              console.log(res);
              $(".global-popup-loader").hide();
              $("#media_manager_library").show().html(res.data);
              setTimeout(function(){ 
                bindPaginationLink("media_manager_library");
               }, 100);
              //$("#sub_audience_id").html(data.options).select2().removeAttr('disabled');
            },
            error: function(e) {
                console.log(e);
                $(".global-popup-loader").hide();
            }
          });

  }

  function resetForm(formId) {
    $("#"+formId)[0].reset();
    $("#filter_name").val("");
    $("#filter_project_category_id").val("");
    $("#filter_created_range_quickfilter").val("");
    searchMedia()
  }

  function bindPaginationLink(htmlId) {
    $("#filter_project_category_id").select2();
    applyRagePicker();
    $('.pagination-filter a').click(function(e) {
          e.preventDefault();
          $("#media_manager_library").show().html("");
          $(".global-popup-loader").show();
          var url = $(this).attr('href');
          $.ajax({
              url: url,
              success: function(res) {
                  $(".global-popup-loader").hide();
                    $("#"+htmlId).show().html(res.data);
                   setTimeout(function(){ 
                  bindPaginationLink(htmlId);
                 }, 100);
              },
              error: function(e) {
              }
          });
      });
  }

  function showMediaLink(id) {
    $(".media_viewable_path").hide();
    $(".copied").hide();
    $("#media_viewable_path_"+id).show();
  }

  function copyFilePath(id) {
    $("#media_viewable_path_"+id).select();
      document.execCommand("copy");
      $(".copied").hide();
      $("#copied_"+id).show();
      setTimeout(function(){ 
      $("#copied_"+id).hide();
    }, 3000);
  }

  function setMediaTags(place) {
      $("#choose_media_button").hide();
      if($("#search_place").length > 0) {
        $("#search_place").val(place);
        $("#search_type option").removeAttr('disabled');
        $("#media_manager_library").html("");
        if(place == 'hero') {
          $("#media_type_file").attr('disabled', 'disabled');
           $("#choose_media_button").show();
        }
        if(place == 'thumbnail') {
           $("#choose_media_button").show();
            $("#media_type_file, #media_type_video").attr('disabled', 'disabled');
        }
         $("#search_type").select2().trigger("change");
         
      }
  }

  function selectMedia(id) {
    $(".media-manager-panel").removeClass("selected");
    $("#media_manager_panel_"+id).addClass("selected");
    $("#choose_media_button").removeClass("disabled");
    
  }

  function chooseFile() {
    if($(".media-manager-panel.selected").length == 0) {
      alert("Please choose a file");
      return false;
    }
    $("#filter_search_place").val("");
    $("#mediaManagerModal").modal('hide');
    var id = $(".media-manager-panel.selected").attr('data-id');
    var fileName = $("#f_in_"+id).val();
    var showImage = $("#f_it_"+id).val();
    showImage = "<img class=\"imageThumb\" src=\"" + showImage + "\" title=\"" + fileName + "\" data-name=\"" + fileName + "\" />" ;
    var hiddenInpit = "<input type='hidden' name='existingFiles[]' value='"+id+"'>";
    $("<span class=\"dynamic-uploaded-image\" data-name=\"" + fileName + "\" >" +
            showImage+"<br/>"+
            "<span class='filename'>"+fileName+"</span>"+
            hiddenInpit+
            "<br/><span class=\"dynamic-uploaded-image-remove currentlyuploaded\"><i class='fas fa-trash'></i></i></span>" +
            "</span>").insertAfter("#upload_dynamic_images_here");
    $(".dynamic-uploaded-image-remove.currentlyuploaded").click(function(){
            console.log($(this).parent(".dynamic-uploaded-image").attr('data-name'))
            if(confirm("Are you sure want to delete this file?")) {
              $(this).parent(".dynamic-uploaded-image").remove();
            }
          });
  }

  function chooseMedia(place) {
    $("#filter_search_place").val(place);
    $("#mediaManagerModal").modal('show');
    searchMedia();
  }

  function deleteMedia(id) {
    if(confirm("Are you sure want to delete?")) {
      $(".global-popup-loader").show();
      $.ajax({
          url: window.Laravel.siteBaseUrl+"/media-manager/delete/"+id,
          success: function(res) {
              $(".global-popup-loader").hide();
              $("#mediamanager_row_"+id).remove();
          },
          error: function(e) {
             $(".global-popup-loader").hide();
          }
      });
    }
    
  }

 function removeCommentImage(imageId, htmlId) {
    event.preventDefault()
    if (confirm('Are you sure want to delete?')) {
        $(".global-popup-loader").show();
        $.ajax({
          url: $("#"+htmlId+imageId).attr('data-href'),
          method: 'GET',
          data: "",
          success: function(data){
            if(data.status == 200) {
              $("#"+htmlId+imageId).remove();
            }
            $(".global-popup-loader").hide();
          },
          error: function(e) {
              console.log(e);
              $(".global-popup-loader").hide();
          }

        });
    } 
  }