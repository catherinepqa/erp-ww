<div id="modal-alert"></div>

<form id="modal-form">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
	            <label>Item</label>
	            <div class="typeahead-dropdown">
	            	<input id="soi-item" type="text"  class="form-control" autocomplete="off" required>
	        	</div>
	        </div>
		</div>

		<div class="col-lg-12">
	        <div class="form-group">
	            <label>Description</label>
	            <textarea id="soi-description" class="form-control" readonly style="height: 100px;"></textarea>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>On Hand</label>
	            <input id="soi-on-hand" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Quantity</label>
	            <input id="soi-quantity" type="text" class="form-control" required onkeypress="return IsInteger(event);">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Units</label>
	            <input id="soi-units" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Code</label>
	            <input id="soi-tax-code" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Rate</label>
	            <input id="soi-tax-rate" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Rate</label>
	            <input id="soi-rate" type="text" class="form-control" required onkeypress="return IsDouble(event);">
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Amount</label>
	            <input id="soi-amount" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Gross Amount</label>
	            <input id="soi-gross-amount" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Amount</label>
	            <input id="soi-tax-amount" type="text" class="form-control" readonly>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Commit</label>
	            <select id="soi-commit" class="form-control" required>
	                <option value="" selected>Select...</option>

	                @foreach ($commit as $row)
                        <option value="{{ $row->commit_id }}">{{ $row->name }}</option>
                    @endforeach
	             </select>
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Order Priority</label>
	            <input id="soi-order-priority" type="text" class="form-control" onkeypress="return IsInteger(event);">
	        </div>
	    </div>

	   <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Cost Estimate Type</label>
	            <select id="soi-cost-estimate-type" class="form-control" required>
	                <option value="" selected>Select...</option>

	                @foreach ($cost_estimate_type as $row)
                        <option value="{{ $row->cost_estimate_type_id }}">{{ $row->name }}</option>
                    @endforeach
	             </select>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Estimate Extended Cost</label>
	            <input id="soi-estimate-extended-cost" type="text" class="form-control" onkeypress="return IsDouble(event);">
	        </div>
	    </div>

        <div class="col-lg-6" style="margin-top: 5px;">
            <div class="fancy-checkbox">
                <label><input id="soi-create-work-order" type="checkbox"><span>Create Work Order</span></label>
            </div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-6" style="margin-top: 5px;">
            <div class="fancy-checkbox">
                <label><input id="soi-create-customisation" type="checkbox"><span>Create Customisation</span></label>
            </div>
        </div>

        <div class="col-lg-6"></div>

        <div id="customisation" style="display: none;">
	  		<div class="col-lg-12" style="margin-top: 15px;">
				<div class="alert alert-warning ">
	            	<h4><i class="fa fa-warning"></i> Customisation!</h4>
	           		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	       		</div>
	        </div>

	        <div class="col-lg-12" style="margin-top: 5px;">
				<div class="form-group">
		            <label>Customisation Name</label>
		             <input id="soi-customisation-name" type="text" class="form-control". required>
		        </div>
			</div>

	        <div class="col-lg-12">
		        <div class="form-group">
		            <label>Customisation Notes</label>
		            <textarea id="soi-customisation-notes" class="form-control" style="height: 100px;"></textarea>
		        </div>
		    </div>
		</div>
	</div>

	<input id="soi-item-id" type="hidden">
	<input id="soi-unit-type-id" type="hidden">
	<input id="soi-tax-code-id" type="hidden">
</form>

<script>
	$(function () {
		$('#form').parsley();

	    var App = {
	        baseUrl : window.location.protocol + '//' + window.location.host + '/sales/',
	        csrfToken : $('meta[name="csrf-token"]').attr('content'),

	        init: function () {
	            this.setElements();
	            this.bindEvents();
	        },
	  
	        setElements: function () {
	        	this.$soi_item = $('#soi-item'); 
	        	this.$soi_quantity = $('#soi-quantity'); 
	        	this.$soi_rate = $('#soi-rate'); 
	        	this.$soi_create_customisation = $('#soi-create-customisation'); 
	        },
	      
	        bindEvents: function () {
	        	this.$soi_item.typeahead({
	                source: function(query, process) {
	                    $.ajax({
	                    	url : App.baseUrl + "search_item_by_name",
			                data: {
			                	itemName : App.$soi_item.val(),
			                	locationID: 1,
			                	currencyID: 1,
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
	                	$('#soi-item-id').val(data.item_id);
	                	$('#soi-description').val(data.item_description);
	                	$('#soi-on-hand').val(data.qty_on_hand);
	                	$('#soi-quantity').val(1);
	                	$('#soi-unit-type-id').val(data.unit_type_id);
			        	$('#soi-units').val(data.unit_type);
			        	$('#soi-tax-code-id').val(data.tax_code_id);
			        	$('#soi-tax-code').val(data.tax_type+' : '+data.tax_code);
			        	$('#soi-tax-rate').val(data.tax_rate +'%');
			        	$('#soi-rate').val(data.amount);
			        	
			        	var taxAmount = data.amount / data.tax_rate;
			        	var amount = Math.round(data.amount);
			        	var grossAmount = amount + taxAmount;

			        	$('#soi-amount').val(amount.toFixed(2));
			        	$('#soi-gross-amount').val((grossAmount == 'Infinity') ? '0.00' : grossAmount.toFixed(2));
	        			$('#soi-tax-amount').val((taxAmount == 'Infinity') ? '0.00' : taxAmount.toFixed(2));
			        	$('#soi-estimate-extended-cost').val(data.item_defined_cost);
			        	$('#soi-cost-estimate-type').val(data.cost_estimate_type_id);
			        	$('#soi-estimate-extended-cost').val(data.item_defined_cost);
	                }
	            });

	        	this.$soi_quantity.on('keyup', this.setComputation);
	        	this.$soi_rate.on('keyup', this.setComputation);
	            this.$soi_create_customisation.on('change', this.setCustomisation);

	        }, 

	        setComputation: function() {
	        	var amount = Math.round($('#soi-rate').val() * App.$soi_quantity.val());
	        	var taxAmount = amount / $('#soi-tax-rate').val().replace('%', '');
	        	var grossAmount = amount + taxAmount;

	        	$('#soi-amount').val(amount.toFixed(2));
	        	$('#soi-gross-amount').val((grossAmount == 'Infinity') ? '0.00' : grossAmount.toFixed(2));
	        	$('#soi-tax-amount').val((taxAmount == 'Infinity') ? '0.00' : taxAmount.toFixed(2));
	        },

	        setCustomisation: function() {
	        	if (App.$soi_create_customisation.is(":checked")) {
	        		$('#customisation').show();
	        	} else {
	        		$('#soi-customisation-name').val('');
	        		$('#soi-customisation-notes').val('');
	        		$('#soi-customisation-name').focus();
	        		$('#customisation').hide();
	        	}
	        	
	        }   
	    }
	  
	    App.init();
	}); 

	function createItem(){
		if (!$('#modal-form').parsley({ excluded: 'input:hidden' }).validate()) { bootstrap_alert.warning('#modal-alert', ' There are some error/s, please correct them bellow.'); return; }
		
		var row = '<tr id="'+ $('#soi-item-id').val() +'">'+
			'<td class=""></td>'+
			'<td class=""></td>'+
			'<td class="">'+ $('#soi-item-id').val() +'</td>'+
			'<td class="">'+ $('#soi-unit-type-id').val() +'</td>'+
			'<td class="">'+ $('#soi-tax-code-id').val() +'</td>'+
			'<td class="">'+ $('#soi-commit').val() +'</td>'+
			'<td class="">'+ $('#soi-cost-estimate-type').val() +'</td>'+
			'<td class="">Create</td>'+
		    '<td>'+ $('#soi-item').val() +'</td>'+
		    '<td>'+ $('#soi-description').val() +'</td>'+
		   	'<td class="align-right">'+ $('#soi-on-hand').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-quantity').val() +'</td>'+
		    '<td>'+ $('#soi-units').val() +'</td>'+
		    '<td>'+ $('#soi-tax-code').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-tax-rate').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-rate').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-amount').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-gross-amount').val() +'</td>'+
		    '<td class="align-right">'+ $('#soi-tax-amount').val() +'</td>'+
			'<td>'+ $('#soi-commit').find('option:selected').text() +'</td>'+
			'<td class="align-right">'+ $('#soi-order-priority').val() +'</td>'+
			'<td>'+ $('#soi-cost-estimate-type').find('option:selected').text() +'</td>'+
			'<td class="align-right">'+ $('#soi-estimate-extended-cost').val() +'</td>'+
			'<td>'+ ($('#soi-create-work-order').is(":checked") ? 'Yes' : 'No') +'</td>'+
			'<td>'+ ($('#soi-create-customisation').is(":checked") ? 'Yes' : 'No') +'</td>'+
			'<td>'+ $('#soi-customisation-name').val() +'</td>'+
			'<td>'+ $('#soi-customisation-notes').val() +'</td>'+
		    '<td><a onclick="setEditItem(this)" title="Edit"><i class="fa fa-pencil green"></i></a></td>'+
		    '<td><a onclick="deleteItem(this);" title="Delete"><i class="fa fa-trash-o red"></i></a></td>'+
		    '</tr>'; 

        $("#tblitems").append(row);

		bootstrap_alert.close('#modal-alert');	
		$('#modal').modal('hide');		
	}
</script>