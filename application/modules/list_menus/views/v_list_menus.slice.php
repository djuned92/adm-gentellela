@extends('layouts.backend')

@section('title','List Menus - Gentelella')

@section('css')
    <!-- bootstrap switch -->
    <link href="<?=base_url('assets/plugins/bootstrap-switch/bootstrap-switch.css')?>" rel="stylesheet">
    <!-- datatables -->
    <link href="<?=base_url('assets/plugins/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
@endsection

@section('content')
    <?php 
        $privileges = explode(',', $priv['privileges']);
    ?>


    <div class="page-title">
        <div class="title_left">
            <h3>Menus</h3>
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
                    <h2>Menus</h2>
                    <?php if($privileges[0] == 1): ?>
                        <div class="navbar-right">
                            <a href="<?=base_url('list_menus/add')?>">
                                <button type="button" class="btn btn-sm btn-primary">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </a>
                        </div>
                    <?php endif ?>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-bordered table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th width="30%">Menu</th>
                                <th width="14%">URL/Link</th>
                                <th width="14%">Parent</th>
                                <th width="13%">Menu Order</th>
                                <th width="6%">Icon</th>
                                <th width="13%">Is Published</th>
                                <?php if($privileges[1] == 1 || $privileges[2] == 1): ?>
                                <th width="5%">Action</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_menus as $key => $value):?>
                            <tr>
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
                                <td><?= ($value['link'] != NULL) ? '/'.$value['link']:'' ?></td>
                                <td><?= $value['menu_parent'] ?></td>
                                <td><?= $value['menu_order'] ?></td>
                                <td><?= ($value['icon'] != NULL) ? '<i class="fa '.$value['icon'].'"></i>':'' ?></td>
                                <td>
                                    <input name="is_published" type="checkbox" <?= ($value['is_published'] == 1) ? 'checked':''; ?> 
                                    data-size="small" data-id="<?= encode($value['id']) ?>">
                                </td>
                                <?php if($privileges[1] == 1 || $privileges[2] == 1): ?>
                                    <td>
                                        <ul style="list-style: none;padding-left: 0px;padding-right: 0px; text-align: center;">
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-bars" style="font-size: large;"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                                                    <?php if($privileges[1] == 1): ?>
                                                        <li>
                                                            <a href="<?=base_url('list_menus/update/'.encode($value['id']))?>">
                                                                <i class="fa fa-pencil"></i> Edit
                                                            </a>
                                                        </li>
                                                    <?php endif ?>
                                                    <?php if($privileges[1] == 1 && $privileges[2] == 1): ?>
                                                        <li class="divider"></li>
                                                    <?php endif ?>
                                                    <?php if($privileges[2] == 1): ?>           
                                                        <li>
                                                            <a href="#" class="btn-delete" data-id="<?=encode($value['id'])?>">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                        </li>
                                                    <?php endif ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                <?php endif ?>
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
<!-- bootstrap switch -->
<script src="<?=base_url('assets/plugins/bootstrap-switch/bootstrap-switch.js')?>"></script>
<!-- datatables -->
<script src="<?=base_url('assets/plugins/datatables/js/jquery.dataTables.js')?>"></script>
<script src="<?=base_url('assets/plugins/datatables/js/dataTables.bootstrap.js')?>"></script>
<!-- delete js -->
<script src="<?=base_url('assets/js/delete.js')?>"></script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "order": [[ 3, "asc" ]]
        });

        $("[type='checkbox']").bootstrapSwitch(); // init bootstrap switch
        $('input[name="is_published"]').on('switchChange.bootstrapSwitch', function(event, state) {
            // console.log(state); // true | false
            var id = $(this).data('id');
            if(state == true) {
                var is_published = 1;
            } else {
                var is_published = 0;
            }
            $.post("<?=base_url('list_menus/update_is_published')?>", { id:id, is_published:is_published });
        });
    });
</script>
@endsection