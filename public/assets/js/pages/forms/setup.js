$(function () {
    //Accordion in INDEX; Filtered View
    $(".accordion-thumb").click(function() {
        $(this).closest( "li" ).toggleClass("is-active").children(".accordion-panel").slideToggle("ease-out");
    });

    //Limit characters to 10 only
    $('.limit-ten').attr('maxLength', 10);

    //Limit characters to 20 only
    $('.limit-twenty').attr('maxLength', 20);

    //Datepicker used in forms
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        todayHighlight: true,
    });

    //Integration of Sweet Alert
    var type = document.body.dataset.notificationType;
    switch(type){
        case 'success':
            swal({
                title:'Success!',
                text: document.body.dataset.notificationMessage,
                timer:5000,
                type:'success'
            });
            break;

        case 'error':
            toastr.error(JSON.parse(document.body.dataset.notificationMessage));
            break;
    }
});
