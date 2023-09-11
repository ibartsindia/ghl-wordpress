(function( $ ) {
	'use strict';
	 
	 $( window ).load(function() {

            //getting the form id from the class of the form
            var form1 = document.getElementsByClassName('getform')[0];
            var formId=(form1['id']);
            
            const inputString = formId;
            for (let i = 0; i < inputString.length; i++) {
                const char = inputString[i];
                if (char >= '0' && char <= '9') {
                  var number=char; // Output: "1"
                  break; // Exit the loop after finding the first digit
                }
            }
            console.log(number);

            var form = document.getElementById(formId);
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
                
                // We now have all the form values in an array
                console.log(formData);
                
                $.ajax({
                    url: ajax_data.ajax_url,
                    type: 'POST',

                    data:{
                        action: 'ibs_ghl_get_form_data',
                        data: formData,
                        id:number
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
