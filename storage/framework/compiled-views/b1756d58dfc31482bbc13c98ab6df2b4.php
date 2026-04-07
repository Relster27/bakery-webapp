<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">Daily Prep</span>
            <h1>Production Reports</h1>
            <p class="muted">See what must be prepared for a selected pickup date, including pre-order items and custom cake requests.</p>
        </div>

        <form action="<?php echo e(route('production-reports.index')); ?>" method="GET" class="filter-bar">
            <div>
                <label for="date">Pickup Date</label>
                <input id="date" name="date" type="date" value="<?php echo e($date); ?>">
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Build Report</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('production-reports.export', ['date' => $date])); ?>">Export CSV</a>
            </div>
        </form>
    </section>

    <section class="grid grid-2" style="margin-top: 1rem;">
        <div class="card stack">
            <div>
                <h2>Bakery Product Prep</h2>
                <p class="muted">Aggregated quantities from pre-orders scheduled for this date.</p>
            </div>

            <?php if($productPrep->isEmpty()): ?>
                <p class="muted">No preorder production items are scheduled for this date.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $productPrep; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row">
                            <div class="product-main">
                                <strong><?php echo e($row['product']); ?></strong>
                                <p class="product-copy">Prepare for pickup day</p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Quantity</span>
                                <span class="product-value"><?php echo e($row['quantity']); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Source</span>
                                <span class="badge">PREORDER</span>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card stack">
            <div>
                <h2>Custom Cake Queue</h2>
                <p class="muted">Guided cake requests waiting for review or production planning.</p>
            </div>

            <?php if($customCakes->isEmpty()): ?>
                <p class="muted">No custom cake requests scheduled for this date.</p>
            <?php else: ?>
                <div class="report-list">
                    <?php $__currentLoopData = $customCakes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <article class="report-row-wide">
                            <div class="product-main">
                                <strong><?php echo e($cake->customer_name); ?></strong>
                                <p class="product-copy"><?php echo e($cake->occasion ?: 'Custom cake request'); ?></p>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Flavor</span>
                                <span class="product-value"><?php echo e($cake->sponge); ?> / <?php echo e($cake->filling); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Finish</span>
                                <span class="product-value"><?php echo e($cake->frosting); ?> / <?php echo e($cake->decoration); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Servings</span>
                                <span class="product-value"><?php echo e($cake->servings); ?></span>
                            </div>

                            <div class="product-meta">
                                <span class="product-label">Status</span>
                                <span class="badge"><?php echo e(strtoupper($cake->status)); ?></span>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="card" style="margin-top: 1rem;">
        <h2>Scheduled Pre-orders</h2>
        <?php if($orders->isEmpty()): ?>
            <p class="muted">No pre-orders are queued for this date.</p>
        <?php else: ?>
            <div class="order-list">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="order-row">
                        <div class="product-main">
                            <strong><?php echo e($order->order_number); ?></strong>
                            <p class="product-copy"><?php echo e($order->customer?->name ?? 'Walk-in customer'); ?></p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Pickup</span>
                            <span class="product-value"><?php echo e($order->pickup_time?->format('H:i') ?? '-'); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge"><?php echo e(strtoupper($order->order_status)); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Items</span>
                            <span class="product-value"><?php echo e($order->items->sum('quantity')); ?></span>
                        </div>

                        <div class="row-actions">
                            <a href="<?php echo e(route('orders.show', $order)); ?>">Open order</a>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/production-reports/index.blade.php ENDPATH**/ ?>