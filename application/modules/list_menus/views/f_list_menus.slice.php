@extends('layouts.backend')

@section('title','List Menus - Gentelella')

@section('css')
    <!-- select2 -->
    <link href="<?=base_url('assets/plugins/select2/dist/css/select2.min.css')?>" rel="stylesheet">
@endsection

@section('content')
    <div class="page-title">
        <div class="title_left">
            <h3><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>Menu</h3>
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
                    <h2><?=($this->uri->segment(2) == 'add') ? 'Add ' : 'Edit '?>Menu</h2>
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
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Menu <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="menu" class="form-control" placeholder="Menu ..." 
                                value="<?=isset($menu['menu'])?$menu['menu']:set_value('menu');?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">URL/Link </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="link" class="form-control" placeholder="URL/Link ..." 
                                value="<?=isset($menu['link'])?$menu['link']:set_value('link');?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Parent <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <select style="width: 100%;" class="form-control populate placeholder" name="parent" id="parent" required></select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Menu Order <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="number" name="menu_order" class="form-control" placeholder="Menu Order ..." 
                                value="<?=isset($menu['menu_order'])?$menu['menu_order']:set_value('menu_order');?>" required>
                            </div>
                        </div>

                        <div class="form-group" id="icon">
                            <label class="control-label col-md-2 col-sm-2 col-xs-12">Icon <span class="required">*</span></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="text" name="icon" class="form-control" id="fa_icon" placeholder="Icon ..." 
                                value="<?=isset($menu['icon'])?$menu['icon']:set_value('icon');?>" required>
                            </div>
                        </div>

                        

                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-2">
                                <a href="<?=base_url('list_menus')?>">
                                    <button type="button" class="btn btn-primary">Back</button>
                                </a>
                                <button type="submit" class="btn btn-success" id="save">Save</button>
                            </div>
                        </div>

                    </form>      
                </div>
            </div>
            <div class="x_panel">
                <div class="x_content">
                    @include('font-awesome')
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<!-- select2 -->
<script src="<?=base_url('assets/plugins/select2/dist/js/select2.min.js')?>"></script>
<!-- add update js -->
<script src="<?=base_url('assets/js/add-update.js')?>"></script>
<script>
    $(document).ready(function() {
        $('#parent').select2({
            width: 'resolve',
            data: <?php echo $list_menus; ?>
        });

        $('#parent').on('change', function(e) {
            var value = $(this).val();
            if(value == 0) {
                $('#icon').fadeIn('slow');
            } else {
                $('#icon').fadeOut('slow');
            }
        });

        <?php if($this->uri->segment(2) == 'update'): ?>
            <?php $parent = isset($menu['parent']) ? $menu['parent'] : 0 ; ?>
            $('#parent').val(<?=$parent?>).trigger('change');
        <?php endif ?>

        $('.icon-click').on('click', function() {
            var icon = $(this).attr('href'),
                icon2 = 'fa-' + icon.replace(/#\//g, ''); 
            $('#fa_icon').val(icon2);
            $("html, body").animate({ scrollTop: 0 }, 1000);
            return false;
        })
    });
</script>
@endsection