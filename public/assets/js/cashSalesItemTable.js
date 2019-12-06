var counter = 0;

    //ADDING ROW

    function addRow(){
        var count = counter++;
        var inputs = '<tr class="tr_add">\n' +
            '<td><select class="form-control data_1 activeSelect" onchange="itemDesc(this);" selectid="'+ counter +'"><option>Select item</option></select></td>\n' +
            '<td><input type="text" class="form-control data_2 activeDesc"></td>\n' +
            '<td><input type="text" class="form-control data_3 activeQty"></td>\n' +
            '<td><input type="text" class="form-control data_4 activeWeightUnit"></td>\n' +
            '<td><input type="text" class="form-control data_5 activeRate"></td>\n' +
            '<td><input type="text" class="form-control data_6 activeAmount"></td>\n' +
            '<td><input type="text" class="form-control data_7 activeTaxcode"></td>\n' +
            '<td><input type="text" class="form-control data_8 activeTaxamount"></td>\n' +
            '<td><input type="text" class="form-control data_9 activeGrossamount"></td>\n' +
            '<td><input type="text" class="form-control data_10 activeOptions"></td>\n' +
            '<td><input type="text" class="form-control data_11 activeGiftCer"></td>\n' +
            '<td><input type="text" class="form-control data_12 activeCostType"></td>\n' +
            '<td><input type="text" class="form-control data_13 activeEstCost"></td>\n' +
            '<td><input type="text" class="form-control data_14 activeMemo"></td>\n' +
            '<td><input type="text" class="form-control data_15 activeWeight"></td>\n' +
            '<td><input type="text" class="form-control data_16 activeCount"></td>\n' +
            '</tr>';
        $('#item tbody').append(inputs);
    }

    function showItemsOnLoad(data){
        var inputs = [];
        $.each(data.saleItems, function(key, value) {
            var count = counter++;
            var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
                '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')" title="'+ value.system_id +'"><i class="fa fa-trash-o"></i></a>';
            inputs.push('<tr>\n' +
                '<td id="'+ value.system_id +'">'+ value.item_name +'</td>\n' +
                '<td>'+ value.description +'</td>\n' +
                '<td>'+ value.quantity +'</td>\n' +
                '<td>'+ value.weight_unit +'</td>\n' +
                '<td>'+ value.rate +'</td>\n' +
                '<td>'+ value.amount +'</td>\n' +
                '<td>'+ value.tax_code +'</td>\n' +
                '<td>'+ value.tax_amount +'</td>\n' +
                '<td>'+ value.gross_amount +'</td>\n' +
                '<td>'+ value.options +'</td>\n' +
                '<td>'+ value.gift_certificate +'</td>\n' +
                '<td>'+ value.cost_estimate_type +'</td>\n' +
                '<td>'+ value.est_extended_cost +'</td>\n' +
                '<td>'+ value.memo +'</td>\n' +
                '<td>'+ value.item_weight +'</td>\n' +
                '<td>'+ value.manufacturer_country +'</td>\n' +
                '<td>'+actions+'</td>\n' +
                '</tr>');
            return
        });

        $('#item tbody').append(inputs);
        addRow();
    }

    $('.addBtn').click(function () {
        checkLocationItems();
        var count = counter++;
        var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')"><i class="fa fa-trash-o"></i></a>';
        var inputs = '<tr>\n' +
            '<td>'+$('.data_1').val()+'</td>\n' +
            '<td>'+$('.data_2').val()+'</td>\n' +
            '<td>'+$('.data_3').val()+'</td>\n' +
            '<td>'+$('.data_4').val()+'</td>\n' +
            '<td>'+$('.data_5').val()+'</td>\n' +
            '<td>'+$('.data_6').val()+'</td>\n' +
            '<td>'+$('.data_7').val()+'</td>\n' +
            '<td>'+$('.data_8').val()+'</td>\n' +
            '<td>'+$('.data_9').val()+'</td>\n' +
            '<td>'+$('.data_10').val()+'</td>\n' +
            '<td>'+$('.data_11').val()+'</td>\n' +
            '<td>'+$('.data_12').val()+'</td>\n' +
            '<td>'+$('.data_13').val()+'</td>\n' +
            '<td>'+$('.data_14').val()+'</td>\n' +
            '<td>'+$('.data_15').val()+'</td>\n' +
            '<td>'+$('.data_16').val()+'</td>\n' +
            '<td>'+actions+'</td>\n' +
            '</tr>';

        var inputToForm =
            '<input type="hidden" class="inputToForm'+count+'" name="item_id[]" value="'+ $('.data_1 option:selected').attr('dataid') +'">' +
            '<input type="hidden" class="inputToFormDesc'+count+'" name="description[]" value="'+ $('.data_2').val() +'">' +
            '<input type="hidden" class="inputToFormQty'+count+'" name="quantity[]" value="'+ $('.data_3').val() +'">' +
            '<input type="hidden" class="inputToFormWeight'+count+'" name="weight_unit[]" value="'+ $('.data_4').val() +'">' +
            '<input type="hidden" class="inputToFormRate'+count+'" name="rate[]" value="'+ $('.data_5').val() +'">' +
            '<input type="hidden" class="inputToFormAmount'+count+'" name="amount[]" value="'+ $('.data_6').val() +'">' +
            '<input type="hidden" class="inputToFormTaxCode'+count+'" name="tax_code_id[]" value="'+ $('.data_7').val() +'">' +
            '<input type="hidden" class="inputToFormTaxAmount'+count+'" name="tax_amount[]" value="'+ $('.data_8').val() +'">' +
            '<input type="hidden" class="inputToFormGross'+count+'" name="gross_amount[]" value="'+ $('.data_9').val() +'">' +
            '<input type="hidden" class="inputToFormOpt'+count+'" name="options[]" value="'+ $('.data_10').val() +'">' +
            '<input type="hidden" class="inputToFormGift'+count+'" name="gift_certificate[]" value="'+ $('.data_11').val() +'">' +
            '<input type="hidden" class="inputToFormCost'+count+'" name="cost_estimate_type[]" value="'+ $('.data_12').val() +'">'+
            '<input type="hidden" class="inputToFormEst'+count+'" name="est_extended_cost[]" value="'+ $('.data_13').val() +'">' +
            '<input type="hidden" class="inputToFormMemo'+count+'" name="item_memo[]" value="'+ $('.data_14').val() +'">'+
            '<input type="hidden" class="inputToFormItem'+count+'" name="item_weight[]" value="'+ $('.data_15').val() +'">' +
            '<input type="hidden" class="inputToFormCount'+count+'" name="manufacturer_country[]" value="'+ $('.data_16').val() +'">' +
            '<input type="hidden" class="inputToFormNewItem'+count+'" name="newItem[]" value="'+ $('.data_1 option:selected').attr('dataid') +'">';
        $('#hdnDiv').append(inputToForm);

        $('#item tbody').append(inputs);
        $('.tr_add').remove();
        addRow();

    });

    function editData(dataClass) {
        var $row = $('.edit_'+dataClass).closest("tr");
        var actions = '<a href="#/" class="save_edit_'+dataClass+'" onclick="saveEdit('+dataClass+')"><i class="fa fa-check"></i>  ' +
            '<a href="#/" class="cancel_edit_'+dataClass+'" onclick="cancelEdit('+dataClass+')"><i class="fa fa-times"></i></a>';

        var hidden_values = '<input type="text" class="data1_edit_value'+dataClass+'" value="'+$row.find("td:eq(0)").text()+'">' +
            '<input type="text" class="data2_edit_value'+dataClass+'" value="'+$row.find("td:eq(1)").text()+'">' +
            '<input type="text" class="data3_edit_value'+dataClass+'" value="'+$row.find("td:eq(2)").text()+'">' +
            '<input type="text" class="data4_edit_value'+dataClass+'" value="'+$row.find("td:eq(3)").text()+'">' +
            '<input type="text" class="data5_edit_value'+dataClass+'" value="'+$row.find("td:eq(4)").text()+'">' +
            '<input type="text" class="data6_edit_value'+dataClass+'" value="'+$row.find("td:eq(5)").text()+'">' +
            '<input type="text" class="data7_edit_value'+dataClass+'" value="'+$row.find("td:eq(6)").text()+'">' +
            '<input type="text" class="data8_edit_value'+dataClass+'" value="'+$row.find("td:eq(7)").text()+'">' +
            '<input type="text" class="data9_edit_value'+dataClass+'" value="'+$row.find("td:eq(8)").text()+'">' +
            '<input type="text" class="data10_edit_value'+dataClass+'" value="'+$row.find("td:eq(9)").text()+'">' +
            '<input type="text" class="data11_edit_value'+dataClass+'" value="'+$row.find("td:eq(10)").text()+'">' +
            '<input type="text" class="data12_edit_value'+dataClass+'" value="'+$row.find("td:eq(11)").text()+'">' +
            '<input type="text" class="data13_edit_value'+dataClass+'" value="'+$row.find("td:eq(12)").text()+'">' +
            '<input type="text" class="data14_edit_value'+dataClass+'" value="'+$row.find("td:eq(13)").text()+'">' +
            '<input type="text" class="data15_edit_value'+dataClass+'" value="'+$row.find("td:eq(14)").text()+'">' +
            '<input type="text" class="data16_edit_value'+dataClass+'" value="'+$row.find("td:eq(15)").text()+'">'
        $('.hidden_values').html(hidden_values);


        $row.find("td:eq(0)").html('<input type="text" class="form-control data1_value_'+dataClass+'" value="'+$row.find("td:eq(0)").text()+'">');
        $row.find("td:eq(1)").html('<input type="text" class="form-control data2_value_'+dataClass+'" value="'+$row.find("td:eq(1)").text()+'">');
        $row.find("td:eq(2)").html('<input type="text" class="form-control data3_value_'+dataClass+'" value="'+$row.find("td:eq(2)").text()+'">');
        $row.find("td:eq(3)").html('<input type="text" class="form-control data4_value_'+dataClass+'" value="'+$row.find("td:eq(3)").text()+'">');
        $row.find("td:eq(4)").html('<input type="text" class="form-control data5_value_'+dataClass+'" value="'+$row.find("td:eq(4)").text()+'">');
        $row.find("td:eq(5)").html('<input type="text" class="form-control data6_value_'+dataClass+'" value="'+$row.find("td:eq(5)").text()+'">');
        $row.find("td:eq(6)").html('<input type="text" class="form-control data7_value_'+dataClass+'" value="'+$row.find("td:eq(6)").text()+'">');
        $row.find("td:eq(7)").html('<input type="text" class="form-control data8_value_'+dataClass+'" value="'+$row.find("td:eq(7)").text()+'">');
        $row.find("td:eq(8)").html('<input type="text" class="form-control data9_value_'+dataClass+'" value="'+$row.find("td:eq(8)").text()+'">');
        $row.find("td:eq(9)").html('<input type="text" class="form-control data10_value_'+dataClass+'" value="'+$row.find("td:eq(9)").text()+'">');
        $row.find("td:eq(10)").html('<input type="text" class="form-control data11_value_'+dataClass+'" value="'+$row.find("td:eq(10)").text()+'">');
        $row.find("td:eq(11)").html('<input type="text" class="form-control data12_value_'+dataClass+'" value="'+$row.find("td:eq(11)").text()+'">');
        $row.find("td:eq(12)").html('<input type="text" class="form-control data13_value_'+dataClass+'" value="'+$row.find("td:eq(12)").text()+'">');
        $row.find("td:eq(13)").html('<input type="text" class="form-control data14_value_'+dataClass+'" value="'+$row.find("td:eq(13)").text()+'">');
        $row.find("td:eq(14)").html('<input type="text" class="form-control data15_value_'+dataClass+'" value="'+$row.find("td:eq(14)").text()+'">');
        $row.find("td:eq(15)").html('<input type="text" class="form-control data16_value_'+dataClass+'" value="'+$row.find("td:eq(15)").text()+'">');
        $row.find("td:eq(16)").html(actions);
    }

    function saveEdit(dataClass) {
        var $row = $('.save_edit_'+dataClass).closest("tr");
        var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
        $row.find("td:eq(0)").html($('.data1_value_'+dataClass).val());
        $row.find("td:eq(1)").html($('.data2_value_'+dataClass).val());
        $row.find("td:eq(2)").html($('.data3_value_'+dataClass).val());
        $row.find("td:eq(3)").html($('.data4_value_'+dataClass).val());
        $row.find("td:eq(4)").html($('.data5_value_'+dataClass).val());
        $row.find("td:eq(5)").html($('.data6_value_'+dataClass).val());
        $row.find("td:eq(6)").html($('.data7_value_'+dataClass).val());
        $row.find("td:eq(7)").html($('.data8_value_'+dataClass).val());
        $row.find("td:eq(8)").html($('.data9_value_'+dataClass).val());
        $row.find("td:eq(9)").html($('.data10_value_'+dataClass).val());
        $row.find("td:eq(10)").html($('.data11_value_'+dataClass).val());
        $row.find("td:eq(11)").html($('.data12_value_'+dataClass).val());
        $row.find("td:eq(12)").html($('.data13_value_'+dataClass).val());
        $row.find("td:eq(13)").html($('.data14_value_'+dataClass).val());
        $row.find("td:eq(14)").html($('.data15_value_'+dataClass).val());
        $row.find("td:eq(15)").html($('.data16_value_'+dataClass).val());
        $row.find("td:eq(16)").html(actions);


        $('.inputToForm' + dataClass).val($row.find("td:eq(0)").text());
        $('.inputToFormDesc' + dataClass).val($row.find("td:eq(1)").text());
        $('.inputToFormQty' + dataClass).val($row.find("td:eq(2)").text());
        $('.inputToFormWeight' + dataClass).val($row.find("td:eq(3)").text());
        $('.inputToFormRate' + dataClass).val($row.find("td:eq(4)").text());
        $('.inputToFormAmount' + dataClass).val($row.find("td:eq(5)").text());
        $('.inputToFormTaxCode' + dataClass).val($row.find("td:eq(6)").text());
        $('.inputToFormTaxAmount' + dataClass).val($row.find("td:eq(7)").text());
        $('.inputToFormGross' + dataClass).val($row.find("td:eq(8)").text());
        $('.inputToFormOpt' + dataClass).val($row.find("td:eq(9)").text());
        $('.inputToFormGift' + dataClass).val($row.find("td:eq(10)").text());
        $('.inputToFormCost' + dataClass).val($row.find("td:eq(11)").text());
        $('.inputToFormEst' + dataClass).val($row.find("td:eq(12)").text());
        $('.inputToFormMemo' + dataClass).val($row.find("td:eq(13)").text());
        $('.inputToFormItem' + dataClass).val($row.find("td:eq(14)").text());
        $('.inputToFormCount' + dataClass).val($row.find("td:eq(15)").text());

        var inputToForm =
            '<input type="hidden" class="inputToForm'+dataClass+'" name="item_id[]" value="'+ $row.find("td:eq(0)").attr('id') +'">' +
            '<input type="hidden" class="inputToFormDesc'+dataClass+'" name="description[]" value="'+ $row.find("td:eq(1)").text() +'">' +
            '<input type="hidden" class="inputToFormQty'+dataClass+'" name="quantity[]" value="'+ $row.find("td:eq(2)").text() +'">' +
            '<input type="hidden" class="inputToFormWeight'+dataClass+'" name="weight_unit[]" value="'+ $row.find("td:eq(3)").text() +'">' +
            '<input type="hidden" class="inputToFormRate'+dataClass+'" name="rate[]" value="'+ $row.find("td:eq(4)").text() +'">' +
            '<input type="hidden" class="inputToFormAmount'+dataClass+'" name="amount[]" value="'+ $row.find("td:eq(5)").text() +'">' +
            '<input type="hidden" class="inputToFormTaxCode'+dataClass+'" name="tax_code_id[]" value="'+ $row.find("td:eq(6)").text() +'">' +
            '<input type="hidden" class="inputToFormTaxAmount'+dataClass+'" name="tax_amount[]" value="'+ $row.find("td:eq(7)").text() +'">' +
            '<input type="hidden" class="inputToFormGross'+dataClass+'" name="gross_amount[]" value="'+ $row.find("td:eq(8)").text() +'">' +
            '<input type="hidden" class="inputToFormOpt'+dataClass+'" name="options[]" value="'+ $row.find("td:eq(9)").text() +'">' +
            '<input type="hidden" class="inputToFormGift'+dataClass+'" name="gift_certificate[]" value="'+ $row.find("td:eq(10)").text() +'">' +
            '<input type="hidden" class="inputToFormCost'+dataClass+'" name="cost_estimate_type[]" value="'+ $row.find("td:eq(11)").text() +'">'+
            '<input type="hidden" class="inputToFormEst'+dataClass+'" name="est_extended_cost[]" value="'+ $row.find("td:eq(12)").text() +'">' +
            '<input type="hidden" class="inputToFormMemo'+dataClass+'" name="item_memo[]" value="'+ $row.find("td:eq(13)").text() +'">'+
            '<input type="hidden" class="inputToFormItem'+dataClass+'" name="item_weight[]" value="'+ $row.find("td:eq(14)").text() +'">' +
            '<input type="hidden" class="inputToFormCount'+dataClass+'" name="manufacturer_country[]" value="'+ $row.find("td:eq(15)").text() +'">';
        $('#hdnDiv').append(inputToForm);

    }

    function cancelEdit(dataClass) {
        var $row = $('.cancel_edit_'+dataClass).closest("tr");
        var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';

        $row.find("td:eq(0)").html($('.data1_value_'+dataClass).val());
        $row.find("td:eq(1)").html($('.data2_value_'+dataClass).val());
        $row.find("td:eq(2)").html($('.data3_value_'+dataClass).val());
        $row.find("td:eq(3)").html($('.data4_value_'+dataClass).val());
        $row.find("td:eq(4)").html($('.data5_value_'+dataClass).val());
        $row.find("td:eq(5)").html($('.data6_value_'+dataClass).val());
        $row.find("td:eq(6)").html($('.data7_value_'+dataClass).val());
        $row.find("td:eq(7)").html($('.data8_value_'+dataClass).val());
        $row.find("td:eq(8)").html($('.data9_value_'+dataClass).val());
        $row.find("td:eq(9)").html($('.data10_value_'+dataClass).val());
        $row.find("td:eq(10)").html($('.data11_value_'+dataClass).val());
        $row.find("td:eq(11)").html($('.data12_value_'+dataClass).val());
        $row.find("td:eq(12)").html($('.data13_value_'+dataClass).val());
        $row.find("td:eq(13)").html($('.data14_value_'+dataClass).val());
        $row.find("td:eq(14)").html($('.data15_value_'+dataClass).val());
        $row.find("td:eq(15)").html($('.data16_value_'+dataClass).val());
        $row.find("td:eq(16)").html(actions);


        $('.inputToForm' + dataClass).val($row.find("td:eq(0)").text());
        $('.inputToFormDesc' + dataClass).val($row.find("td:eq(1)").text());
        $('.inputToFormQty' + dataClass).val($row.find("td:eq(2)").text());
        $('.inputToFormWeight' + dataClass).val($row.find("td:eq(3)").text());
        $('.inputToFormRate' + dataClass).val($row.find("td:eq(4)").text());
        $('.inputToFormAmount' + dataClass).val($row.find("td:eq(5)").text());
        $('.inputToFormTaxCode' + dataClass).val($row.find("td:eq(6)").text());
        $('.inputToFormTaxAmount' + dataClass).val($row.find("td:eq(7)").text());
        $('.inputToFormGross' + dataClass).val($row.find("td:eq(8)").text());
        $('.inputToFormOpt' + dataClass).val($row.find("td:eq(9)").text());
        $('.inputToFormGift' + dataClass).val($row.find("td:eq(10)").text());
        $('.inputToFormCost' + dataClass).val($row.find("td:eq(11)").text());
        $('.inputToFormEst' + dataClass).val($row.find("td:eq(12)").text());
        $('.inputToFormMemo' + dataClass).val($row.find("td:eq(13)").text());
        $('.inputToFormItem' + dataClass).val($row.find("td:eq(14)").text());
        $('.inputToFormCount' + dataClass).val($row.find("td:eq(15)").text());
    }

    function deleteRow(dataClass) {


        swal({
            title: "Are you sure you want to remove this data?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            confirmButtonText: "Yes",
            closeOnConfirm: true
        }, function () {

            $('.inputToForm' + dataClass).remove();
            $('.inputToFormDesc' + dataClass).remove();
            $('.inputToFormQty' + dataClass).remove();
            $('.inputToFormWeight' + dataClass).remove();
            $('.inputToFormRate' + dataClass).remove();
            $('.inputToFormAmount' + dataClass).remove();
            $('.inputToFormTaxCode' + dataClass).remove();
            $('.inputToFormTaxAmount' + dataClass).remove();
            $('.inputToFormGross' + dataClass).remove();
            $('.inputToFormOpt' + dataClass).remove();
            $('.inputToFormGift' + dataClass).remove();
            $('.inputToFormCost' + dataClass).remove();
            $('.inputToFormEst' + dataClass).remove();
            $('.inputToFormMemo' + dataClass).remove();
            $('.inputToFormItem' + dataClass).remove();
            $('.inputToFormCount' + dataClass).remove();
            $('.inputToFormNewItem' + dataClass).remove();

            var $row = $('.delete_'+dataClass).closest("tr");
            $('.deleteIDs').append('<input type="hidden" name="delete_id[]" id="deleteID" value="'+ $('.delete_'+dataClass).attr('title') +'">');
            $row.remove();
        });
    }
