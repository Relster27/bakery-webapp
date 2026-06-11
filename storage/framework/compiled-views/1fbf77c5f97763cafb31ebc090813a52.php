<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <span class="eyebrow">Menu Management</span>
                <h1>Products</h1>
                <p class="muted">Manage bakery menu items and selling prices here.</p>
            </div>
            <a class="button-inline" href="<?php echo e(route('products.create')); ?>">Add Product</a>
        </div>
    </section>

    <section class="card">
        <?php if($products->isEmpty()): ?>
            <p class="muted">No products yet. Start by adding the first menu item.</p>
        <?php else: ?>
            <div class="product-list">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="product-row">
                        <div class="product-main" style="display: flex; gap: 1rem; align-items: center;">
                            <?php if($product->image_path): ?>
                                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($product->image_path)); ?>" alt="<?php echo e($product->name); ?>" style="width: 48px; height: 48px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(176, 146, 121, 0.16); flex-shrink: 0;">
                            <?php endif; ?>
                            <div>
                                <strong><?php echo e($product->name); ?></strong>
                                <p class="product-copy"><?php echo e($product->description ?: 'No product description yet.'); ?></p>
                            </div>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Category</span>
                            <span class="product-value"><?php echo e($product->category); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Price</span>
                            <span class="product-value">Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></span>
                        </div>

                        <div class="product-meta">
                            <span class="product-label">Stock</span>
                            <span class="product-value"><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></span>
                        </div>

                        <div class="product-actions">
                            <div class="stack-tight" style="justify-items: end;">
                                <span class="badge <?php echo e($product->is_active ? '' : 'badge-muted'); ?>"><?php echo e($product->is_active ? 'ACTIVE' : 'HIDDEN'); ?></span>
                                <a href="<?php echo e(route('products.edit', $product)); ?>">Edit product</a>
                                <form
                                    action="<?php echo e(route('products.destroy', $product)); ?>"
                                    method="POST"
                                    onsubmit="return confirm('Delete <?php echo e(addslashes($product->name)); ?>? This action cannot be undone. If this product is already used in an order, deletion will be blocked.');"
                                >
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="button-inline button-danger" type="submit">Delete product</button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\final\bakery-webapp\resources\views/products/index.blade.php ENDPATH**/ ?>