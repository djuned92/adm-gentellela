@extends('layouts.backend')

@section('title','Users - Gentelella')

@section('css')
    <!-- datatables -->
    <link href="<?=base_url('assets/plugins/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
@endsection

@section('content')
    <?php 
        $privileges = explode(',', $priv['privileges']);
    ?>


    <div class="page-title">
        <div class="title_left">
            <h3>List User</h3>
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
                    <h2>List User</h2>
                    <?php if($privileges[0] == 1): ?>
                        <div class="navbar-right">
                            <a href="<?=base_url('users/add')?>">
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
                                <th width="3%">#</th>
                                <th width="15%">Username</th>
                                <th width="20%">Fullname</th>
                                <th width="34%">Address</th>
                                <th width="10%">Gender</th>
                                <th width="13%">Phone</th>
                                <?php if($privileges[1] == 1 || $privileges[2] == 1): ?>
                                <th width="5%">Action</th>
                                <?php endif ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($users as $key => $value): ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=$value['username']?></td>
                                <td><?=$value['fullname']?></td>
                                <td><?=$value['address']?></td>
                                <td align="center"><?=($value['gender'] == 1) ? '<i class="fa fa-male"></i>':'<i class="fa fa-female"></i>';?></td>
                                <td>+62 <?=$value['phone']?></td>
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
                                                            <a href="<?=base_url('users/update/'.encode($value['id']))?>">
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
    <!-- datatables -->
    <script src="<?=base_url('assets/plugins/datatables/js/jquery.dataTables.js')?>"></script>
    <script src="<?=base_url('assets/plugins/datatables/js/dataTables.bootstrap.js')?>"></script>
    <!-- delete js -->
    <script src="<?=base_url('assets/js/delete.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endsection