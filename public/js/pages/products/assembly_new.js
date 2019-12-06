$(function () {
    CKEDITOR.replace('detailed-description');
    CKEDITOR.replace('featured-description');

    var App = {
        baseUrl : window.location.protocol + '//' + window.location.host + '/products/',
        csrfToken : $('meta[name="csrf-token"]').attr('content'),

        init: function () {
            this.setElements();
            this.bindEvents();
        },
  
        setElements: function () {
            this.$item_options = $('#item-options'); 
            this.$product_category = $('#product-category'); 
            this.$relase_date = $('#release-date'); 
            this.$unit_type = $('#unit-type'); 
            this.$style = $('#style');
            this.$fabric = $('#fabric'); 
            this.$colour = $('#colour');   
            this.$top_size = $('#top-size'); 
            this.$size = $('#size'); 
            this.$back_variation = $('#back-variation'); 
            this.$style_variation = $('#style-variation');      
            this.$print = $('#print'); 
            this.$trouser_length = $('#trouser-length'); 

            this.$add_data_bom = $('#add-data-bom'); 
            this.$add_data_bin = $('#add-data-bin');
            this.$save_top = $('#save-top'); 
            this.$save_bottom = $('#save-bottom'); 
            this.$cancel_top = $('#cancel-top'); 
            this.$cancel_bottom = $('#cancel-bottom'); 
        },
      
        bindEvents: function () {
            this.$item_options.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$product_category.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$relase_date.datepicker({
                todayHighlight: true
            });

            this.$unit_type.on('change', this.setUnitOfMeasures);

            this.$style.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$style.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$fabric.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$fabric.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$colour.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$colour.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$top_size.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$top_size.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$size.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });     

            this.$size.on('change', function() { App.generateMatrixItemNameTemplate(); });  

            this.$back_variation.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });
            
            this.$back_variation.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$style_variation.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$style_variation.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$print.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$print.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$trouser_length.multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                maxHeight: 300,
                numberDisplayed: 50
            });

            this.$trouser_length.on('change', function() { App.generateMatrixItemNameTemplate(); });

            this.$add_data_bom.on('click', this.setNewBOM);
            this.$add_data_bin.on('click', this.setNewBIN);
            this.$save_top.on('click', this.createItem);
            this.$save_bottom.on('click', this.createItem);
            this.$cancel_top.on('click', this.cancel);
            this.$cancel_bottom.on('click', this.cancel);
            
        },
        
        setUnitOfMeasures : function() {
            $.ajax({
                type:'GET',
                url : App.baseUrl + "get_subunit_of_measures",
                data: {
                    _token: App.csrfToken, 
                    message:$(".getinfo").val(),
                    unitTypeID : App.$unit_type.val().split("~")[0]
                },
                dataType: 'json',
                success : function(data) {
                    $('#stock-unit').html('');
                    $('#purchase-unit').html('');
                    $('#sales-unit').html('');
                    $('#consumption-unit').html('');
                    $("#base-unit").val(App.$unit_type.val().split("~")[1]); 

                    var len = 0;
                    
                    if (data != null) len = data.length;

                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var id = data[i].unit_type_id;
                            var name = data[i].name;
                            var option = "<option value='"+id+"'>"+name+"</option>"; 

                            $("#stock-unit").append(option); 
                            $("#purchase-unit").append(option); 
                            $("#sales-unit").append(option); 
                            $("#consumption-unit").append(option); 
                        }
                    }
                },
            });
        },   

        setNewBOM : function() {
            $.ajax({
                type:'GET',
                url : App.baseUrl + "set_new_bom",
                data: {
                    _token: App.csrfToken, 
                },
                dataType: 'html',
                success : function(data) {
                    $('.modal-title').html('Bill of Materials - New');
                    $('.modal-body').html(data);
                    $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="createBOM();">Save</button>');
                    $('#modal').modal('show');  
                },
            });
        },

        setNewBIN : function() {
            $.ajax({
                type:'GET',
                url : App.baseUrl + "set_new_bin",
                data: {
                    _token: App.csrfToken, 
                },
                dataType: 'html',
                success : function(data) {
                    $('.modal-title').html('Bin Numbers - New');
                    $('.modal-body').html(data);
                    $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="createBIN();">Save</button>');
                    $('#modal').modal('show');  
                },
            });
        },   

        generateMatrixItemNameTemplate : function() {
            var maxtrixTemplate = '{item_id}';

            if (App.$style.val() != '') maxtrixTemplate += '-{style}';
            if (App.$fabric.val() != '') maxtrixTemplate += '-{fabric}';
            if (App.$colour.val() != '') maxtrixTemplate += '-{colour}';
            if (App.$top_size.val() != '') maxtrixTemplate += '-{top_size}';
            if (App.$size.val() != '') maxtrixTemplate += '-{size}';
            if (App.$back_variation.val() != '') maxtrixTemplate += '-{back_variation}';
            if (App.$style_variation.val() != '') maxtrixTemplate += '-{style_variation}';
            if (App.$print.val() != '') maxtrixTemplate += '-{print}';
            if (App.$trouser_length.val() != '') maxtrixTemplate += '-{trouser_length}';

            $('#matrix-item-name-template').val(maxtrixTemplate);
        },

        createItem : function() {
            if (!$('#form').parsley().validate()) { bootstrap_alert.warning('#alert', ' There are some error/s, please correct them bellow.'); return; }
            
            bootstrap_alert.close('#alert');   

            swal({
                title: "",
                text: "Are you sure you want to save this record?",
                type: "warning",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: false,
            }, function () {
                $.ajax({
                    type:'POST',
                    url : App.baseUrl + "create_item",
                    data: {
                        itemCode: $('#item-code').val(),
                        itemName: $('#item-name').val(),
                        itemDescription: $('#item-description').val(),
                        upcCode: $('#upc-code').val(),
                        externalID: $('#external-id').val(),
                        wickedOMeter: $('#wicked-o-meter').val(),
                        itemBOMBarcode: $('#item-bom-barcode').val(),
                        productionTeam: $('#production-team').val(),
                        itemStyle: $('#item-style').val(),
                        itemStyleDescription: $('#item-style-description').val(),
                        itemClassification: $('#item-classification').val(),
                        itemOptions: App.$item_options.val(),
                        productCategory: App.$product_category.val(),
                        releaseDate: App.$relase_date.val(),
                        vendorsCode: $('#vendors-code').val(),
                        oversell: $('#oversell').is(":checked") ? 1 : 0,
                        unitType: App.$unit_type.val().split("~")[0],
                        stockUnit: $('#stock-unit').val(),
                        purchaseUnit: $('#purchase-unit').val(),
                        salesUnit: $('#sales-unit').val(),
                        consumptionUnit: $('#consumption-unit').val(),
                        baseUnit: $('#base-unit').val(),
                        departmentID: $('#departments').val(),
                        itemCategoryID: $('#item-category').val(),
                        locationId: $('#location').val(),
                        trackLandedCost: $('#track-landed-cost').is(":checked") ? 1 : 0,
                        costingMethodID: $('#costing-method').val(),
                        purchasePrice: $('#purchase-price').val(),
                        purchaseDescription: $('#purchase-description').val(),
                        stockDescription: $('#stock-description').val(),
                        useBins: $('#use-bins').is(":checked") ? 1 : 0,
                        manufacturer: $('#manufacturer').val(),
                        mpn: $('#mpn').val(),
                        manufacturerCountry: $('#manufacturer-country').val(),
                        matrixItemNameTemplate : $('#matrix-item-name-template').val(),
                        style : $('#style').val(),
                        fabric : $('#fabric').val(),
                        colour : $('#colour').val(),
                        topSize : $('#top-size').val(),
                        size : $('#size').val(),
                        backVariation : $('#back-variation').val(),
                        styleVariation : $('#style-variation').val(),
                        print : $('#print').val(),
                        trouserLength : $('#trouser-length').val(),
                        costEstimateTypeID: $('#cost-estimate-type').val(),
                        itemDefinedCost: $('#item-defined-cost').val(),
                        minimumQuantity: $('#minimum-quantity').val(),
                        itemWeight: $('#item-weight').val(),
                        weightUnitID: $('#weight-unit').val(),
                        shippingCost: $('#shipping-cost').val(),
                        handlingCost: $('#handling-cost').val(),
                        shipsIndividually: $('#ships-individually').is(":checked") ? 1 : 0,
                        pricesIncludedTax: $('#prices-included-tax').is(":checked") ? 1 : 0,
                        taxCode: $('#tax-code').val(),
                        purchaseTaxCode: $('#purchase-tax-code').val(),
                        displayInWeb: $('#display-in-web').is(":checked") ? 1 : 0,
                        webstoreDisplayName: $('#webstore-display-name').val(),
                        detailedDescription: CKEDITOR.instances['detailed-description'].getData(),
                        featuredDescription: CKEDITOR.instances['featured-description'].getData(),
                        inventoryItems : App.inventoryItems(),
                        bom : App.bom(),
                        bins : App.bins(),
                        priceLevels : App.priceLevels(),
                        _token: App.csrfToken, 
                    },
                    dataType: 'json',
                    success : function(data) {
                        swal({
                            title: "Success!",
                            text: "1 row successfully submitted.",
                            type: "success",
                        }, function () {
                            window.location.href = App.baseUrl + "view_assembly/" + data['id']; 
                        });
                    },
                });
            });        
        },      

        inventoryItems : function() {
            var dt = [];

            $('#tblloc tbody tr').each(function(row, tr){
                var cols = $(tr).children('td');
                var locationID = $(cols[0]).text();
                var buildPoint = $('#bp-'+$(cols[0]).text()).val();
                var preferredStockLevel = $('#psl-'+$(cols[0]).text()).val();
                var defaultReturnCost = $('#drc-'+$(cols[0]).text()).val();

                if (buildPoint != '' || preferredStockLevel != '' || defaultReturnCost != '') {
                    dt.push({
                        "locationID" : locationID,
                        "buildPoint" : buildPoint,
                        "preferredStockLevel" : preferredStockLevel,
                        "defaultReturnCost" : defaultReturnCost
                    });
                }
            });

            return dt;
        },   

        bom : function() {
            var dt = [];

            $('#tblbom tbody tr').each(function(row, tr){
                var cols = $(tr).children('td');

                dt.push({
                    "referenceID" : $(cols[1]).text(),
                    "itemSourceID" : $(cols[4]).text(),
                    "quantity" :  $(cols[11]).text(),
                    "effectivDate" :  $(cols[15]).text(),
                    "obseleteDate" :  $(cols[16]).text()
                });
            });

            return dt;
        },   

        bins : function() {
            var dt = [];

            $('#tblbin tbody tr').each(function(row, tr){
                var cols = $(tr).children('td');

                dt.push({
                    "locationID" : $(cols[1]).text(),
                    "binID" : $(cols[2]).text(),
                    "preferredPerLocation" :  $(cols[6]).text() == 'Yes' ? 1 : 0
                });
            });

            return dt;
        },

        priceLevels : function() {
            var dt = [];

            $('#tblpl tbody tr').each(function(row, tr){
                var cols = $(tr).children('td');
                var amount = $('#pl-'+$(cols[0]).text()).val();

                if (amount != '') {
                    dt.push({
                        "currencyID" : $(cols[0]).text(),
                        "amount" : amount
                    });
                }
            });

            return dt;
        },

        cancel : function() {
            window.history.back();
        }         
    }
    
    App.init();
}); 

function setEditBOM(evt){
    var baseUrl = window.location.protocol + '//' + window.location.host + '/products/';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var cols = $(evt).parents("tr").children("td");

    $.ajax({
        type:'GET',
        url : baseUrl + "set_edit_bom",
        data: {
            itemID: $(cols[1]).text(),
            unitTypeID: $(cols[21]).text(),
            taxCodeID: $(cols[3]).text(),
            itemSourceID: $(cols[4]).text(),
            itemName: $(cols[6]).text(),
            itemDescription: $(cols[7]).text(),
            quantity: $(cols[11]).text(),
            unit: $(cols[12]).text(),
            taxCode: $(cols[13]).text(),
            taxRate: $(cols[14]).text(),
            effectiveDate: $(cols[15]).text(),
            obseleteDate: $(cols[16]).text(),
            _token: csrfToken, 
        },
        dataType: 'html',
        success : function(data) {
            $('.modal-title').html('Bill of Materials - Edit');
            $('.modal-body').html(data);
            $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="editBOM('+$(cols[1]).text()+');">Save</button>');
            $('#modal').modal('show');  
        },
    });
}

function deleteBOM(evt){
     $(evt).closest('tr').remove();
}

function setEditBIN(evt){
    var baseUrl = window.location.protocol + '//' + window.location.host + '/products/';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var cols = $(evt).parents("tr").children("td");

    $.ajax({
        type:'GET',
        url : baseUrl + "set_edit_bin",
        data: {
            locationID: $(cols[1]).text(),
            binID: $(cols[2]).text(),
            locationActive: $(cols[6]).text(),
            preferredLocation: $(cols[7]).text(),
            _token: csrfToken, 
        },
        dataType: 'html',
        success : function(data) {
            $('.modal-title').html('Bin Numbers - Edit');
            $('.modal-body').html(data);
            $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="editBIN('+$(cols[2]).text()+');">Save</button>');
            $('#modal').modal('show');  
        },
    });
}

function deleteBIN(evt){
     $(evt).closest('tr').remove();
}


function IsInteger(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
 
    if((charCode==8||charCode==45||charCode==47) ||(charCode >= 48 && charCode <= 57) ){
        return true;
    }
    else {
        return false;
    }
} 

function IsDouble(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode;
 
    if((charCode==46||charCode==8||charCode==45||charCode==47) ||(charCode >= 48 && charCode <= 57) ){
        return true;
    }
    else {
        return false;
    }
}