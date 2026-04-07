<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Customer Directory</span>
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
            <div class="customer-list">
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="customer-row">
                        <div class="product-main">
                            <strong><?php echo e($customer->name); ?></strong>
                            <p class="product-copy">Registered bakery customer</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Email</span>
                            <span class="product-value"><?php echo e($customer->email ?: '-'); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Phone</span>
                            <span class="product-value"><?php echo e($customer->phone ?: '-'); ?></span>
                        </div>

                        <div class="row-actions">
                            <a href="<?php echo e(route('customers.edit', $customer)); ?>">Edit customer</a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/customers/index.blade.php ENDPATH**/ ?>