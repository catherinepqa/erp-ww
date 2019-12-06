<div id="modal-alert"></div>

<form id="modal-form">
	<div class="row">
		<div class="col-lg-6">
	        <div class="form-group">
                <label>Location</label>
                <select id="bin-location" class="form-control" required>
                    <option value="">Select...</option>

                     @foreach ($locations as $row)
                        <option @if($row->location_id  == $dt[0]) selected @endif value="{{ $row->location_id }}">{{ $row->name }}</option>
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

                     @foreach ($bins as $row)
                        <option @if($row->bin_id  == $dt[1]) selected @endif value="{{ $row->bin_id }}~{{ $row->status }}">{{ $row->bin_no }}</option>
                     @endforeach
                </select>
            </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Location Active</label>
	            <input id="bin-location-active" type="text" class="form-control" readonly value="{{ $dt[2] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
            <div class="fancy-checkbox">
                <label><input id="bin-preferred" type="checkbox" @if($dt[3] == 'Yes') checked @endif><span>Preferred (Per Location)</span></label>
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

	function editBIN(id){
        if (!$('#modal-form').parsley().validate()) { bootstrap_alert.warning('#modal-alert', ' There are some error/s, please correct them bellow.'); return;   }
        
        var cols = $('#tblbin > tbody').find('#'+id).children("td");

        $('#tblbin > tbody').find('#'+id).attr('id', $('#bin-bin-number').val().split("~")[0]);
       	$(cols[1]).text($('#bin-location').val());
        $(cols[2]).text($('#bin-bin-number').val().split("~")[0]);
        if ($(cols[3]).text() == '') $(cols[3]).text('Update');
        $(cols[4]).text($('#bin-location').find('option:selected').text());
        $(cols[5]).text($('#bin-bin-number').find('option:selected').text());
        $(cols[6]).text($('#bin-location-active').val());
        $(cols[7]).text($('#bin-preferred').is(":checked") ? 'Yes' : 'No');

        bootstrap_alert.close('#modal-alert');      
        $('#modal').modal('hide');      
    }
</script>