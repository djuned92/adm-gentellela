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
                              title: "<?=($this->uri->segment(2) == 'add') ? 'Add': 'Update';?>",
                              text: r.message,
                              type: "success",
                            });
                            setTimeout(function() {
                                window.location.href = "<?=base_url('users')?>";  
                            }, 2000);
                        }
                    }
                });
            }
        });
    })
</script>