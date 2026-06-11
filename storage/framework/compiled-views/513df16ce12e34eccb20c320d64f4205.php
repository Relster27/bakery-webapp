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
            <div style="display: grid; gap: 0.9rem; margin-top: 1rem;">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article style="
                        display: grid;
                        grid-template-columns: auto 1fr;
                        gap: 1rem;
                        align-items: start;
                        padding: 1rem 1.05rem;
                        border-radius: 22px;
                        background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,243,236,0.92));
                        border: 1px solid rgba(176,146,121,0.16);
                    ">
                        
                        <?php if($product->image_path): ?>
                            <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image_path)); ?>"
                                 alt="<?php echo e($product->name); ?>"
                                 style="width: 64px; height: 64px; object-fit: cover; border-radius: 14px; border: 1px solid rgba(176,146,121,0.16); display: block; flex-shrink: 0;">
                        <?php else: ?>
                            <div style="width: 64px; height: 64px; border-radius: 14px; background: rgba(183,103,58,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">🍞</div>
                        <?php endif; ?>

                        
                        <div style="min-width: 0; display: grid; gap: 0.5rem;">
                            <div>
                                <strong style="font-size: 1.04rem; word-break: break-word;"><?php echo e($product->name); ?></strong>
                                <p class="muted" style="margin: 0.1rem 0 0;"><?php echo e($product->category); ?></p>
                            </div>
                            <div style="display: flex; flex-wrap: wrap; gap: 0.75rem 1.25rem; align-items: center;">
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
                            </div>
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
                        <input id="customer_email" name="customer_email" type="email" placeholder="contoh@email.com" value="<?php echo e(old('customer_email')); ?>">
                    </div>

                    <div>
                        <label for="customer_phone">Phone</label>
                        <input id="customer_phone" name="customer_phone" type="text" placeholder="08xx-xxxx-xxxx" value="<?php echo e(old('customer_phone')); ?>" required>
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
                    <div style="display: grid; gap: 0.9rem; margin-top: 1rem;">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <article style="
                                display: grid;
                                grid-template-columns: auto 1fr auto auto;
                                gap: 1rem;
                                align-items: center;
                                padding: 1rem 1.05rem;
                                border-radius: 22px;
                                background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(249,243,236,0.92));
                                border: 1px solid rgba(176,146,121,0.16);
                            ">
                                
                                <?php if($product->image_path): ?>
                                    <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image_path)); ?>"
                                         alt="<?php echo e($product->name); ?>"
                                         style="width: 52px; height: 52px; object-fit: cover; border-radius: 12px; border: 1px solid rgba(176,146,121,0.16); display: block; flex-shrink: 0;">
                                <?php else: ?>
                                    <div style="width: 52px; height: 52px; border-radius: 12px; background: rgba(183,103,58,0.08); display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">🍞</div>
                                <?php endif; ?>

                                
                                <div style="min-width: 0;">
                                    <strong style="word-break: break-word; display: block;"><?php echo e($product->name); ?></strong>
                                    <p class="product-copy" style="margin: 0.1rem 0;"><?php echo e($product->category); ?></p>
                                    <?php if($product->has_active_discount ?? false): ?>
                                        <div class="price-stack">
                                            <span class="price-current">Rp <?php echo e(number_format((float) $product->effective_price, 0, ',', '.')); ?></span>
                                            <span class="price-old">Rp <?php echo e(number_format((float) $product->original_price, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="product-value">Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></span>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="product-meta" style="min-width: 60px;">
                                    <span class="product-label">Available</span>
                                    <span class="product-value"><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></span>
                                </div>

                                
                                <div style="min-width: 90px;">
                                    <label for="public_quantity_<?php echo e($product->id); ?>" class="product-label">Quantity</label>
                                    <input
                                        id="public_quantity_<?php echo e($product->id); ?>"
                                        name="quantities[<?php echo e($product->id); ?>]"
                                        type="number"
                                        min="0"
                                        max="<?php echo e($product->inventory?->quantity_on_hand ?? 0); ?>"
                                        value="<?php echo e(old('quantities.'.$product->id, 0)); ?>"
                                        style="width: 100%;"
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wilson Tjokro\Downloads\bakery-webapp\resources\views/public/menu.blade.php ENDPATH**/ ?>