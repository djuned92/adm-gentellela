@extends('layouts.backend')

@section('title','Privileges User - Gentelella')

@section('css')
    <!-- datatables -->
    <link href="<?=base_url('assets/plugins/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
@endsection

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3>Privileges User</h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Privileges User</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th>Menu Order</th>
                                <th width="40%">Menu</th>
                                <th width="15%" class="text-center">Priv Create</th>
                                <th width="15%" class="text-center">Priv Read</th>
                                <th width="15%" class="text-center">Priv Update</th>
                                <th width="15%" class="text-center">Priv Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($user_priv as $key => $value):?>
                            <tr>
                                <td><?= $value['menu_order'] ?></td>
                                <td>
                                    <?php 
                                        switch ($value['level']) {
                                            case '1':
                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;';
                                                break;
                                            case '2':
                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;';
                                                break;
                                            case '3':
                                                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;';
                                                break;
                                            default: break;
                                        }
                                    ?>

                                    <?= $value['menu'] ?>    
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="priv_create" data-id="<?=$value['user_priv_id']?>" data-priv-is="priv_create" <?=($value['priv_create'] == 1) ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="priv_read" data-id="<?=$value['user_priv_id']?>" data-priv-is="priv_read" <?=($value['priv_read'] == 1) ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="priv_update" data-id="<?=$value['user_priv_id']?>" data-priv-is="priv_update" <?=($value['priv_update'] == 1) ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="priv_delete" data-id="<?=$value['user_priv_id']?>" data-priv-is="priv_delete" <?=($value['priv_delete'] == 1) ? 'checked' : '' ?>>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- datatables -->
    <script src="<?=base_url('assets/plugins/datatables/js/jquery.dataTables.js')?>"></script>
    <script src="<?=base_url('assets/plugins/datatables/js/dataTables.bootstrap.js')?>"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                columnDefs: [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false,
                    },
                ],
                dom: '<"row datatables-header form-inline" <"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 role text-right">><"row" <"col-md-12"<"td-content"rt>>><"row" <"col-md-6"i><"col-md-6"p>>',
                order: [[ 0, "asc" ]],
                lengthMenu: [[50, 100, -1], [50, 100, "All"]],
                scrollX: false,
            });

            $("div.role").html('<select name="role_id" id="role" class="form-control"></select>');

            $.getJSON("<?=base_url('privileges_user/get_roles')?>", function (data) {
                $.each(data, function (key,value) {
                    var id = value.id;
                    <?php if(!is_null($this->uri->segment(3))): ?>
                        var uri_segment_3 = '<?=$this->uri->segment(3)?>';
                        $('#role').append(
                            $('<option selected></option>').val(value.id).html(value.role)
                        );
                    <?php else: ?>
                        $('#role').append(
                            $('<option></option>').val(value.id).html(value.role)
                        );
                    <?php endif ?>
                });
            });

            $('#role').on('change', function() {
                var role_id = $(this).val();
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: '<?=base_url('privileges_user/check_group')?>',
                    data: {role_id: role_id},
                    beforeSend: function() {},
                    success: function(r) {
                        if(r.error == false) {
                            window.location.href = r.url;
                        }
                    },
                    error: function() {}     
                }); 
            });

            $('#myTable').on('click', 'input[type="checkbox"]', function() {
                var id  = $(this).data('id'),
                    priv_is = $(this).data('priv-is');
                    priv = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    type: 'post',
                    url: '<?=base_url('privileges_user/update_priv')?>',
                    data: {id:id, priv_is:priv_is, priv:priv},
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function() {},
                    error: function() {}
                });
            });

        });
    </script>
@endsection