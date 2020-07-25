<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- theme stylesheet-->

    <style type="text/css">
        #receipt-data { font-size: 14px; }
        @media  print {
            @page  { size: portrait; }
        }
    </style>

    <script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
    <script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
    </script>
  </head>
<body>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center d-print-none"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo session()->get('message'); ?></div>
<?php endif; ?>
<div style="max-width: 300px; margin: 0 auto;">
    <?php if(preg_match('~[0-9]~', url()->previous())): ?>
        <?php $url = '../../pos'; ?>
    <?php else: ?>
        <?php $url = url()->previous(); ?>
    <?php endif; ?>
    <div class="row d-print-none">
        <span class="col-md-6">
            <a href="<?php echo e($url); ?>" class="btn btn-block btn-info"><i class="fa fa-arrow-left"></i> <?php echo e(trans('file.Back')); ?></a> 
        </span>
        <span class="col-md-6">
            <button onclick="window.print();" class="btn btn-block btn-primary"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button> 
        </span>
    </div>
        <div id="receipt-data" style="padding-top: 20px">
            <div class="text-center">
                <?php if($general_setting->site_logo): ?>
                    <img src="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" height="42" width="42" >
                <?php endif; ?>
                <h4 style="text-transform:uppercase;"><?php echo e($ezpos_user_data->company_name); ?></h4>
                
                <p><?php echo e($ezpos_store_data->address); ?>

                    <br><?php echo e(trans('file.Phone Number')); ?>: <?php echo e($ezpos_store_data->phone); ?>

                </p>
            </div>
            <p><?php echo e(trans('file.reference')); ?>: <?php echo e($ezpos_sale_data->reference_no); ?><br>
                <?php echo e(trans('file.Date')); ?>: <?php echo e($ezpos_sale_data->created_at); ?><br>
                <?php echo e(trans('file.customer')); ?>: <?php echo e($ezpos_customer_data->name); ?>

            </p>
            <table class="table table-condensed">
                <tbody>
                    <?php $__currentLoopData = $ezpos_product_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $ezpos_product_data = \App\Product::find($product_sale_data->product_id) ?>
                    <tr class="border-bottom">
                        <td><?php echo e($ezpos_product_data->name); ?></td>
                        <td class="text-center"><?php echo e($product_sale_data->qty); ?> x <?php echo e(number_format((float)($product_sale_data->total / $product_sale_data->qty), 2, '.', '')); ?></td>
                        <td class="text-right"><?php echo e(number_format((float)$product_sale_data->total, 2, '.', '')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.Total')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->total_price, 2, '.', '')); ?></th>
                    </tr>
                    <?php if($ezpos_sale_data->order_tax): ?>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.Order Tax')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->order_tax, 2, '.', '')); ?></th>
                    </tr>
                    <?php endif; ?>
                    <?php if($ezpos_sale_data->order_discount): ?>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.Order Discount')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->order_discount, 2, '.', '')); ?></th>
                    </tr>
                    <?php endif; ?>
                    <?php if($ezpos_sale_data->coupon_discount): ?>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.Coupon Discount')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->coupon_discount, 2, '.', '')); ?></th>
                    </tr>
                    <?php endif; ?>
                    <?php if($ezpos_sale_data->shipping_cost): ?>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.Shipping Cost')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->shipping_cost, 2, '.', '')); ?></th>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th colspan="2"><?php echo e(trans('file.grand total')); ?></th>
                        <th class="text-right"><?php echo e(number_format((float)$ezpos_sale_data->grand_total, 2, '.', '')); ?></th>
                    </tr>
                    <tr>
                        <?php if($general_setting->currency_position == 'prefix'): ?>
                        <th colspan="3" class="text-center"><?php echo e(trans('file.In Words')); ?>: <span style="text-transform: uppercase"><?php echo e($general_setting->currency); ?></span> <span style="text-transform: capitalize"><?php echo e(str_replace("-"," ",$numberInWords)); ?></span></th>
                        <?php else: ?>
                        <th colspan="3" class="text-center"><?php echo e(trans('file.In Words')); ?>: <span style="text-transform: capitalize"><?php echo e(str_replace("-"," ",$numberInWords)); ?></span> <span style="text-transform: uppercase"><?php echo e($general_setting->currency); ?></span></th>
                        <?php endif; ?>
                    </tr>
                </tfoot>
            </table>
            <table class="table table-striped table-condensed">
                <tbody>
                    <?php $__currentLoopData = $ezpos_payment_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(trans('file.Paid By')); ?>: <?php echo e($payment_data->paying_method); ?></td>
                        <td colspan="2"><?php echo e(trans('file.Amount')); ?>: <?php echo e(number_format((float)$payment_data->amount, 2, '.', '')); ?></td>
                        <td><?php echo e(trans('file.Change')); ?>: <?php echo e(number_format((float)$payment_data->change, 2, '.', '')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <p  class="text-center" style="font-size: 12px; padding-top:15px; ">
                <?php echo e(trans('file.Invoice Generated By')); ?> <strong><?php echo e($general_setting->site_title); ?></strong>.
                <?php echo e(trans('file.Developed By')); ?> <a style="text-decoration: none; color: #60bf62;" href="http://dubanproject.com"><strong>Duban Project</strong></a>
            </p>
        </div>
</div>

<script type="text/javascript">
    function auto_print() {     
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
