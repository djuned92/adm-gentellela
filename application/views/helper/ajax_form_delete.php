<script>
	$('#myTable').delegate('a.btn-delete', 'click', function(e){
        e.preventDefault();
        var id = $(this).data('id'),
        	base_url = "<?=base_url()?>",
            uri_segment_1 = "<?=$this->uri->segment(1)?>";
        swal({
            title: "Confirm Delete Data",
            text: "Are you sure delete this data?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Delete',
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm){
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: base_url.concat(uri_segment_1) + '/delete',
                    data: {id: id},
                    beforeSend: function() {},
                    success: function(r) {
                        if(r.error == false) {
                            swal(r.message, "", r.type);
                            setTimeout(function() {
                                window.location.href = base_url.concat(uri_segment_1);  
                            }, 2000);
                        }
                    },
                    error: function(e) {}
                });
            } else {
                swal("Failure", "Delete Cancel", "error");
            }
        });
    });
</script>