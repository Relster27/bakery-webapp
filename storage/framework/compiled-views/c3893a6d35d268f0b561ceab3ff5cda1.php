<?php $__env->startSection('content'); ?>
    <section class="card stack">
        <div>
            <span class="eyebrow" style="color: var(--text);">New Sale</span>
            <h1>Create Order</h1>
            <p class="muted">Use this single form for both counter sales and pre-orders. Put quantities only on the products being ordered.</p>
        </div>

        <form action="<?php echo e(route('orders.store')); ?>" method="POST" class="stack">
            <?php echo csrf_field(); ?>

            <div class="form-grid">
                <div>
                    <label for="order_type">Order Type</label>
                    <select id="order_type" name="order_type" required>
                        <option value="counter" <?php if(old('order_type') === 'counter'): echo 'selected'; endif; ?>>Counter Sale</option>
                        <option value="preorder" <?php if(old('order_type', 'preorder') === 'preorder'): echo 'selected'; endif; ?>>Pre-order</option>
                    </select>
                </div>

                <div>
                    <label for="customer_id">Existing Customer</label>
                    <select id="customer_id" name="customer_id">
                        <option value="">Choose later or leave empty</option>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($customer->id); ?>" <?php if((string) old('customer_id') === (string) $customer->id): echo 'selected'; endif; ?>><?php echo e($customer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label for="pickup_time">Pickup Time</label>
                    <input id="pickup_time" name="pickup_time" type="datetime-local" value="<?php echo e(old('pickup_time')); ?>">
                </div>
            </div>

            <div class="form-grid">
                <div>
                    <label for="customer_name">New Customer Name</label>
                    <input id="customer_name" name="customer_name" type="text" value="<?php echo e(old('customer_name')); ?>">
                </div>

                <div>
                    <label for="customer_email">New Customer Email</label>
                    <input id="customer_email" name="customer_email" type="email" value="<?php echo e(old('customer_email')); ?>">
                </div>

                <div>
                    <label for="customer_phone">New Customer Phone</label>
                    <input id="customer_phone" name="customer_phone" type="text" value="<?php echo e(old('customer_phone')); ?>">
                </div>
            </div>

            <div>
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes"><?php echo e(old('notes')); ?></textarea>
            </div>

            <div class="card subcard">
                <h2>Select Products</h2>
                <table>
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Order Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($product->name); ?></td>
                            <td>Rp <?php echo e(number_format((float) $product->price, 0, ',', '.')); ?></td>
                            <td><?php echo e($product->inventory?->quantity_on_hand ?? 0); ?></td>
                            <td>
                                <input
                                    name="quantities[<?php echo e($product->id); ?>]"
                                    type="number"
                                    min="0"
                                    max="<?php echo e($product->inventory?->quantity_on_hand ?? 0); ?>"
                                    value="<?php echo e(old('quantities.'.$product->id, 0)); ?>"
                                >
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="actions">
                <button class="button-inline" type="submit">Create Order</button>
                <a class="button-inline button-secondary" href="<?php echo e(route('orders.index')); ?>">Back</a>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/orders/create.blade.php ENDPATH**/ ?>