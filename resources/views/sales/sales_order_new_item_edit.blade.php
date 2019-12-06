<div id="modal-alert"></div>

<form id="modal-form">
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">
	            <label>Item</label>
	            <div class="typeahead-dropdown">
	            	<input id="soi-item" type="text"  class="form-control" autocomplete="off" required value="{{ $dt[5] }}">
	        	</div>
	        </div>
		</div>

		<div class="col-lg-12">
	        <div class="form-group">
	            <label>Description</label>
	            <textarea id="soi-description" class="form-control" readonly style="height: 100px;">{{ $dt[6] }}</textarea>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>On Hand</label>
	            <input id="soi-on-hand" type="text" class="form-control" readonly value="{{ $dt[7] }}">
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Quantity</label>
	            <input id="soi-quantity" type="text" class="form-control" required onkeypress="return IsInteger(event);" value="{{ $dt[8] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Units</label>
	            <input id="soi-units" type="text" class="form-control" readonly value="{{ $dt[9] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Code</label>
	            <input id="soi-tax-code" type="text" class="form-control" readonly value="{{ $dt[10] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Rate</label>
	            <input id="soi-tax-rate" type="text" class="form-control" readonly value="{{ $dt[11] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Rate</label>
	            <input id="soi-rate" type="text" class="form-control" required onkeypress="return IsDouble(event);" value="{{ $dt[12] }}">
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Amount</label>
	            <input id="soi-amount" type="text" class="form-control" readonly value="{{ $dt[13] }}">
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Gross Amount</label>
	            <input id="soi-gross-amount" type="text" class="form-control" readonly value="{{ $dt[14] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Tax Amount</label>
	            <input id="soi-tax-amount" type="text" class="form-control" readonly value="{{ $dt[15] }}">
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Commit</label>
	            <select id="soi-commit" class="form-control" required>
	                <option value="" selected>Select...</option>

	                @foreach ($commit as $row)
                        <option @if($row->commit_id  == $dt[3]) selected @endif value="{{ $row->commit_id }}">{{ $row->name }}</option>
                    @endforeach
	             </select>
	        </div>
	    </div>

	    <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Order Priority</label>
	            <input id="soi-order-priority" type="text" class="form-control" onkeypress="return IsInteger(event);" value="{{ $dt[16] }}">
	        </div>
	    </div>

	   <div class="col-lg-6"></div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Cost Estimate Type</label>
	            <select id="soi-cost-estimate-type" class="form-control" required>
	                <option value="" selected>Select...</option>

	                @foreach ($cost_estimate_type as $row)
                        <option @if($row->cost_estimate_type_id  == $dt[4]) selected @endif value="{{ $row->cost_estimate_type_id }}">{{ $row->name }}</option>
                    @endforeach
	             </select>
	        </div>
	    </div>

	    <div class="col-lg-6">
	        <div class="form-group">
	            <label>Estimate Extended Cost</label>
	            <input id="soi-estimate-extended-cost" type="text" class="form-control" onkeypress="return IsDouble(event);" value="{{ $dt[17] }}">
	        </div>
	    </div>

        <div class="col-lg-6" style="margin-top: 5px;">
            <div class="fancy-checkbox">
                <label><input id="soi-create-work-order" type="checkbox" @if($dt[18] == 'Yes') checked @endif><span>Create Work Order</span></label>
            </div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-6" style="margin-top: 5px;">
            <div class="fancy-checkbox">
                <label><input id="soi-create-customisation" type="checkbox" @if($dt[19] == 'Yes') checked @endif><span>Create Customisation</span></label>
            </div>
        </div>

        <div class="col-lg-6"></div>

        <div id="customisation" style="display: {{ ($dt[19] == 'Yes') ? 'block' : 'none' }}">
	  		<div class="col-lg-12" style="margin-top: 15px;">
				<div class="alert alert-warning ">
	            	<h4><i class="fa fa-warning"></i> Customisation!</h4>
	           		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
	       		</div>
	        </div>

	        <div class="col-lg-12" style="margin-top: 5px;">
				<div class="form-group">
		            <label>Customisation Name</label>
		             <input id="soi-customisation-name" type="text" class="form-control" required value="{{ $dt[20] }}">
		        </div>
			</div>

	        <div class="col-lg-12">
		        <div class="form-group">
		            <label>Customisation Notes</label>
		            <textarea id="soi-customisation-notes" class="form-control" style="height: 100px;">{{ $dt[21] }}</textarea>
		        </div>
		    </div>
		</div>
	</div>

	<input id="soi-item-id" type="hidden" value="{{ $dt[0] }}">
	<input id="soi-unit-type-id" type="hidden" value="{{ $dt[1] }}">
	<input id="soi-tax-code-id" type="hidden" value="{{ $dt[2] }}">
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

	function editItem(id){
		if (!$('#modal-form').parsley({ excluded: 'input:hidden' }).validate()) { bootstrap_alert.warning('#modal-alert', ' There are some error/s, please correct them bellow.'); return; }
		
		var cols = $('#tblitems > tbody').find('#'+id).children("td");
       
        $('#tblitems > tbody').find('#'+id).attr('id', $('#soi-item-id').val());

        $(cols[2]).text($('#soi-item-id').val());
        $(cols[3]).text($('#soi-unit-type-id').val());
        $(cols[4]).text($('#soi-tax-code-id').val());
        $(cols[5]).text($('#soi-commit').val());
        $(cols[6]).text($('#soi-cost-estimate-type').val());
        if ($(cols[7]).text() == '') $(cols[7]).text('Update');
        $(cols[8]).text($('#soi-item').val());
		$(cols[9]).text($('#soi-description').val());
		$(cols[10]).text($('#soi-on-hand').val());
		$(cols[11]).text($('#soi-quantity').val());
		$(cols[12]).text($('#soi-units').val());
		$(cols[13]).text($('#soi-tax-code').val());
		$(cols[14]).text($('#soi-tax-rate').val());
		$(cols[15]).text($('#soi-rate').val());
		$(cols[16]).text($('#soi-amount').val());
		$(cols[17]).text($('#soi-gross-amount').val());
		$(cols[18]).text($('#soi-tax-amount').val());
		$(cols[19]).text($('#soi-commit').find('option:selected').text());
		$(cols[20]).text($('#soi-order-priority').val());
		$(cols[21]).text($('#soi-cost-estimate-type').find('option:selected').text());
		$(cols[22]).text($('#soi-estimate-extended-cost').val());
		$(cols[23]).text(($('#soi-create-work-order').is(":checked") ? 'Yes' : 'No'));
		$(cols[24]).text(($('#soi-create-customisation').is(":checked") ? 'Yes' : 'No'));
		$(cols[25]).text($('#soi-customisation-name').val());
		$(cols[26]).text($('#soi-customisation-notes').val());

        bootstrap_alert.close('#modal-alert');      
        $('#modal').modal('hide');      
	}
</script>