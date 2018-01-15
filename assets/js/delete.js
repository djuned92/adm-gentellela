/**
this function global delete
how to use: 
1. set id table myTable
2. in controller, ex: controller : users. create function delete
3. return from controller function delete make sure json encode  
    a.message = 'data has been deleted!', 
    b.type ='success'
4. make sure uri_segment_1 name controller in this case is users for redirect
5. done happy for use :)

*/
$('#myTable').delegate('a.btn-delete', 'click', function(e){
    e.preventDefault();
    var id = $(this).data('id'),
    	uri_segment = window.location.pathname.split('/'),
        base_url = window.location.origin + '/' + uri_segment[1], // base url
        uri_segment_2 = uri_segment[2]; // name controller
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
                url: base_url + '/' + uri_segment_2 + '/delete',
                data: {id: id},
                beforeSend: function() {},
                success: function(r) {
                    if(r.error == false) {
                        swal({
                            title: 'Deleted', 
                            text: r.message, 
                            type: r.type,
                        });
                        setTimeout(function() {
                            window.location.href = base_url + '/' + uri_segment_2; 
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