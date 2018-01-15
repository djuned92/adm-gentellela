@extends('layouts.backend')

@section('title','Group User - Gentelella')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>Group User</h3>
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
                    <h2><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>Group User</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left" id="myForm">
                        
                        <?php if($this->uri->segment(2) == 'update'): ?>
                        <input type="hidden" name="id" value="<?=$this->uri->segment(3)?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Group User <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="role" class="form-control" placeholder="Group User ..." 
                                value="<?=isset($role['role'])?$role['role']:set_value('role');?>" required>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
                                <a href="<?=base_url('group_user')?>">
                                    <button type="button" class="btn btn-primary">Back</button>
                                </a>
                                <button type="submit" class="btn btn-success" id="save">Save</button>
                            </div>
                        </div>

                    </form>      
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- add update js -->
    <script src="<?=base_url('assets/js/add-update.js')?>"></script>
@endsection