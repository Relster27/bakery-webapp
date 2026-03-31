<?php $__env->startSection('content'); ?>
    <section class="hero">
        <h1><?php echo e($order->order_number); ?></h1>
        <p class="muted">
            <?php echo e(strtoupper($order->order_type)); ?> order for <?php echo e($order->customer?->name ?? 'Walk-in customer'); ?>

        </p>
        <div class="actions">
            <span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span>
            <span class="badge">Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></span>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="card stack">
            <h2>Order Summary</h2>
            <p><strong>Type:</strong> <?php echo e(strtoupper($order->order_type)); ?></p>
            <p><strong>Status:</strong> <?php echo e(strtoupper($order->order_status)); ?></p>
            <p><strong>Customer:</strong> <?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></p>
            <p><strong>Ordered At:</strong> <?php echo e($order->ordered_at?->format('d M Y H:i')); ?></p>
            <p><strong>Pickup Time:</strong> <?php echo e($order->pickup_time?->format('d M Y H:i') ?? '-'); ?></p>
            <p><strong>Expires At:</strong> <?php echo e($order->expires_at?->format('d M Y H:i') ?? '-'); ?></p>
            <p><strong>Platform Fee:</strong> Rp <?php echo e(number_format((float) $order->platform_fee, 0, ',', '.')); ?></p>
            <p><strong>Notes:</strong> <?php echo e($order->notes ?: '-'); ?></p>
        </div>

        <div class="card stack">
            <h2>Status Actions</h2>
            <p class="muted">Use these buttons to move pre-orders through the bakery workflow.</p>

            <?php if(! in_array($order->order_status, ['completed', 'expired'], true)): ?>
                <div class="actions">
                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="baking">
                        <button class="button-inline" type="submit">Mark Baking</button>
                    </form>

                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="ready">
                        <button class="button-inline" type="submit">Mark Ready</button>
                    </form>

                    <form action="<?php echo e(route('orders.status.update', $order)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <input type="hidden" name="status" value="completed">
                        <button class="button-inline" type="submit">Mark Completed</button>
                    </form>

                    <?php if($order->order_type === 'preorder'): ?>
                        <form action="<?php echo e(route('orders.expire', $order)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button class="button-inline button-secondary" type="submit">Expire & Return Stock</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="muted">This order is already finished, so no more status changes are available.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Ordered Items</h2>
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($item->product?->name); ?></td>
                    <td><?php echo e($item->quantity); ?></td>
                    <td>Rp <?php echo e(number_format((float) $item->unit_price, 0, ',', '.')); ?></td>
                    <td>Rp <?php echo e(number_format((float) $item->subtotal_item, 0, ',', '.')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/orders/show.blade.php ENDPATH**/ ?>