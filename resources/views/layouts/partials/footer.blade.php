<footer class="main-footer">
	<?php /* <div class="footer-left">
	  Copyright &copy; Reserved Koala
	</div>
	<div class="footer-right">
	</div> */ ?>
</footer>
<div id="formModalCreateUpdate" class="modal fade kola-modal" role="dialog">
  <input type="hidden" name="_request_format" id="_request_format">
  <input type="hidden" name="_request_modal" id="_request_modal">
  <input type="hidden" name="_request_form" id="_request_form">
  <div class="modal-dialog" id="loadModalDatas">
    <!-- Modal content-->
    
    <!-- Modal content-->
  </div>
</div>
<div class="global-popup-loader">
	<div class="global-popup-loader-inner">
		<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
	</div>
</div>

@if(Route::currentRouteAction() != "App\\Http\\Controllers\\Admin\\FilesController@index")
<div id="mediaManagerModal" class="modal fade" role="dialog">
	<div class="modal-dialog maxwidth-ninety">
        <div class="modal-content">

            <div class="modal-header"> 
            	<h2>MEDIA LIBRARY</h2>
                <button type="button" class="close" #modalInputAward data-dismiss="modal" aria-label="Close">
                    Close
                </button>
            </div>
            <div class="modal-body text-center">
	             <div class="row">
	              <div class="col-12 col-md-12 col-lg-12">
	                <div class="card card-primary">
					    
					     <div class="card-body">
					     	<input type="hidden" name="filter_search_place" id="filter_search_place" value="">
					     	<div class="media-manager-library" id="media_manager_library">
					     		
					     	</div>
					     	

					    </div>
					</div>
				</div>
			  </div>
			 </div>
        </div>
    </div>

</div>
@endif