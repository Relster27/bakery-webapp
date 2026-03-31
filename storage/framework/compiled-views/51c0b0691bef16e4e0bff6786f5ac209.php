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
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($product->name); ?></strong><br>
                            <span class="muted"><?php echo e($product->description); ?></span>
                        </td>
                        <td><?php echo e($product->category); ?></td>
                        <td>Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></td>
                        <td><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></td>
                        <td>
                            <span class="badge"><?php echo e($product->is_active ? 'ACTIVE' : 'HIDDEN'); ?></span>
                        </td>
                        <td><a href="<?php echo e(route('products.edit', $product)); ?>">Edit</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/products/index.blade.php ENDPATH**/ ?>