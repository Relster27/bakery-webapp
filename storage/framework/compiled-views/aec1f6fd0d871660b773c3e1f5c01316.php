<?php $__env->startSection('content'); ?>
    <section class="hero">
        <span class="eyebrow">Stock Control</span>
        <h1>Inventory</h1>
        <p class="muted">This page manages stock quantities and reorder levels for each product.</p>
    </section>

    <section class="card">
        <?php if($inventories->isEmpty()): ?>
            <p class="muted">Inventory will appear after you create products.</p>
        <?php else: ?>
            <div class="inventory-list">
                <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="inventory-row">
                        <div class="product-main">
                            <strong><?php echo e($inventory->product?->name); ?></strong>
                            <p class="product-copy"><?php echo e($inventory->product?->category); ?></p>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Current Stock</span>
                            <span class="product-value"><?php echo e($inventory->quantity_on_hand); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Reorder Level</span>
                            <span class="product-value"><?php echo e($inventory->reorder_level); ?></span>
                        </div>

                        <div>
                            <form action="<?php echo e(route('inventories.update', $inventory)); ?>" method="POST" class="inventory-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div>
                                    <label for="quantity_on_hand_<?php echo e($inventory->id); ?>">Stock</label>
                                    <input id="quantity_on_hand_<?php echo e($inventory->id); ?>" name="quantity_on_hand" type="number" min="0" value="<?php echo e($inventory->quantity_on_hand); ?>" required>
                                </div>
                                <div>
                                    <label for="reorder_level_<?php echo e($inventory->id); ?>">Reorder</label>
                                    <input id="reorder_level_<?php echo e($inventory->id); ?>" name="reorder_level" type="number" min="0" value="<?php echo e($inventory->reorder_level); ?>" required>
                                </div>
                                <div class="inventory-button">
                                    <button class="button-inline" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/inventories/index.blade.php ENDPATH**/ ?>