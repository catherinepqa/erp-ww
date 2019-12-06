var counter = 0;

    //ADDING ROW
    $(function () {
        // addRow();

        $('#date').datepicker({
            todayHighlight: true
        });
    });

    function addRow(){
        var count = counter++;
        var inputs = '<tr class="tr_add">\n' +
            '<td><select class="form-control data_1 activeSelect" onchange="checkItemBin(this, []);" name="from_bin_id" selectid="'+ counter +'"><option>Select item</option></select></td>\n' +
            '<td><input type="text" class="form-control data_2 activeDesc"></td>\n' +
            '<td><input type="text" class="form-control data_3 activePref"></td>\n' +
            '<td><input type="text" class="form-control data_4 activeUnit"></td>\n' +
            '<td><input type="text" class="form-control data_5"></td>\n' +
            '<td><button class="btn data_6" type="button" id="btn'+ counter +'" onclick="inventoryDetail(this);"><i class="fa fa-pencil" data-toggle="modal" data-target=".intdetail_modal"></i></button></td>\n' +
            '</tr>';
        $('#bin tbody').append(inputs);
    }

    function addRowOnLoad(data) {
        var inputs = [];
        $.each(data.bin, function(key, value) {
            var count = counter++;
            var actions = '<a href="#/" class="edit_'+count+'" onclick="editData('+count+')"><i class="fa fa-pencil"></i></a> ' +
                '<a href="#/" class="delete_'+count+'" onclick="deleteRow('+count+')"><i class="fa fa-trash-o"></i></a>';
            inputs.push('<tr>\n' +
                '<td>'+ value.items.item_name +'</td>\n' +
                '<td>'+ value.items.item_description +'</td>\n' +
                '<td>'+ value.preferred_per_location +'</td>\n' +
                '<td>'+ value.items.unit_of_measures.abbreviation +'</td>\n' +
                '<td>'+ value.quantity +'</td>\n' +
                '<td><button class="btn" type="button" disabled value="'+ value.items.item_id +'"><i class="fa fa-pencil"></i></button></td>\n' +
                '<td>'+actions+'</td>\n' +
                '</tr>')

            return
        });

        $('#bin tbody').append(inputs);
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
            '<td><button class="btn" type="button" disabled value="'+ $('.data_6').val() +'"><i class="fa fa-pencil"></i></button></td>\n' +
            '<td>'+actions+'</td>\n' +
            '</tr>';

        if ($('.data_1').children("option:selected").val() != "Select item" && $('.data_5').val() != "") {
            var inputToForm =
                '<input type="hidden" class="inputToForm'+count+'" name="item_id[]" value="'+ $('.data_1 option:selected').attr('dataid') +'">' +
                '<input type="hidden" class="inputToFormQty'+count+'" name="quantity[]" value="'+ $('.data_5').val() +'">'
            $('#hdnDiv').append(inputToForm);

            $('#bin tbody').append(inputs);
            $('.tr_add').remove();
            addRow();
        } else {
            alert("Please fill up required fields.")
            return false;
        }

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
            '<button class="btn data6_edit_value'+dataClass+'" type="button" disabled value="'+$row.find("button").val()+'"><i class="fa fa-pencil"></i></button>';
        $('.hidden_values').html(hidden_values);



        $row.find("td:eq(0)").html('<input type="text" class="form-control data1_value_'+dataClass+'" value="'+$row.find("td:eq(0)").text()+'">');
        $row.find("td:eq(1)").html('<input type="text" class="form-control data2_value_'+dataClass+'" value="'+$row.find("td:eq(1)").text()+'">');
        $row.find("td:eq(2)").html('<input type="text" class="form-control data3_value_'+dataClass+'" value="'+$row.find("td:eq(2)").text()+'">');
        $row.find("td:eq(3)").html('<input type="text" class="form-control data4_value_'+dataClass+'" value="'+$row.find("td:eq(3)").text()+'">');
        $row.find("td:eq(4)").html('<input type="text" class="form-control data5_value_'+dataClass+'" value="'+$row.find("td:eq(4)").text()+'">');
        $row.find("td:eq(5)").html('<button class="btn" type="button" onclick="inventoryDetail(this);" value="'+$row.find("button").val()+'"><i class="fa fa-pencil" data-toggle="modal" data-target=".intdetail_modal"></i></button></td>');
        $row.find("td:eq(6)").html(actions);
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
        $row.find("td:eq(5)").html('<button class="btn" type="button" id="btn'+ dataClass +'" value="'+ $row.find("button").val() +'" disabled><i class="fa fa-pencil" ></i></button></td>');
        $row.find("td:eq(6)").html(actions);
        $('.inputToFormQty' + dataClass).val($row.find("td:eq(4)").text());
    }

    function cancelEdit(dataClass) {
        var $row = $('.cancel_edit_'+dataClass).closest("tr");
        var actions = '<a href="#/" class="edit_'+dataClass+'" onclick="editData('+dataClass+')"><i class="fa fa-pencil"></i></a> ' +
            '<a href="#/" class="delete_'+dataClass+'" onclick="deleteRow('+dataClass+')"><i class="fa fa-trash-o"></i></a>';
        $row.find("td:eq(0)").html($('.data1_edit_value'+dataClass).val());
        $row.find("td:eq(1)").html($('.data2_edit_value'+dataClass).val());
        $row.find("td:eq(2)").html($('.data3_edit_value'+dataClass).val());
        $row.find("td:eq(3)").html($('.data4_edit_value'+dataClass).val());
        $row.find("td:eq(4)").html($('.data5_edit_value'+dataClass).val());
        $row.find("td:eq(5)").html($('.data6_edit_value'+dataClass).val());
        $row.find("td:eq(6)").html(actions);
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
            var $row = $('.delete_'+dataClass).closest("tr");
            $row.remove();
        });
    }
