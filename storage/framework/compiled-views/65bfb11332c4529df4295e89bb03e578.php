<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Owner Dashboard</span>
                <h1><?php echo e($bakery->shop_name); ?></h1>
                <p class="muted">A single control room for menu changes, stock visibility, daily revenue, and live order handling.</p>
                <div class="actions">
                    <a class="button-inline" href="<?php echo e(route('orders.create')); ?>">Create Order</a>
                    <a class="button-inline" href="<?php echo e(route('products.create')); ?>">Add Product</a>
                    <a class="button-inline button-secondary" href="<?php echo e(route('discounts.index')); ?>">Flash Sale Rules</a>
                    <a class="button-inline button-secondary" href="<?php echo e(route('analytics.index')); ?>">Sales Analytics</a>
                </div>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Public Ordering Link</span>
                <p><a href="<?php echo e(route('menu.show', $bakery->public_slug)); ?>" target="_blank"><?php echo e(route('menu.show', $bakery->public_slug)); ?></a></p>
                <p class="muted">Share this public URL directly with customers so they can browse the menu and place a pickup order.</p>
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
        <div class="stat">
            <small>Active Discounts</small>
            <h2><?php echo e($stats['active_discounts']); ?></h2>
        </div>
        <div class="stat">
            <small>Custom Cake Requests</small>
            <h2><?php echo e($stats['custom_cake_requests']); ?></h2>
        </div>
    </section>

    <section class="card stack" style="margin-top: 1rem;">
        <div>
            <h2>Revenue & Fee Transparency</h2>
            <p class="muted">This section separates gross value, discount givebacks, customer payments, and the 3% platform fee already calculated on each transaction.</p>
        </div>

        <div class="metric-grid">
            <div class="metric-card">
                <h3>Gross Before Discount</h3>
                <strong>Rp <?php echo e(number_format((float) $transparency['gross_before_discount'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Discounts Given</h3>
                <strong>Rp <?php echo e(number_format((float) $transparency['discounts_given'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Customer Paid</h3>
                <strong>Rp <?php echo e(number_format((float) $transparency['customer_paid'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Platform Fees</h3>
                <strong>Rp <?php echo e(number_format((float) $transparency['platform_fees'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Net After Fees</h3>
                <strong>Rp <?php echo e(number_format((float) $transparency['net_after_fees'], 0, ',', '.')); ?></strong>
            </div>
        </div>
    </section>

    <section class="grid grid-2 dashboard-panels">
        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Low Stock Watch</h2>
                    <p class="muted">Products that need attention before they run too low.</p>
                </div>
            </div>

            <?php if($lowStockItems->isEmpty()): ?>
                <p class="muted">No product is below its reorder level right now.</p>
            <?php else: ?>
                <div class="dashboard-list">
                    <?php $__currentLoopData = $lowStockItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="dashboard-row">
                            <div class="dashboard-main">
                                <strong><?php echo e($inventory->product?->name); ?></strong>
                                <p class="product-copy"><?php echo e($inventory->product?->category); ?></p>
                                <div class="dashboard-details">
                                    <div class="dashboard-detail">
                                        <span class="product-label">Stock</span>
                                        <span class="product-value"><?php echo e($inventory->quantity_on_hand); ?></span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Reorder Level</span>
                                        <span class="product-value"><?php echo e($inventory->reorder_level); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="<?php echo e(route('inventories.index')); ?>">Manage stock</a>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card dashboard-panel">
            <div class="dashboard-panel-head">
                <div>
                    <h2>Recent Orders</h2>
                    <p class="muted">Latest order activity with status and totals at a glance.</p>
                </div>
            </div>

            <?php if($recentOrders->isEmpty()): ?>
                <p class="muted">No orders yet. Start from the Orders page.</p>
            <?php else: ?>
                <div class="dashboard-list">
                    <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="dashboard-row">
                            <div class="dashboard-main">
                                <strong><?php echo e($order->order_number); ?></strong>
                                <p class="product-copy"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></p>
                                <div class="dashboard-details">
                                    <div class="dashboard-detail">
                                        <span class="product-label">Type</span>
                                        <span class="product-value"><?php echo e(strtoupper($order->order_type)); ?></span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Status</span>
                                        <span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span>
                                    </div>
                                    <div class="dashboard-detail">
                                        <span class="product-label">Total</span>
                                        <span class="product-value">Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="dashboard-action">
                                <a class="dashboard-link" href="<?php echo e(route('orders.show', $order)); ?>">Open order</a>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <div class="dashboard-panel-head">
            <div>
                <h2>Upcoming Production Snapshot</h2>
                <p class="muted">Top items queued in active pre-orders. Use the full report for date-based production planning.</p>
            </div>
            <div class="actions">
                <a class="button-inline button-secondary" href="<?php echo e(route('production-reports.index')); ?>">Open Production Report</a>
            </div>
        </div>

        <?php if($upcomingPrep->isEmpty()): ?>
            <p class="muted">No active pre-orders are currently waiting for production.</p>
        <?php else: ?>
            <div class="report-list" style="margin-top: 1rem;">
                <?php $__currentLoopData = $upcomingPrep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="report-row">
                        <div class="product-main">
                            <strong><?php echo e($prep['product']); ?></strong>
                            <p class="product-copy">Upcoming preorder demand</p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Quantity</span>
                            <span class="product-value"><?php echo e($prep['quantity']); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Workflow</span>
                            <span class="badge">PREP</span>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/dashboard/index.blade.php ENDPATH**/ ?>