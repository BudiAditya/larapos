 <?php $__env->startSection('content'); ?>

<?php if($errors->has('name')): ?>
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
<?php endif; ?>
<?php if($errors->has('rate')): ?>
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('rate')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Tax')); ?></a>
    </div>
    <div class="table-responsive">
        <table id="tax-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Rate')); ?>(%)</th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_tax_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$tax): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($tax->name); ?></td>
                    <td><?php echo e($tax->rate); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" data-id="<?php echo e($tax->id); ?>" class="open-EdittaxDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?>

                                </button>
                                </li>
                                <li class="divider"></li>
                                <?php echo e(Form::open(['route' => ['tax.destroy', $tax->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <?php echo Form::open(['route' => 'tax.store', 'method' => 'post']); ?>

            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Tax')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                <form>
                    <div class="form-group">
                    <label><strong><?php echo e(trans('file.Tax')); ?> <?php echo e(trans('file.name')); ?> *</strong></label>
                    <?php echo e(Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))); ?>

                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Rate')); ?>(%) *</strong></label>
                        <?php echo e(Form::number('rate',null,array('required' => 'required', 'class' => 'form-control', 'step' => 'any'))); ?>

                    </div>
                    <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
            	</form>
        	</div>
        <?php echo e(Form::close()); ?>

    	</div>
	</div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	<div role="document" class="modal-dialog">
		  <div class="modal-content">
		    <?php echo Form::open(['route' => ['tax.update',1], 'method' => 'put']); ?>

		    <div class="modal-header">
		      <h5 id="exampleModalLabel" class="modal-title"> <?php echo e(trans('file.update')); ?> <?php echo e(trans('file.Tax')); ?></h5>
		      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		    </div>
		    <div class="modal-body">
		      <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
		        <form>
		            <input type="hidden" name="tax_id">
		            <div class="form-group">
		                <label><strong><?php echo e(trans('file.Tax')); ?> <?php echo e(trans('file.name')); ?> *</strong></label>
		                <?php echo e(Form::text('name',null,array('required' => 'required', 'class' => 'form-control'))); ?>

		            </div>
		            <div class="form-group">
		                <label><strong><?php echo e(trans('file.Rate')); ?>(%) *</strong></label>
		                <?php echo e(Form::number('rate',null,array('required' => 'required', 'class' => 'form-control', 'step' => 'any'))); ?>

		            </div>
		            <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
		        </form>
		    </div>
		    <?php echo e(Form::close()); ?>

		  </div>
	</div>
</div>

<script type="text/javascript">
    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #tax-menu").addClass("active");

	 function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $(document).ready(function() {
    $('.open-EdittaxDialog').on('click', function() {
        var url = "tax/"
        var id = $(this).data('id').toString();
        url = url.concat(id).concat("/edit");

        $.get(url, function(data) {
            $("input[name='name']").val(data['name']);
            $("input[name='rate']").val(data['rate']);
            $("input[name='tax_id']").val(data['id']);
        });
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tax-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 3]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': {
            'style': 'multi'
        },
        'select': { style: 'multi',  selector: 'td:first-child'},
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>