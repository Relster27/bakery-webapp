<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <h1>Add Product</h1>
            <p class="muted">A product is one menu item. Inventory for that product is created at the same time.</p>
        </div>

        <form action="<?php echo e(route('products.store')); ?>" method="POST" enctype="multipart/form-data" class="stack">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                <div>
                    <label for="name">Product Name</label>
                    <input id="name" name="name" type="text" value="<?php echo e(old('name')); ?>" required>
                </div>

                <div>
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="Bread" <?php if(old('category', 'Bread') == 'Bread'): echo 'selected'; endif; ?>>Bread</option>
                        <option value="Cake" <?php if(old('category') == 'Cake'): echo 'selected'; endif; ?>>Cake</option>
                        <option value="Pastry" <?php if(old('category') == 'Pastry'): echo 'selected'; endif; ?>>Pastry</option>
                    </select>
                </div>

                <div>
                    <label for="price">Price</label>
                    <input id="price" name="price" type="number" min="0" step="0.01" value="<?php echo e(old('price')); ?>" required>
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label for="quantity_on_hand">Opening Stock</label>
                    <input id="quantity_on_hand" name="quantity_on_hand" type="number" min="0" value="<?php echo e(old('quantity_on_hand', 0)); ?>" required>
                </div>

                <div>
                    <label for="reorder_level">Reorder Level</label>
                    <input id="reorder_level" name="reorder_level" type="number" min="0" value="<?php echo e(old('reorder_level', 5)); ?>" required>
                </div>
                
                <div>
                    <label for="image">Product Image</label>
                    <input id="image" name="image" type="file" accept="image/png, image/jpeg, image/jpg, image/webp" style="background: var(--paper); padding: 0.6rem; width: 100%;">
                </div>
            </div>

            <div>
                <label for="description">Description</label>
                <textarea id="description" name="description"><?php echo e(old('description')); ?></textarea>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Save Product</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('products.index')); ?>">Back</a>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\final\bakery-webapp\resources\views/products/create.blade.php ENDPATH**/ ?>