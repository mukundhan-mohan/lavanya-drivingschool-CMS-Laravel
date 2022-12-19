  <!-- General JS Scripts -->
  <script src="https://maps.google.com/maps/api/js?key=AIzaSyAHVtWNLpmxYR5a3NobHA3yzn_vkl5_VT4&libraries=places" type="text/javascript"></script>
  <script src="{{ url('js/jquery.min.js') }}"></script>
    <script src="{{ url('js/gijgo.min.js') }}"></script>
  <script src="{{ url('js/popper.js') }}"></script>
  <script src="{{ url('js/tooltip.js') }}"></script>
  <script src="{{ url('bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('nicescroll/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ url('js/moment.min.js') }}"></script>
  <script src="{{ url('js/stisla.js') }}"></script>
  <script  src="{{ url('js/select2.js') }}"></script>
  <script  src="{{ url('js/daterangepicker.min.js') }}"></script>
  <script src="{{ url('js/bootstrap-modal.js') }}"></script>
  <script src="{{ url('tagsinput/bootstrap-tagsinput.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
  <!-- Template JS File -->
  <script src="{{ url('js/scripts.js') }}"></script>
  <script src="{{ url('js/custom.js') }}"></script>
  <script type="text/javascript">
    $('.select2').select2({
        minimumResultsForSearch: -1,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
    window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
            'siteBaseUrl' => url('/'),
            'adminprefix' => '/'
        ]) !!};
   
  </script>