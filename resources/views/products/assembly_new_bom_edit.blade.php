<div id="modal-alert"></div>

<form id="modal-form">   
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Item</label>
                <div class="typeahead-dropdown">
                    <input id="bom-item" type="text" class="form-control" autocomplete="off" required value="{{ $dt[4] }}">
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group">
                <label>Description</label>
                <textarea id="bom-description" class="form-control" readonly="readonly" style="height: 100px;">{{ $dt[5] }}</textarea>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Item Source</label>
                <select id="bom-item-source" class="form-control" required>
                    <option value="" selected>Select...</option>

                    @foreach ($item_source as $row)
                        <option @if($row->item_source_id  == $dt[3]) selected @endif value="{{ $row->item_source_id }}">{{ $row->name }}</option>
                     @endforeach
                 </select>
            </div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Quantity</label>
                <input id="bom-quantity" type="text" class="form-control" required onkeypress="return IsInteger(event);" value="{{ $dt[6] }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Units</label>
                 <input id="bom-units" type="text" class="form-control" readonly value="{{ $dt[7] }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Tax Code</label>
                <input id="bom-tax-code" type="text" class="form-control" readonly value="{{ $dt[8] }}">
            </div>
        </div>

         <div class="col-lg-6">
            <div class="form-group">
                <label>Tax Rate</label>
                <input id="bom-tax-rate" type="text" class="form-control" readonly value="{{ $dt[9] }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Effective Date</label>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input id="bom-effective-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" value="{{ $dt[10] }}">
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
                    <input id="bom-obsolete-date" data-date-autoclose="true" class="form-control" data-date-format="mm/dd/yyyy" value="{{ $dt[11] }}">
                </div>
            </div>
        </div>
    </div>

    <input id="bom-item-id" type="hidden" value="{{ $dt[0] }}">
    <input id="bom-unit-type-id" type="hidden" value="{{ $dt[1] }}">
    <input id="bom-tax-code-id" type="hidden" value="{{ $dt[2] }}">
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

    function editBOM(id){
        if (!$('#modal-form').parsley().validate()) { bootstrap_alert.warning('#modal-alert', 'There are some error/s, please correct them bellow.'); return;   }
         
        var cols = $('#tblbom > tbody').find('#'+id).children("td");
       
        $('#tblbom > tbody').find('#'+id).attr('id', $('#bom-item-id').val());

        $(cols[1]).text($('#bom-item-id').val());
        $(cols[2]).text($('#bom-unit-type-id').val());
        $(cols[3]).text($('#bom-tax-code-id').val());
        $(cols[4]).text($('#bom-item-source').val());
        if ($(cols[5]).text() == '') $(cols[5]).text('Update');
        $(cols[6]).text($('#bom-item').val());
        $(cols[7]).text($('#bom-description').val());
        $(cols[10]).text($('#bom-item-source').find('option:selected').text());
        $(cols[11]).text($('#bom-quantity').val());
        $(cols[12]).text($('#bom-units').val());
        $(cols[13]).text($('#bom-tax-code').val());
        $(cols[14]).text($('#bom-tax-rate').val());
        $(cols[15]).text($('#bom-effective-date').val());
        $(cols[16]).text($('#bom-obsolete-date').val());

        bootstrap_alert.close('#modal-alert');      
        $('#modal').modal('hide');      
    }
</script>