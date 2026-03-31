<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="actions">
            <div>
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
            <table>
                <thead>
                <tr>
                    <th>Order</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($order->order_number); ?></strong><br>
                            <span class="muted"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></span>
                        </td>
                        <td><?php echo e(strtoupper($order->order_type)); ?></td>
                        <td><span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span></td>
                        <td>Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></td>
                        <td><a href="<?php echo e(route('orders.show', $order)); ?>">Details</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/orders/index.blade.php ENDPATH**/ ?>