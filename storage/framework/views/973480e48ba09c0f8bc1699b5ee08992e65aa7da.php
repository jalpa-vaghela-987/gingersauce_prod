<table width="100%" border="1" style="border-collapse: collapse; font-family: Arial, Helvetica, sans-serif">
    <tr style="background-color: #ccc">
        <th width="100">Date</th>
        <th width="100">Number of Registrants</th>
        <th width="150">Number official books</th>
        <th width="150">Number of Completed books</th>
        <?php for($i=1; $i<=24; $i++): ?>
            <th>#<?php echo e($i); ?></th>
        <?php endfor; ?>
        <th>Num of invoices</th>
        <th>Sum of invoices</th>
        <th>Existing subscription</th>
        <th>New subscription</th>
    </tr>

    <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e(\Carbon\Carbon::parse($row['date'])->format('d/m/Y')); ?></td>
            <td><?php echo e($row['users'] ?: ''); ?></td>
            <td><?php echo e(\Arr::get($row['books'], 'public')); ?></td>
            
            <td><?php echo e(\Arr::get($row['books'], 'pdf')); ?></td>
            <?php for($i=1; $i<=24; $i++): ?>
                <td><?php echo e(\Arr::get($row['books'], $i)); ?></th>
            <?php endfor; ?>
            <td><?php echo e(\Arr::get($row['invoices'], 'invoices')); ?></td>
            <td><?php echo e(\Arr::get($row['invoices'], 'invoices_sum')); ?></td>
            <td><?php echo e(\Arr::get($row['existing_subscriptions'], 'existing_subscriptions')); ?></td>
            <td><?php echo e(\Arr::get($row['new_subscriptions'], 'new_subscriptions')); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
<?php /**PATH /Users/pankaj/code/gingersauce_prod/resources/views/stats/index.blade.php ENDPATH**/ ?>