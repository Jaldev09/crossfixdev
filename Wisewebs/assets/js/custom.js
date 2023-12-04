jQuery(document).ready(function($) {
    jQuery('.rel-products-slider').owlCarousel({
        loop:true,
        margin:20,
        autoplay: true,
        nav:true,
        responsive:{
            0:{
                items:3
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });

    jQuery(document).on('click','.help-option-card',function(){
        jQuery('#woo_accform_title').text(jQuery(this).children('.option-title').text());
        jQuery('#woo_account_settings').modal('show'); 
        var form_target = jQuery(this).data('target');
        jQuery('#'+form_target).show();
    });
    
    jQuery(document).on('hidden.bs.modal', '#woo_account_settings' , function (e) {
        jQuery(".account-custom-forms").hide();
    });

    jQuery(document).on('submit','#add_vehicle_form', function(e) {
        e.preventDefault();
        $(".form-ajax-loader").show();
        // Validate post title and description
        var postTitle = $('#vehicle_name').val();
        var postDescription = $('#vehicle_description').val();

        if (postTitle.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a title for your Machine.'
            });
            return;
        }

        if (postDescription.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a description for your Machine.'
            });
            return;
        }
        
        // Gather form data
        var formData = new FormData();
        formData.append('action', 'submit_add_vehicle');
        formData.append('post_title', $('#vehicle_name').val());
        formData.append('post_description', $('#vehicle_description').val());
        formData.append('upload_image', $('#upload_image')[0].files[0]);
        formData.append('security', $('#security').val());

        $(document).find('#add_vehicle_form .sheet-colunms').each(function(index) {
            formData.append('sheet_colunms_' + $(this).data('colunm'), $(this).val());
        });

        // console.log(formData);
      
        $.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $(".form-ajax-loader").hide();
                console.log(response.status);
                if(response.status == true) {
                    $(".addvehicle-form-response").addClass('success');
                    $(".addvehicle-form-response").text(response.message);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to another page after the success message
                            window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
                        }
                    });
                    return;
                }else{
                    $(".addvehicle-form-response").addClass('fail');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to another page after the success message
                            // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
                        }
                    });
                    return;
                }
                // Handle the response after post creation
                // console.log('Post created!');
            },
            error: function(error) {
                // Handle any errors
                // console.error('Error:', error);
            }
        });
    });

    jQuery(document).on('submit','#update_vehicle_form', function(e) {
        e.preventDefault();
        $(".form-ajax-loader").show();
        // Validate post title and description
        var postTitle = $('#vehicle_name').val();
        var postDescription = $('#vehicle_description').val();
        var customer_vehicle_id = $("#update_customer_machineid").val();

        if (postTitle.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a title for your Machine.'
            });
            return;
        }

        if (postDescription.trim() === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter a description for your Machine.'
            });
            return;
        }
        
        // Gather form data
        var formData = new FormData();
        formData.append('action', 'submit_update_vehicle');
        formData.append('post_title', $('#vehicle_name').val());
        formData.append('post_description', $('#vehicle_description').val());
        formData.append('customer_vehicleid', $('#update_customer_machineid').val());
        formData.append('upload_image', $('#upload_image')[0].files[0]);
        formData.append('security', $('#security').val());

        $(document).find('#update_vehicle_form .sheet-colunms').each(function(index) {
            formData.append('sheet_colunms_' + $(this).data('colunm'), $(this).val());
        });

        // console.log(formData);
      
        $.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $(".form-ajax-loader").hide();
                console.log(response.status);
                if(response.status == true) {
                    $(".addvehicle-form-response").addClass('success');
                    $(".addvehicle-form-response").text(response.message);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to another page after the success message
                            window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
                        }
                    });
                    return;
                }else{
                    $(".addvehicle-form-response").addClass('fail');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to another page after the success message
                            // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
                        }
                    });
                    return;
                }
                // Handle the response after post creation
                // console.log('Post created!');
            },
            error: function(error) {
                // Handle any errors
                // console.error('Error:', error);
            }
        });
    });

    jQuery(document).on('click',"#show_accessories_link", function(e) {
        e.preventDefault();
        var selectedValue = $("#show_accessories").val();
        var currenturl = $(this).attr('href');
        var separator = currenturl.includes('vehicle') ? '?' : '';
        var newUrl = currenturl + separator + '?id=' + selectedValue;
        // Redirect to the updated URL
        window.location.href = newUrl;
    });

    jQuery(document).on('change',"#sheet_colunm_1,#sheet_colunm_2,#sheet_colunm_3",function(e){
        e.preventDefault();
        var make_id = $(document).find("#sheet_colunm_1").val();
        var modell_id = $(document).find("#sheet_colunm_2").val();
        var year_id = $(document).find("#sheet_colunm_3").val();

        var formData = new FormData();
        formData.append('action', 'get_machine_from_make_model_year');
        formData.append('make_id', make_id);
        formData.append('modell_id', modell_id);
        formData.append('year_id', year_id);

        $("#sheet_colunm_4").append('<option>Select an Option.</option>');
        $("#sheet_colunm_4").empty();

        $.ajax({
            url: frontend_ajax_object.ajaxurl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $(document).find(".machine-error-msg").remove();
                if(response.status) {
                    console.log('hi');
                    $("#sheet_colunm_4").append(response.machine_dropdown_html);
                } else {
                    $("#sheet_colunm_4").after('<span class="machine-error-msg">'+response.message+'</span>');
                    // Swal.fire({
                    //     icon: 'error',
                    //     title: 'Error!',
                    //     text: response.message
                    // }).then((result) => {
                    //     if (result.isConfirmed) {
                    //         // Redirect to another page after the success message
                    //         // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
                    //     }
                    // });
                    return;
                }
            }
        });


    });

    jQuery(document).on('click',"#delete_customer_vehicle",function(e){
        e.preventDefault();
        var customer_vehicle_id = $(this).data("del_customerid");
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
          }).then((result) => {
            if (result.isConfirmed) {
              // Assuming customer_vehicle_id is defined somewhere
              var formData = new FormData();
              formData.append('action', 'delete_customer_vehicle');
              formData.append('customer_vehicle_id', customer_vehicle_id);
          
              $.ajax({
                url: frontend_ajax_object.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                  if (response.status) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: response.message
                    }).then((result) => {
                      if (result.isConfirmed) {
                        window.location.href = frontend_ajax_object.mittfordon_url;
                      }
                    });
                  } else {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: response.message
                    });
                  }
                }
              });
            } else {
              Swal.fire("Cancelled", "Data is not deleted!", "error");
            }
          });

    });

    // jQuery(document).on('change','#sheet_colunm_1',function(e){
    //     e.preventDefault();
        
    //     var machine_id = $(this).val();
    //     console.log(machine_id);
    //     var formData = new FormData();
    //     formData.append('action', 'get_machine_make');
    //     formData.append('machine_id', machine_id);

    //     $("#sheet_colunm_2").empty();

    //     $.ajax({
    //         url: frontend_ajax_object.ajaxurl,
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             if(response.status) {
    //                 $("#sheet_colunm_2").append(response.make_dropdown_html);
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error!',
    //                     text: response.message
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // Redirect to another page after the success message
    //                         // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
    //                     }
    //                 });
    //                 return;
    //             }
    //         }
    //     });

    // });

    // jQuery(document).on('change','#sheet_colunm_2',function(e){
    //     e.preventDefault();
        
    //     var make_id = $(this).val();
    //     var machine_id = $(document).find('#sheet_colunm_1').val();
    //     var formData = new FormData();
    //     formData.append('action', 'get_machine_modell');
    //     formData.append('machine_id', machine_id);
    //     formData.append('make_id', make_id);

    //     $("#sheet_colunm_3").empty();

    //     $.ajax({
    //         url: frontend_ajax_object.ajaxurl,
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             if(response.status) {
    //                 $("#sheet_colunm_3").append(response.modell_dropdown_html);
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error!',
    //                     text: response.message
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // Redirect to another page after the success message
    //                         // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
    //                     }
    //                 });
    //                 return;
    //             }
    //         }
    //     });

    // });

    // jQuery(document).on('change','#sheet_colunm_3',function(e){
    //     e.preventDefault();
        
    //     var modell_id = $(this).val();
    //     var machine_id = $(document).find('#sheet_colunm_1').val();
    //     var make_id = $(document).find('#sheet_colunm_2').val();
    //     var formData = new FormData();
    //     formData.append('action', 'get_machine_year');
    //     formData.append('machine_id', machine_id);
    //     formData.append('make_id', make_id);
    //     formData.append('modell_id', modell_id);

    //     $("#sheet_colunm_4").empty();

    //     $.ajax({
    //         url: frontend_ajax_object.ajaxurl,
    //         type: 'POST',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function(response) {
    //             if(response.status) {
    //                 $("#sheet_colunm_4").append(response.year_dropdown_html);
    //             } else {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error!',
    //                     text: response.message
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         // Redirect to another page after the success message
    //                         // window.location.href = frontend_ajax_object.mittfordon_url; // Replace with your desired URL
    //                     }
    //                 });
    //                 return;
    //             }
    //         }
    //     });

    // });
});