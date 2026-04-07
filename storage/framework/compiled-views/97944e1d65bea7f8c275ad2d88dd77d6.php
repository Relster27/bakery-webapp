<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Live Bakery Menu</span>
                <h1><?php echo e($bakery->shop_name); ?></h1>
                <p class="muted">Browse the current menu, check live stock, and place a pickup order without calling the shop.</p>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">Visit</span>
                <?php if($bakery->address): ?>
                    <p><strong>Address:</strong> <?php echo e($bakery->address); ?></p>
                <?php endif; ?>
                <?php if($bakery->phone): ?>
                    <p><strong>Phone:</strong> <?php echo e($bakery->phone); ?></p>
                <?php endif; ?>
                <?php if($bakery->email): ?>
                    <p><strong>Email:</strong> <?php echo e($bakery->email); ?></p>
                <?php endif; ?>
                <p><a href="<?php echo e(route('menu.custom-cake.show', $bakery->public_slug)); ?>">Need a custom cake instead?</a></p>
            </div>
        </div>
    </section>

    <section class="grid grid-2">
        <div class="card">
            <h2>Live Menu</h2>
            <p class="muted">Flash-sale rules apply automatically when their time window is active.</p>
            <div class="product-list" style="margin-top: 1rem;">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="product-row">
                        <div class="product-main">
                            <strong><?php echo e($product->name); ?></strong><br>
                            <span class="muted"><?php echo e($product->category); ?></span>
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Price</span>
                            <?php if($product->has_active_discount ?? false): ?>
                                <div class="price-stack">
                                    <span class="price-current">Rp <?php echo e(number_format((float) $product->effective_price, 0, ',', '.')); ?></span>
                                    <span class="price-old">Rp <?php echo e(number_format((float) $product->original_price, 0, ',', '.')); ?></span>
                                    <span class="discount-note"><?php echo e($product->discount_name); ?></span>
                                </div>
                            <?php else: ?>
                                <span class="product-value">Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Stock</span>
                            <span class="product-value"><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></span>
                        </div>
                        <div class="product-meta">
                            <span class="product-label">Status</span>
                            <span class="badge <?php echo e(($product->inventory?->quantity_on_hand ?? 0) > 0 ? '' : 'badge-muted'); ?>">
                                <?php echo e(($product->inventory?->quantity_on_hand ?? 0) > 0 ? 'AVAILABLE' : 'OUT OF STOCK'); ?>

                            </span>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <div class="card stack">
            <div>
                <h2>Place a Pre-order</h2>
                <p class="muted">Enter customer details, choose pickup time, then fill only the quantities you want.</p>
                <p class="helper-text">Planning a celebration cake? <a href="<?php echo e(route('menu.custom-cake.show', $bakery->public_slug)); ?>">Use the custom cake configurator</a>. <?php echo e($cakeRequestCount); ?> guided request(s) already scheduled.</p>
            </div>

            <form action="<?php echo e(route('menu.order.store', $bakery->public_slug)); ?>" method="POST" class="stack">
                <?php echo csrf_field(); ?>

                <div class="form-grid">
                    <div>
                        <label for="customer_name">Name</label>
                        <input id="customer_name" name="customer_name" type="text" value="<?php echo e(old('customer_name')); ?>" required>
                    </div>

                    <div>
                        <label for="customer_email">Email</label>
                        <input id="customer_email" name="customer_email" type="email" value="<?php echo e(old('customer_email')); ?>">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" value="<?php echo e(old('customer_phone')); ?>" required>
                    </div>
                </div>

                <div>
                    <label for="pickup_time">Pickup Time</label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="<?php echo e(old('pickup_time')); ?>" required>
                </div>

                <div>
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes"><?php echo e(old('notes')); ?></textarea>
                </div>

                <div class="card subcard">
                    <h3>Choose Products</h3>
                    <div class="selector-list">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article class="selector-row">
                                <div class="product-main">
                                    <strong><?php echo e($product->name); ?></strong>
                                    <p class="product-copy"><?php echo e($product->category); ?></p>
                                </div>
                                <div class="product-meta">
                                    <span class="product-label">Price</span>
                                    <?php if($product->has_active_discount ?? false): ?>
                                        <div class="price-stack">
                                            <span class="price-current">Rp <?php echo e(number_format((float) $product->effective_price, 0, ',', '.')); ?></span>
                                            <span class="price-old">Rp <?php echo e(number_format((float) $product->original_price, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="product-value">Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-meta">
                                    <span class="product-label">Available</span>
                                    <span class="product-value"><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></span>
                                </div>
                                <div class="selector-quantity">
                                    <label for="public_quantity_<?php echo e($product->id); ?>">Quantity</label>
                                    <input
                                        id="public_quantity_<?php echo e($product->id); ?>"
                                        name="quantities[<?php echo e($product->id); ?>]"
                                        type="number"
                                        min="0"
                                        max="<?php echo e($product->inventory?->quantity_on_hand ?? 0); ?>"
                                        value="<?php echo e(old('quantities.'.$product->id, 0)); ?>"
                                    >
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <button class="button" type="submit">Send Pre-order</button>
            </form>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/public/menu.blade.php ENDPATH**/ ?>