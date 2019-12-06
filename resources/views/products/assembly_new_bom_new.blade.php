<div id="modal-alert"></div>

<form id="modal-form">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
	            <label>Item</label>
	            <div class="typeahead-dropdown">
	            	<input id="bom-item" type="text"  class="form-control" autocomplete="off" required>
	        	</div>
	        </div>
		</div>

	    <div class="col-lg-12">
	        <div class="form-group">
	            <label>Description</label>
	            <textarea id="bom-description" class="form-control" readonly="readonly" style="height: 100px;"></textarea>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Item Source</label>
	            <select id="bom-item-source" class="form-control" required>
	                <option value="" selected>Select...</option>

	                @foreach ($item_source as $row)
	                    <option value="{{ $row->item_source_id }}">{{ $row->name }}</option>
	                 @endforeach
	             </select>
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Quantity</label>
	            <input id="bom-quantity" type="text" class="form-control" required onkeypress="return IsInteger(event);">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Units</label>
	             <input id="bom-units" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Code</label>
	            <input id="bom-tax-code" type="text" class="form-control" readonly>
	        </div>
	    </div>

	     <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Rate</label>
	            <input id="bom-tax-rate" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	    	<div class="form-group">
	            <label>Effective Date</label>
	    			<div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
	                </div>
	                <input id="bom-effective-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy">
	            </div>
	        </div>
	    </div>

	   	<div class="col-lg-6">
	   		<div class="form-group">
	            <label>Obsolete Date</label>
	    			<div class="input-group mb-3">
	                <div class="input-group-prepend">
	                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
	                </div>
	                <input id="bom-obsolete-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy">
	            </div>
	        </div>
	   	</div>
	</div>

	<input id="bom-item-id" type="hidden">
	<input id="bom-unit-type-id" type="hidden">
	<input id="bom-tax-code-id" type="hidden">
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
	        	this.$bom_item = $('#bom-item'); 
	            this.$bom_effective_date = $('#bom-effective-date'); 
	            this.$bom_obsolete_date = $('#bom-obsolete-date'); 
	        },
	      
	        bindEvents: function () {
	        	this.$bom_item.typeahead({
	                source: function(query, process) {
	                    $.ajax({
	                    	url : App.baseUrl + "search_item_by_name",
			                data: {
			                	itemName : App.$bom_item.val(),
			                    _token: App.csrfToken, 
			                },
	                        type: 'GET',
	                        dataType: 'json',
	                        success: function(data) {		
	                        	process(data);
	                            console.log(data);
	                        }
	                    });
	                },
	                minLength: 2,
	               	afterSelect: function (data) {
	                	$('#bom-item-id').val(data.item_id);
	                	$('#bom-description').val(data.item_description);
	                	$('#bom-unit-type-id').val(data.unit_type_id);
			        	$('#bom-units').val(data.unit_type);
			        	$('#bom-tax-code-id').val(data.tax_code_id);
			        	$('#bom-tax-code').val(data.tax_type+' : '+data.tax_code);
			        	$('#bom-tax-rate').val(data.tax_rate);
	                }
	            });

	            this.$bom_effective_date.datepicker({
	                todayHighlight: true
	            });

	             this.$bom_obsolete_date.datepicker({
	                todayHighlight: true
	            });
	        },    
	    }
	  
	    App.init();
	}); 

	function createBOM(){
		if (!$('#modal-form').parsley().validate()) { bootstrap_alert.warning('#modal-alert', ' There are some error/s, please correct them bellow.'); return; }
		
		var row = '<tr id="'+ $('#bom-item-id').val() +'">'+
			'<td class=""></td>'+
			'<td class="">'+ $('#bom-item-id').val() +'</td>'+
			'<td class="">'+ $('#bom-unit-type-id').val() +'</td>'+
			'<td class="">'+ $('#bom-tax-code-id').val() +'</td>'+
			'<td class="">'+ $('#bom-item-source').val() +'</td>'+
			'<td class="">Create</td>'+
		    '<td>'+ $('#bom-item').val() +'</td>'+
		    '<td>'+ $('#bom-description').val() +'</td>'+
		    '<td></td>'+
		    '<td></td>'+
		    '<td>'+ $('#bom-item-source').find('option:selected').text() +'</td>'+
		    '<td class="align-right">'+ $('#bom-quantity').val() +'</td>'+
		    '<td>'+ $('#bom-units').val() +'</td>'+
		    '<td>'+ $('#bom-tax-code').val() +'</td>'+
		    '<td class="align-right">'+ $('#bom-tax-rate').val() +'</td>'+
		    '<td>'+ $('#bom-effective-date').val() +'</td>'+
		    '<td>'+ $('#bom-obsolete-date').val() +'</td>'+
		    '<td><a onclick="setEditBOM(this)" title="Edit"><i class="fa fa-pencil green"></i></a></td>'+
		    '<td><a onclick="deleteBOM(this);" title="Delete"><i class="fa fa-trash-o red"></i></a></td>'+
		    '</tr>'; 

        $("#tblbom").append(row);

		bootstrap_alert.close('#modal-alert');	
		$('#modal').modal('hide');		
	}
</script>