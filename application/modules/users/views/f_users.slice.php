@extends('layouts.backend')

@section('title','Privileges User - Gentelella')

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>User</h3>
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
                    <h2><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>User</h2>
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

                        <h4>User Account</h4>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Username <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="username" class="form-control" placeholder="Username ..." value="<?=isset($user['username'])?$user['username']:set_value('username');?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Password <?=($this->uri->segment(2) == 'add') ? '<span class="required">*</span>':''?></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password ..." value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Confirm Password <?=($this->uri->segment(2) == 'add') ? '<span class="required">*</span>':''?></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password ..." value="">
                            </div>
                        </div>

                        <hr>
                        <h4>User Profile</h4>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Fullname <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="fullname" class="form-control" placeholder="Fullname ..." value="<?=isset($user['fullname'])?$user['fullname']:set_value('fullname');?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Address <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <textarea class="form-control" name="address" rows="3" placeholder='Address ...'><?=isset($user['address'])?$user['address']:set_value('address');?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Phone <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="phone" class="form-control has-feedback-left" placeholder="Phone ..." value="<?=isset($user['phone'])?$user['phone']:set_value('phone');?>">
                                <span class="form-control-feedback left" aria-hidden="true">+62 </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Gender <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12 radio">
                                <label>
                                    <input type="radio" name="gender" value="1" <?=(isset($user['gender']) == 1) ? 'checked':'';?>>
                                    <i class="fa fa-male"></i> Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="2" <?=(isset($user['gender']) == 2) ? 'checked':'';?>>
                                    <i class="fa fa-female"></i> Female
                                </label>                        
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
                                <a href="<?=base_url('users')?>">
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
    <script type="text/javascript">
        function readURL(input) {

          if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
              $('#preview-image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
          }
        }

        $("#image").change(function() {
          readURL(this);
        });

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
                rules: {
                    username: {
                        required: true
                    },
                    <?php if($this->uri->segment(2) == 'add'): ?>
                        password: {
                            required: true,
                            minlength: 8,
                            maxlength: 12,
                        },
                        confirm_password: {
                            equalTo: "#password",
                        },
                    <?php endif ?>
                    fullname: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    gender: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    // form.submit();
                    var form = $('#myForm')[0],
                        data = new FormData(form);
                    <?php if($this->uri->segment(2) == 'add') : ?>
                        var this_url = "<?=base_url('users/add')?>";
                    <?php else : ?>
                        var this_url = "<?=base_url('users/update')?>";
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
@endsection