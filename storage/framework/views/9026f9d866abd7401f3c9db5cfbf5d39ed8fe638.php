 <?php $__env->startSection('content'); ?>

<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.General Setting')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'setting.generalStore', 'files' => true, 'method' => 'post']); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Site Title')); ?> *</strong></label>
                                        <input type="text" name="site_title" class="form-control" value="<?php if($ezpos_general_setting_data): ?><?php echo e($ezpos_general_setting_data->site_title); ?><?php endif; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Site Logo')); ?></strong></label>
                                        <input type="file" name="site_logo" class="form-control" value=""/>
                                    </div>
                                    <?php if($errors->has('site_logo')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('site_logo')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Currency')); ?> *</strong></label>
                                        <input type="text" name="currency" class="form-control" value="<?php if($ezpos_general_setting_data): ?><?php echo e($ezpos_general_setting_data->currency); ?><?php endif; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Currency Position')); ?> *</strong></label><br>
                                        <?php if($ezpos_general_setting_data->currency_position == 'prefix'): ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="currency_position" value="prefix" checked> <?php echo e(trans('file.Prefix')); ?>

                                        </label>
                                        <label class="radio-inline">
                                          <input type="radio" name="currency_position" value="suffix"> <?php echo e(trans('file.Suffix')); ?>

                                        </label>
                                        <?php else: ?>
                                        <label class="radio-inline">
                                            <input type="radio" name="currency_position" value="prefix"> <?php echo e(trans('file.Prefix')); ?>

                                        </label>
                                        <label class="radio-inline">
                                          <input type="radio" name="currency_position" value="suffix" checked> <?php echo e(trans('file.Suffix')); ?>

                                        </label>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Time Zone')); ?></strong></label>
                                        <?php if($ezpos_general_setting_data): ?>
                                        <input type="hidden" name="timezone_hidden" value="<?php echo e(env('APP_TIMEZONE')); ?>">
                                        <?php endif; ?>
                                        <select name="timezone" class="selectpicker form-control" data-live-search="true" title="Select TimeZone...">
                                            <?php $__currentLoopData = $zones_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($zone['zone']); ?>"><?php echo e($zone['diff_from_GMT'] . ' - ' . $zone['zone']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Staff Access')); ?> *</strong></label>
                                        <select name="staff_access" class="selectpicker form-control">
                                            <?php if($ezpos_general_setting_data->staff_access=='all'): ?>
                                                <option selected value="all"> <?php echo e(trans('file.All Records')); ?></option>
                                                <option value="own"> <?php echo e(trans('file.Own Records')); ?></option>
                                            <?php else: ?>
                                                <option value="all"> <?php echo e(trans('file.All Records')); ?></option>
                                                <option selected value="own"> <?php echo e(trans('file.Own Records')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>                      
                            </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #general-setting-menu").addClass("active");

    if($("input[name='timezone_hidden']").val()){
        $('select[name=timezone]').val($("input[name='timezone_hidden']").val());
        $('.selectpicker').selectpicker('refresh');
    }

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>