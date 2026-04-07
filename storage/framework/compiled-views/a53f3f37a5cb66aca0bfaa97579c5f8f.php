<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">Revenue Insight</span>
            <h1>Sales Analytics</h1>
            <p class="muted">Review completed sales, fee deductions, best selling hours, and top products for the selected date range.</p>
        </div>

        <form action="<?php echo e(route('analytics.index')); ?>" method="GET" class="filter-bar">
            <div>
                <label for="from">From</label>
                <input id="from" name="from" type="date" value="<?php echo e($from); ?>">
            </div>

            <div>
                <label for="to">To</label>
                <input id="to" name="to" type="date" value="<?php echo e($to); ?>">
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Refresh Analytics</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('analytics.export', ['from' => $from, 'to' => $to])); ?>">Export CSV</a>
            </div>
        </form>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Revenue & Fee Transparency</h2>
        <div class="metric-grid" style="margin-top: 1rem;">
            <div class="metric-card">
                <h3>Completed Orders</h3>
                <strong><?php echo e($summary['completed_orders']); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Gross Before Discount</h3>
                <strong>Rp <?php echo e(number_format((float) $summary['gross_before_discount'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Discounts Given</h3>
                <strong>Rp <?php echo e(number_format((float) $summary['discounts_given'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Customer Paid</h3>
                <strong>Rp <?php echo e(number_format((float) $summary['customer_paid'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Platform Fees</h3>
                <strong>Rp <?php echo e(number_format((float) $summary['platform_fees'], 0, ',', '.')); ?></strong>
            </div>
            <div class="metric-card">
                <h3>Net After Fees</h3>
                <strong>Rp <?php echo e(number_format((float) $summary['net_after_fees'], 0, ',', '.')); ?></strong>
            </div>
        </div>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card stack">
            <div>
                <h2>Best Selling Hours</h2>
                <p class="muted">Use this to spot the strongest selling windows for staffing and bake timing.</p>
            </div>

            <?php if($hourlySales->isEmpty()): ?>
                <p class="muted">No completed orders in this date range yet.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $hourlySales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour => $hourRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row">
                            <div class="product-main">
                                <strong><?php echo e($hour); ?></strong>
                                <p class="product-copy"><?php echo e($hourRow['orders']); ?> completed order(s)</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Sales</span>
                                <span class="product-value">Rp <?php echo e(number_format((float) $hourRow['sales'], 0, ',', '.')); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Net</span>
                                <span class="product-value">Rp <?php echo e(number_format((float) $hourRow['net'], 0, ',', '.')); ?></span>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card stack">
            <div>
                <h2>Top Products</h2>
                <p class="muted">Top products are ranked from completed orders in the selected range.</p>
            </div>

            <?php if($topProducts->isEmpty()): ?>
                <p class="muted">No product movement recorded in this date range yet.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row">
                            <div class="product-main">
                                <strong><?php echo e($product['product']); ?></strong>
                                <p class="product-copy">Completed-order performance</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Quantity</span>
                                <span class="product-value"><?php echo e($product['quantity']); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Sales</span>
                                <span class="product-value">Rp <?php echo e(number_format((float) $product['sales'], 0, ',', '.')); ?></span>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card stack">
            <div>
                <h2>Status Breakdown</h2>
                <p class="muted">Order mix across the full selected range.</p>
            </div>

            <?php if($statusBreakdown->isEmpty()): ?>
                <p class="muted">No orders found in this date range.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $statusBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row">
                            <div class="product-main">
                                <strong><?php echo e(strtoupper($status)); ?></strong>
                                <p class="product-copy">Lifecycle state count</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Orders</span>
                                <span class="product-value"><?php echo e($count); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">View</span>
                                <span class="badge"><?php echo e(strtoupper($status)); ?></span>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card stack">
            <div>
                <h2>Recent Orders in Range</h2>
                <p class="muted">A quick audit-friendly list before exporting the CSV.</p>
            </div>

            <?php if($orders->isEmpty()): ?>
                <p class="muted">No orders found for this date range.</p>
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
                                <span class="product-label">Paid</span>
                                <span class="product-value">Rp <?php echo e(number_format((float) $order->total_amount, 0, ',', '.')); ?></span>
                            </div>

                            <div class="row-actions">
                                <a href="<?php echo e(route('orders.show', $order)); ?>">Open order</a>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/analytics/index.blade.php ENDPATH**/ ?>