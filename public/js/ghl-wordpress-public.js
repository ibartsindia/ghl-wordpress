// (function( $ ) {
// 	'use strict';
	 
// 	 $( window ).load(function() {
//     // Handle Registration
//     $("body").on('submit', '#ibs-ghl-form', function(e) {
            
//             e.preventDefault();
            
//             var form_data = formSerializeArrToJson($(this).serializeArray());
//             var form_meta = formRender.actions.getData('json');
//             form_data['form_fields'] = form_meta;
//             console.log(form_meta);
//             $.ajax({
//                 url: ajax_data.ajax_url,
//                 type: 'POST',
//                 //
//                 // data: {
//                 //     action: 'ibs_ghl_save_form',
//                 //     data: form_data
//                 // },
//                 // success: function(response) {
//                 //     var res = JSON.parse(response);
//                 //     if(res.status == 201) {
//                 //         window.location = res.url;
//                 //     }
//                 //     console.log(res);
//                 // },
//                 complete: function() {
                    
//                 }
//             });
//         });
//         function formSerializeArrToJson(formSerializeArr){
//           var jsonObj = {};
//           jQuery.map( formSerializeArr, function( n, i ) {
//               jsonObj[n.name] = n.value;
//           });
  
//           return jsonObj;
//       }
//       });
//     });