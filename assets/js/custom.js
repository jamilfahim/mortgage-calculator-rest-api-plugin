jQuery(document).ready(function(){


    // jQuery("#select2-order_status-container").click(function(){
	// 	jQuery("p").load("info.html");
	// });

    //jQuery("body").hide();

    
    jQuery("select#NumberOfInsuredPersons").on('change', function(){
        let value = jQuery(this).val();

        if( value == 2 ){
            jQuery('.person-2').show();
            jQuery("#Ip2Name").attr('required', true);
            jQuery("#Ip2Surname").attr('required', true);
            jQuery("#Ip2BirthDate").attr('required', true);
            jQuery("#Ip2IsSmoker").attr('required', true);
            jQuery("#Ip1Gender").attr('required', true);
        }else {
            jQuery('.person-2').hide();
            jQuery("#Ip2Name").removeAttr('required');
            jQuery("#Ip2Surname").removeAttr('required');
            jQuery("#Ip2BirthDate").removeAttr('required');
            jQuery("#Ip2IsSmoker").removeAttr('required');
            jQuery("#Ip1Gender").removeAttr('required');
        }
    });
    let value = jQuery("select#NumberOfInsuredPersons").val();
    if( value == 2 ){
        jQuery('.person-2').show();
        jQuery("#Ip2Name").attr('required', true);
        jQuery("#Ip2Surname").attr('required', true);
        jQuery("#Ip2BirthDate").attr('required', true);
        jQuery("#Ip2IsSmoker").attr('required', true);
        jQuery("#Ip1Gender").attr('required', true);
    }

});