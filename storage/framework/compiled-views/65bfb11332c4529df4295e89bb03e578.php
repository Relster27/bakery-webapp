<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Owner Dashboard</span>
                <h1><?php echo e($bakery->shop_name); ?></h1>
                <p class="muted">A single control room for menu changes, stock visibility, daily revenue, and live order handling.</p>
                <div class="actions">
                    <a class="button-inline" href="<?php echo e(route('orders.create')); ?>">Create Order</a>
                    <a class="button-inline button-secondary" href="<?php echo e(route('products.create')); ?>">Add Product</a>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Customer Ordering Link</span>
                <p><a href="<?php echo e(route('menu.show', $bakery->qr_token)); ?>" target="_blank"><?php echo e(route('menu.show', $bakery->qr_token)); ?></a></p>
                <p class="muted">Use this exact public URL as the destination for your QR code at the counter or on printed packaging.</p>
            </div>
        </div>
    </section>

    <section class="grid grid-4">
        <div class="stat">
            <small>Total Products</small>
            <h2><?php echo e($stats['products']); ?></h2>
        </div>
        <div class="stat">
            <small>Registered Customers</small>
            <h2><?php echo e($stats['customers']); ?></h2>
        </div>
        <div class="stat">
            <small>Orders Today</small>
            <h2><?php echo e($stats['orders_today']); ?></h2>
        </div>
        <div class="stat">
            <small>Revenue Ledger</small>
            <h2>Rp <?php echo e(number_format((float) $stats['revenue_ledger'], 0, ',', '.')); ?></h2>
        </div>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card">
            <h2>Low Stock Watch</h2>
            <?php if($lowStockItems->isEmpty()): ?>
                <p class="muted">No product is below its reorder level right now.</p>
            <?php else: ?>
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Reorder Level</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($inventory->product?->name); ?></td>
                            <td><?php echo e($inventory->quantity_on_hand); ?></td>
                            <td><?php echo e($inventory->reorder_level); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Recent Orders</h2>
            <?php if($recentOrders->isEmpty()): ?>
                <p class="muted">No orders yet. Start from the Orders page.</p>
            <?php else: ?>
                <table>
                    <thead>
                    <tr>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order)); ?>"><?php echo e($order->order_number); ?></a><br>
                                <span class="muted"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></span>
                            </td>
                            <td><span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span></td>
                            <td>Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/dashboard/index.blade.php ENDPATH**/ ?>