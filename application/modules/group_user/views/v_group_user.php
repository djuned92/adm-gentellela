<!-- datatables -->
<link href="<?=base_url('assets/vendors/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
<div class="page-title">
    <div class="title_left">
        <h3>Group User</h3>
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
                <h2>Group User</h2>
                <div class="navbar-right">
                    <a href="<?=base_url('group_user/add')?>">
                        <button type="button" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Add
                        </button>
                    </a>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-bordered table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th width="80%">Group User</th>
                            <th width="15%">Created At</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($group_user as $key => $value):?>
                        <tr>
                            <td><?= $value['role'] ?></td>
                            <td><?= $value['created_at'] ?></td>
                            <td>
                                <ul style="list-style: none;padding-left: 0px;padding-right: 0px; text-align: center;">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-bars" style="font-size: large;"></i>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right" style="right: 0; left: auto;">
                                            <li>
                                                <a href="<?=base_url('group_user/update/'.encode($value['id']))?>">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                <a href="#" class="btn-delete" data-id="<?=encode($value['id'])?>">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- datatables -->
<script src="<?=base_url('assets/vendors/datatables/js/jquery.dataTables.js')?>"></script>
<script src="<?=base_url('assets/vendors/datatables/js/dataTables.bootstrap.js')?>"></script>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            "order": [[ 1, "asc" ]]
        });
    });
</script>
<?php $this->load->view('helper/ajax_form_delete') ?>