<!-- 
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
 -->
<script>
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
                    base_url = "<?=base_url()?>",
                    uri_segment_1 = "<?=$this->uri->segment(1)?>";
                <?php if($this->uri->segment(2) == 'add') : ?>
                    var this_url = base_url.concat(uri_segment_1) + '/add';
                <?php else : ?>
                    var this_url = base_url.concat(uri_segment_1) + '/update';
                <?php endif ?> 
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: this_url,
                    dataType: "json",
                    data: data,
                    async: false,
                    processData: false,
                    contentType: false,
                    cache: false,
                    timeout: 600000,
                    beforeSend: function () {},
                    success: function(r) {
                        if(r.error == false) {
                            swal({
                              title: "<?=($this->uri->segment(2) == 'add') ? 'Added': 'Updated';?>",
                              text: r.message,
                              type: r.type,
                            });
                            setTimeout(function() {
                                window.location.href = "<?=base_url()?>" + uri_segment_1;  
                            }, 2000);
                        }
                    }
                });
            }
        });
    })
</script>