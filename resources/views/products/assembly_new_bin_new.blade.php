<div id="modal-alert"></div>

<form id="modal-form">
	<div class="row">
		<div class="col-lg-6">
	        <div class="form-group">
                <label>Location</label>
                <select id="bin-location" class="form-control" required>
                    <option value="">Select...</option>

                     @foreach ($locations as $row)
                        <option value="{{ $row->location_id }}">{{ $row->name }}</option>
                     @endforeach
                </select>
            </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
                <label>Bin Number</label>
                <select id="bin-bin-number" class="form-control" required>
                    <option value="">Select...</option>
                </select>
            </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Location Active</label>
	            <input id="bin-location-active" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
            <div class="fancy-checkbox">
                <label><input id="bin-preferred" type="checkbox"><span>Preferred (Per Location)</span></label>
            </div>
        </div>
	</div>
</form>

<script>
	$(function () {
		 $('#form').parsley();

	    var App = {
	        baseUrl : window.location.protocol + '//' + window.location.host + '/products/',
	        csrfToken : $('meta[name="csrf-token"]').attr('content'),

	        init: function () {
	            this.setElements();
	            this.bindEvents();
	        },
	  
	        setElements: function () {
	        	this.$bin_location = $('#bin-location'); 
	        	this.$bin_bin_number = $('#bin-bin-number'); 
	           
	        },
	      
	        bindEvents: function () {
	           	this.$bin_location.on('change', this.setBins);
	           	this.$bin_bin_number.on('change', this.setBinDetails);
	        },    

	        setBins : function() {
	        	$.ajax({
	                type:'GET',
	                url : App.baseUrl + "get_bins_by_location_id",
	                data: {
	                	locationID : App.$bin_location.val(),
	                    _token: App.csrfToken, 
	                },
	                dataType: 'json',
	                success : function(data) {
	                    $('#bin-bin-number').html('<option value="">Select...</option>');
	                   
	                    var len = 0;
	                    
	                    if (data != null) len = data.length;

	                    if(len > 0){
	                        for(var i=0; i<len; i++){
	                            $("#bin-bin-number").append("<option value='"+data[i].bin_id+"~"+data[i].status+"'>"+ data[i].bin_no+"</option>"); 
	                        }
	                    }
	                },
	            });
	        },

	        setBinDetails : function() {
	        	$('#bin-location-active').val(App.$bin_bin_number.val().split("~")[1] == 'Active' ? 'Yes' : 'No');
	        },
	    }
	  
	    App.init();
	}); 

	function createBIN(){
		if (!$('#modal-form').parsley().validate()) { bootstrap_alert.warning('#modal-alert', ' There are some error/s, please correct them bellow.'); return; }
		
		var row = '<tr id="'+ $('#bin-bin-number').val().split("~")[0] +'">'+
			'<td class=""></td>'+
			'<td class="">'+ $('#bin-location').val() +'</td>'+
			'<td class="">'+ $('#bin-bin-number').val().split("~")[0] +'</td>'+
			'<td class="">Create</td>'+
		    '<td>'+ $('#bin-location').find('option:selected').text() +'</td>'+
		    '<td>'+ $('#bin-bin-number').find('option:selected').text() +'</td>'+
		    '<td>'+ $('#bin-location-active').val() +'</td>'+
		    '<td>'+ ($('#bin-preferred').is(":checked") ? 'Yes' : 'No') +'</td>'+
		    '<td><a onclick="setEditBIN(this)" title="Edit"><i class="fa fa-pencil green"></i></a></td>'+
		    '<td><a onclick="deleteBIN(this);" title="Delete"><i class="fa fa-trash-o red"></i></a></td>'+
		    '</tr>'; 


        $('#tblbin').append(row);

		bootstrap_alert.close('#modal-alert');	
		$('#modal').modal('hide');		
	}
</script>