<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <h1>Edit Product</h1>
            <p class="muted">Update the product details here. Stock count is managed on the Inventory page.</p>
        </div>

        <form action="<?php echo e(route('products.update', $product)); ?>" method="POST" class="stack">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-grid">
                <div>
                    <label for="name">Product Name</label>
                    <input id="name" name="name" type="text" value="<?php echo e(old('name', $product->name)); ?>" required>
                </div>

                <div>
                    <label for="category">Category</label>
                    <input id="category" name="category" type="text" value="<?php echo e(old('category', $product->category)); ?>" required>
                </div>

                <div>
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="<?php echo e(old('price', $product->price)); ?>" required>
                </div>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo e(old('description', $product->description)); ?></textarea>
            </div>

            <div>
                <label for="is_active">Status</label>
                <select id="is_active" name="is_active" required>
                    <option value="1" <?php if(old('is_active', (int) $product->is_active) == 1): echo 'selected'; endif; ?>>Active</option>
                    <option value="0" <?php if(old('is_active', (int) $product->is_active) == 0): echo 'selected'; endif; ?>>Hidden</option>
                </select>
            </div>

            <p class="muted">Current stock: <?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></p>

            <div class="actions">
                <button class="button-inline" type="submit">Update Product</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('products.index')); ?>">Back</a>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/products/edit.blade.php ENDPATH**/ ?>