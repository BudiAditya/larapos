
<?php $__env->startSection('content'); ?>
<section>
	<div class="col-md-12">
			<?php echo e(Form::open(['route' => 'report.storeStock', 'method' => 'post', 'id' => 'report-form'])); ?>

			<input type="hidden" name="store_id_hidden" value="<?php echo e($store_id); ?>">
			<h3 class="text-center"><?php echo e(trans('file.Stock Chart')); ?> &nbsp;
			<select class="selectpicker" id="store_id" name="store_id">
				<option value="0"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Store')); ?></option>
				<?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</select>
			</h3>
			<?php echo e(Form::close()); ?>

		
		<div class="col-md-6 offset-md-3 mt-3">
			<div class="row">
				<div class="col-md-6">
					<div class="colored-box green-bg">
						<i class="fa fa-star"></i>
						<h4>Total <?php echo e(trans('file.Items')); ?></h4>
						<p class="text-center"><strong><?php echo e(number_format((float)$total_item, 2, '.', '')); ?></strong></p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="colored-box orange-bg">
						<i class="fa fa-star"></i>
						<h4>Total <?php echo e(trans('file.Quantity')); ?></h4>
						<p class="text-center"><strong><?php echo e(number_format((float)$total_qty, 2, '.', '')); ?></strong></p>
					</div>
				</div>	
			</div>		
		</div>
			
		<div class="col-md-6 offset-md-3 mt-3">
			<div class="pie-chart">
		      <canvas id="pieChart" data-price=<?php echo e($total_price); ?> data-cost=<?php echo e($total_cost); ?> width="100" height="100"> </canvas>
		    </div>
		</div>
	</div>
</section>

<script type="text/javascript">
	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #store-stock-menu").addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>