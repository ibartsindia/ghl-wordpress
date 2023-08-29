(function( $ ) {
	'use strict';
	 
	 $( window ).load(function() {
            
        // Handle Registration
        $("body").on('submit', '#ibs-ghl-add-form', function(e) {
            
            e.preventDefault();
            
            var form_data = formSerializeArrToJson($(this).serializeArray());
            var form_meta = formBuilder.actions.getData('json');
            form_data['form_fields'] = form_meta;
            
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'ibs_ghl_save_form',
                    data: form_data
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res.status == 201) {
                        window.location = res.url;
                    }
                    console.log(res);
                },
                complete: function() {
                    
                }
            });
        });
        
        // Handle Login
        $("body").on('submit', '#meetspro-login-form', function(e) {
            e.preventDefault();
            $('#meetspro-loader').show();
            
            var form_data = formSerializeArrToJson($(this).serializeArray());
            
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_login',
                    data: form_data
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['status'] == 'success') {
                        var success = '<div class="alert alert-success" role="alert">'+res['message']+'</div>';
                        console.log(success);
                        $("#meetspro-alert").html(success);
                        setTimeout(function(){ window.location = res['redirect_url'] }, 2000);
                    } else {
                        var errors = '';
                        res.forEach(function(item) {
                            
                        console.log(item);
                            errors += '<div class="alert alert-danger" role="alert">'+item+'</div>';
                            $("#meetspro-alert").html(errors);
                            setTimeout(function(){ $("#meetspro-alert").html(''); }, 2000);
                        });
                    }
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    $('#meetspro-loader').hide();
                }
            });
        });
        
        // Handle Logout
        $("body").on('click', '#meetspro-logout', function(e) {
            e.preventDefault();
            $('#meetspro-loader').show();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_logout', // AJAX action name
                    nonce: ajax_data.logout_nonce // Nonce value
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['status'] == 'success') {
                        var success = '<div class="alert alert-success" role="alert">'+res['message']+'</div>';
                        $("#meetspro-alert").html(success);
                        setTimeout(function(){ window.location = res['redirect_url'] }, 2000);
                    } else {
                        var errors = '';
                        res.forEach(function(item) {
                            errors = '<div class="alert alert-danger" role="alert">'+item+'</div>';
                            $("#meetspro-alert").html(errors);
                            setTimeout(function(){ $("#meetspro-alert").html(''); }, 2000);
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    $('#meetspro-loader').hide();
                }
            });
        });
        
        // Handle Add Balance
        $("body").on('submit', '#meetspro-dashboard #add-money-form', function(e) {
            e.preventDefault();
            //$('#meetspro-loader').show();
            
            var form_data = formSerializeArrToJson($(this).serializeArray());
            
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_add_balance',
                    data: form_data
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['status'] == 'success') {
                        var url = res['response']['data']['url'];
                        $("#addBalanceLink").attr('src', url);
                        $('#addBalance').modal('show');
                    } else {
                        var html = '<small class="text-danger">'+res['message']+'</small>';
                        $("#add-balance-error").html(html);
                        setTimeout(function(){ $("#add-balance-error").html(''); }, 2000);
                    }
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    //$('#meetspro-loader').hide();
                }
            });
            
            
        });
        
        // Handle Balance Transfer
        $("body").on('submit', '#meetspro-dashboard #transfer-form', function(e) {
            e.preventDefault();
            //$('#meetspro-loader').show();
            
            var form_data = formSerializeArrToJson($(this).serializeArray());
            
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_transfer_fund',
                    data: form_data
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['code'] == 200) {
                        var success = '<div class="alert alert-success" role="alert">'+res['message']+'</div>';
                        $("#transferError").html(success);
                        setTimeout(function(){ $("#transferError").html(''); }, 2000);
                    } else {
                        var error = '<div class="alert alert-danger" role="alert">'+res['message']+'</div>';
                        $("#transferError").html(error);
                        setTimeout(function(){ $("#transferError").html(''); }, 2000);
                    }
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    //$('#meetspro-loader').hide();
                }
            });
            
            
        });
        
        // Handle Issue Card
        $("body").on('click', '#issue-card', function(e) {
            e.preventDefault();
            $('#meetspro-spinner').show();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_issue_card', // AJAX action name
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    if(res['code'] == 200) {
                        var success = '';
                        res['message'].forEach(function(item) {
                            var success = '<div class="alert alert-success" role="alert">'+item[1]+'</div>';
                            $("#meetspro-alert").html(success);
                            setTimeout(function(){
                                $("#meetspro-alert").html('');
                                $("#v-pills-cards-tab").trigger("click");
                            }, 2000);
                        });
                    } else {
                        var errors = '';
                        res['message'].forEach(function(item) {
                            errors = '<div class="alert alert-danger" role="alert">'+item[1]+'</div>';
                            $("#meetspro-alert").html(errors);
                            setTimeout(function(){ $("#meetspro-alert").html(''); }, 2000);
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    $('#meetspro-spinner').hide();
                }
            });
        });
        
        // Handle Block Card
        $("body").on('click', '#block-card', function(e) {
            e.preventDefault();
            $('#meetspro-spinner').show();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_block_card', // AJAX action name
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['code'] == 200) {
                        $("#card-status").html(res['status']);
                        $("#card-button").html(res['button']);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    $('#meetspro-spinner').hide();
                }
            });
        });
        
        // Handle Unblock Card
        $("body").on('click', '#unblock-card', function(e) {
            e.preventDefault();
            $('#meetspro-spinner').show();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'meetspro_unblock_card', // AJAX action name
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if(res['code'] == 200) {
                        $("#card-status").html(res['status']);
                        $("#card-button").html(res['button']);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('AJAX Error:', errorThrown);
                },
                complete: function() {
                    // Hide the loader after the AJAX request is complete
                    $('#meetspro-spinner').hide();
                }
            });
        });
        
        //handle deletion
        $("body").on('click', '#trash-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                data: {
                    action: 'ibs_ghl_trash_form',
                    data: $(this).attr("data-id")                  
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                        console.log(response[0].url);
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle edit
        $("body").on('click', '#edit-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_edit_form',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle settings
        $("body").on('click', '#settings-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_form_settings',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle preview
        $("body").on('click', '#preview-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_form_preview',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle All
        $("body").on('click', '#All-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_all_form',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle Trash Preview
        $("body").on('click', '#Trash-preview-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_trash_form_preview',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle delete form permanently 
        $("body").on('click', '#delete-permanently-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_delete_permanently',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

         
        //handle restore form from trash 
         $("body").on('click', '#restore-button', function(e) {
            e.preventDefault();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_restore_form',
                    data: $(this).attr("data-id"),
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

         //handle seaching of the form 
         $("body").on('click', '#search-submit-button', function(e) {
            e.preventDefault();
            var searchValue = $('#search').val();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_search_form',
                    data: searchValue,
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        //handle seaching of the form in trash 
        $("body").on('click', '#search-trash-submit-button', function(e) {
            e.preventDefault();
            var searchValue = $('#search-trash').val();
            $.ajax({
                url: ajax_data.ajax_url,
                type: 'POST',
                
                data: {
                    action: 'ibs_ghl_search_trash_form',
                    data: searchValue,
                },
                success: function(response) {
                    if (response[0].status === 201) {
                        window.location.href = response[0].url;
                    }
                },
                complete: function() {
                    
                }
            });
            
        });

        // Function to change serialize array into json
        function formSerializeArrToJson(formSerializeArr){
            var jsonObj = {};
            jQuery.map( formSerializeArr, function( n, i ) {
                jsonObj[n.name] = n.value;
            });
    
            return jsonObj;
        }
        
	 });
	 
})( jQuery );