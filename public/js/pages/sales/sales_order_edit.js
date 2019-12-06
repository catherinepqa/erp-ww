$(function () {
    var App = {
        baseUrl : window.location.protocol + '//' + window.location.host + '/sales/',
        csrfToken : $('meta[name="csrf-token"]').attr('content'),

        init: function () {
            this.setElements();
            this.bindEvents();
        },
  
        setElements: function () {
            this.$customer_name = $('#customer-name'); 
            this.$sales_order_date = $('#sales-order-date'); 
            this.$sales_effective_date = $('#sales-effective-date'); 
            this.$discount_item = $('#discount-item'); 
            this.$shipping_date = $('#shipping-date'); 
            this.$shipping_tax_code = $('#shipping-tax-code'); 
            this.$currency = $('#currency'); 

            this.$add_item = $('#add-item'); 
            this.$save_top = $('#save-top'); 
            this.$save_bottom = $('#save-bottom'); 
            this.$cancel_top = $('#cancel-top'); 
            this.$cancel_bottom = $('#cancel-bottom'); 
        },
      
        bindEvents: function () {
            this.$customer_name.on('change', this.getCustomerDetails);

            this.$sales_order_date.datepicker({
                todayHighlight: true
            });

            this.$sales_effective_date.datepicker({
                todayHighlight: true
            });

            this.$discount_item.on('change', this.setDiscountRate);

            this.$shipping_date.datepicker({
                todayHighlight: true
            });

            this.$shipping_tax_code.on('change', this.setTaxRate);
            this.$currency.on('change', this.setExchangeRate);

            this.$add_item.on('click', this.setNewItem);
            this.$save_top.on('click', this.updateSalesOrder);
            this.$save_bottom.on('click', this.updateSalesOrder);
            this.$cancel_top.on('click', this.cancel);
            this.$cancel_bottom.on('click', this.cancel);
            
        },

        getCustomerDetails : function() {
            $.ajax({
                type:'GET',
                url : App.baseUrl + "get_customer_details",
                data: {
                    _token: App.csrfToken, 
                    customerID : App.$customer_name.val()
                },
                dataType: 'json',
                success : function(data) {
                   $('#customer-email').val(data[0].email_1);
                   $('#ship-to').val(App.$customer_name.find('option:selected').text());
                   $('#shipping-address').val(data[0].shipping_address);
                   $('#bill-to').val(App.$customer_name.find('option:selected').text());
                   $('#billing-address').val(data[0].billing_address);
                },
            });
        },

        setDiscountRate : function() {
            $('#discount-rate').val(App.$discount_item.val().split("~")[1] + '%');
        },

        setTaxRate : function() {
            $('#shipping-tax-rate').val(App.$shipping_tax_code.val().split("~")[1] + '%');
        },

        setExchangeRate : function() {
            $('#exchange-rate').val(App.$currency.val().split("~")[1]);
        },

        setNewItem :  function() {
            $.ajax({
                type:'GET',
                url : App.baseUrl + "set_new_item",
                data: {
                    _token: App.csrfToken, 
                },
                dataType: 'html',
                success : function(data) {
                    $('.modal-title').html('Items <i class="fa fa-angle-right green"></i> New');
                    $('.modal-body').html(data);
                    $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="createItem();">Save</button>');
                    $('#modal').modal('show');  
                },
            });
        },

        updateSalesOrder : function() {
            if (!$('#form').parsley().validate()) { bootstrap_alert.warning('#alert', ' There are some error/s, please correct them bellow.'); return; }
            
            bootstrap_alert.close('#alert');   

            swal({
                title: "",
                text: "Are you sure you want to update this record?",
                type: "warning",
                confirmButtonText: "Yes",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: false,
            }, function () {
                $.ajax({
                    type:'POST',
                    url : App.baseUrl + "update_sales_order",
                    data: {
                        salesOrderID: $('#sales-order-id').val(),
                        salesOrderNo: $('#sales-order-no').val(),
                        customerID: App.$customer_name.val(),
                        customerEmail: $('#customer-email').val(),
                        salesOrderDate: App.$sales_order_date.val(),
                        salesEffectiveDate: App.$sales_effective_date.val(),
                        poNo: $('#po-no').val(),
                        internalStatus: $('#internal-status').val(),
                        webStatus: $('#web-status').val(),
                        departmentID: $('#departments').val(),
                        locationId: $('#location').val(),
                        customerMemo: $('#customer-memo').val(),
                        internalMemo: $('#internal-memo').val(),
                        couponCode: $('#coupon-code').val(),
                        discountItemID: App.$discount_item.val().split("~")[0],
                        discountRate: $('#discount-rate').val().replace('%', ''),
                        shippingDate: App.$shipping_date.val(),
                        shippingCarrierID: $('#shipping-carrier').val(),
                        shippingCost: $('#shipping-cost').val(),
                        shippingTaxCode: App.$shipping_tax_code.val().split("~")[0],
                        shippingTaxRate: $('#shipping-tax-rate').val().replace('%', ''),    
                        shipTo: $('#ship-to').val(),   
                        shippingAddress: $('#shipping-address').val(), 
                        termID: $('#terms').val(),   
                        billTo: $('#bill-to').val(),
                        billingAddress: $('#billing-address').val(),
                        paymentMethodID: $('#payment-method').val(),
                        currencyID: App.$currency.val().split("~")[0],
                        exchangeRate: $('#exchange-rate').val(),
                        salesOrderItems : App.salesOrderItems(),
                        _token: App.csrfToken, 
                    },
                    dataType: 'json',
                    success : function(data) {
                        swal({
                            title: "Success!",
                            text: "1 row successfully updated.",
                            type: "success",
                        }, function () {
                            window.location.href = App.baseUrl + "sales_order/view/" + $('#sales-order-id').val(); 
                        });
                    },
                    error : function(request, status, error) {
                        alert(error);
                    }
                });
             });
        },

        salesOrderItems : function() {
            var dt = [];

            $('#tblitems tbody tr').each(function(row, tr){
                var cols = $(tr).children('td');

                dt.push({
                    "systemID" : $(cols[0]).text(),
                    "itemID" : $(cols[2]).text(),
                    "quantity" : $(cols[11]).text(),
                    "unitTypeID" :  $(cols[3]).text(),
                    "taxCodeID" :  $(cols[4]).text(),
                    "taxRate" :  $(cols[14]).text().replace('%', ''),
                    "rate" :  $(cols[15]).text(),
                    "amount" :  $(cols[16]).text(),
                    "grossAmount" :  $(cols[17]).text(),
                    "taxAmount" :  $(cols[18]).text(),
                    "commitID" :  $(cols[5]).text(),
                    "orderPriority" :  $(cols[20]).text(),
                    "costEstimateTypeID" :  $(cols[6]).text(),
                    "estExtendedCost" :  $(cols[22]).text(),
                    "createWO" :  $(cols[23]).text() == 'Yes' ? 1 : 0,
                    "createCustomisation" :  $(cols[24]).text() == 'Yes' ? 1 : 0,
                    "customisationName" :  $(cols[25]).text(),
                    "customisationNotes" :  $(cols[26]).text()
                });
            });

            return dt;
        },   

        cancel : function() {
            window.history.back();
        }         
    }
    
    App.init();
}); 

function setEditItem(evt){
    var baseUrl = window.location.protocol + '//' + window.location.host + '/sales/';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    var cols = $(evt).parents("tr").children("td");

    $.ajax({
        type:'GET',
        url : baseUrl + "set_edit_item",
        data: {
            itemID: $(cols[2]).text(),
            unitTypeID: $(cols[3]).text(),
            taxCodeID: $(cols[4]).text(),
            commitID: $(cols[5]).text(),
            costEstimateTypeID: $(cols[6]).text(),
            itemName: $(cols[8]).text(),
            itemDescription: $(cols[9]).text(),
            onHand: $(cols[10]).text(),
            quantity: $(cols[11]).text(),
            units: $(cols[12]).text(),
            taxCode: $(cols[13]).text(),
            taxRate: $(cols[14]).text(),
            rate: $(cols[15]).text(),
            amount: $(cols[16]).text(),
            grossAmount: $(cols[17]).text(),
            taxAmount: $(cols[18]).text(),
            orderPriority: $(cols[20]).text(),
            estExtendedCost: $(cols[22]).text(),
            withWorkOrder: $(cols[23]).text(),
            withCustomisation: $(cols[24]).text(),
            customisationName: $(cols[25]).text(),
            memo: $(cols[26]).text(),
            _token: csrfToken, 
        },
        dataType: 'html',
        success : function(data) {
            $('.modal-title').html('Items <i class="fa fa-angle-right green"></i> Edit');
            $('.modal-body').html(data);
            $('.modal-footer').html('<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary" onClick="editItem('+$(cols[2]).text()+');">Save</button>');
            $('#modal').modal('show');  
        },
    });
}

function deleteItem(evt){
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