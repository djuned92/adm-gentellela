/**
this function global add update in another page
how to use: 
1. set id form to myForm
2. in controller, ex: controller : users. create function in controller users name add, update
3. return from controller function delete make sure json encode  
    a.message = 'data has been added or updated!', 
    b.type ='success'
4. make sure uri_segment_2 add or update. in here im using hmvc
5. make sure uri_segment_1 name controller in this case is users for redirect
6. done happy for use :)
*/    
$(document).ready(function() {
    // set validator
    $.validator.setDefaults({
        errorClass: 'help-block',
        highlight: function(element) {
            $(element)
                .closest('.form-group')
                .addClass('has-error');
        },
        unhighlight: function(element) {
            $(element)
                .closest('.form-group')
                .removeClass('has-error')
                .addClass('has-success');
        }
    });

    $('#myForm').validate({
        submitHandler: function(form) {
            // form.submit();
            var form = $('#myForm')[0],
                data = new FormData(form),
                uri_segment = window.location.pathname.split('/'),
                base_url = window.location.origin + '/' + uri_segment[1], // base url
                uri_segment_2 = uri_segment[2]; // name controller
            
            if(uri_segment[3] == 'add') {
                var this_url = base_url + '/' + uri_segment_2 + '/add';
            } else {
                var this_url = base_url + '/' + uri_segment_2 + '/update';
            }

            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: this_url,
                dataType: "json",
                data: data,
                processData: false,
                async: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend: function () {},
                success: function(r) {
                    if(r.error == false) {
                        swal({
                          title: uri_segment[3] == 'add' ? 'Added' : 'Updated',
                          text: r.message,
                          type: r.type,
                        });
                        setTimeout(function() {
                            window.location.href = base_url + '/' + uri_segment_2;  
                        }, 2000);
                    }
                }
            });
        }
    });
});