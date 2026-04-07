<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Order Queue</span>
                <h1>Orders</h1>
                <p class="muted">Orders include both quick counter sales and customer pre-orders.</p>
            </div>
            <a class="button-inline" href="<?php echo e(route('orders.create')); ?>">Create Order</a>
        </div>
    </section>

    <section class="card">
        <?php if($orders->isEmpty()): ?>
            <p class="muted">No orders yet.</p>
        <?php else: ?>
            <div class="order-list">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="order-row">
                        <div class="product-main">
                            <strong><?php echo e($order->order_number); ?></strong>
                            <p class="product-copy"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Type</span>
                            <span class="product-value"><?php echo e(strtoupper($order->order_type)); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Total</span>
                            <span class="product-value">Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></span>
                        </div>

                        <div class="row-actions">
                            <a href="<?php echo e(route('orders.show', $order)); ?>">View order</a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/orders/index.blade.php ENDPATH**/ ?>