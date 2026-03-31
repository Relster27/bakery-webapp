<?php $__env->startSection('content'); ?>
    <section class="hero">
        <h1>Inventory</h1>
        <p class="muted">This page manages stock quantities and reorder levels for each product.</p>
    </section>

    <section class="card">
        <?php if($inventories->isEmpty()): ?>
            <p class="muted">Inventory will appear after you create products.</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Current Stock</th>
                    <th>Reorder Level</th>
                    <th>Update</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <strong><?php echo e($inventory->product?->name); ?></strong><br>
                            <span class="muted"><?php echo e($inventory->product?->category); ?></span>
                        </td>
                        <td><?php echo e($inventory->quantity_on_hand); ?></td>
                        <td><?php echo e($inventory->reorder_level); ?></td>
                        <td>
                            <form action="<?php echo e(route('inventories.update', $inventory)); ?>" method="POST" class="form-grid">
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
                                <div style="align-self: end;">
                                    <button class="button-inline" type="submit">Save</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/inventories/index.blade.php ENDPATH**/ ?>