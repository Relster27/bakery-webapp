<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="actions">
            <div>
                <h1>Customers</h1>
                <p class="muted">Customers can come from manual owner input or from public pre-orders.</p>
            </div>
            <a class="button-inline" href="<?php echo e(route('customers.create')); ?>">Add Customer</a>
        </div>
    </section>

    <section class="card">
        <?php if($customers->isEmpty()): ?>
            <p class="muted">No customers yet.</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($customer->name); ?></td>
                        <td><?php echo e($customer->email ?: '-'); ?></td>
                        <td><?php echo e($customer->phone ?: '-'); ?></td>
                        <td><a href="<?php echo e(route('customers.edit', $customer)); ?>">Edit</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/customers/index.blade.php ENDPATH**/ ?>