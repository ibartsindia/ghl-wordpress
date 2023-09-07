(function( $ ) {
	'use strict';
	 
	 $( window ).load(function() {
        // var formButtons = document.querySelectorAll('.form-button');
        // formButtons.forEach(function(submit) {
        // var formId = $(this).attr("id");
            // const event = new Event("start");
            // document.dispatchEvent(event);
            // var formId=id;



            var form = document.getElementById('ibs-ghl-form1');
            // Add a submit event listener to the form
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the default form submission

                var formData = [];

                // Loop through the form elements and push their values into the array
                for (var i = 0; i < form.elements.length; i++) {
                    var element = form.elements[i];
                    if (element.type !== 'submit') { // Exclude the submit button
                        formData.push({
                            name: element.name,
                            value: element.value
                        });
                    }
                }
                formData=formSerializeArrToJson($(this).serializeArray());
                
                // You now have all the form values in an array
                console.log(formData);
                $.ajax({
                    url: ajax_data.ajax_url,
                    type: 'POST',

                    data:{
                        action: 'ibs_ghl_get_form_data',
                        data: formData,
                        id:1
                    },
                    
                    // contentType: 'application/json',
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });

            });
        // });


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
