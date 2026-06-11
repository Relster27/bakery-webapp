<?php $__env->startSection('content'); ?>
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="eyebrow">Custom Cake</span>
                <h1>Design a Cake for <?php echo e($bakery->shop_name); ?></h1>
                <p class="muted">Follow the guided steps below instead of explaining the whole request over the phone.</p>
            </div>

            <div class="hero-aside">
                <span class="eyebrow">How It Works</span>
                <p>Fill your event details, choose the flavor structure, then add any writing or decoration notes.</p>
                <p class="muted">The bakery will review the request and use it for production planning.</p>
            </div>
        </div>
    </section>

    <section class="card stack">
        <div class="actions">
            <a class="button-inline button-secondary" href="<?php echo e(route('menu.show', $bakery->public_slug)); ?>">Back to Public Menu</a>
        </div>

        <form action="<?php echo e(route('menu.custom-cake.store', $bakery->public_slug)); ?>" method="POST" class="stack">
            <?php echo csrf_field(); ?>

            <div class="step-card stack">
                <div>
                    <h3>Step 1. Contact & Pickup</h3>
                    <p class="inline-note">Tell the bakery who you are and when the cake is needed.</p>
                </div>

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

                    <div>
                        <label for="pickup_date">Pickup Date</label>
                        <input id="pickup_date" name="pickup_date" type="date" min="<?php echo e(\Carbon\Carbon::tomorrow()->format('Y-m-d')); ?>" value="<?php echo e(old('pickup_date')); ?>" required>
                    </div>

                    <div>
                        <label for="occasion">Occasion</label>
                        <input id="occasion" name="occasion" type="text" value="<?php echo e(old('occasion')); ?>" placeholder="Birthday, anniversary, office event">
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 2. Size & Portions</h3>
                    <p class="inline-note">Pick a size tier that roughly matches the number of servings you need.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="servings">Approximate Servings</label>
                        <input id="servings" name="servings" type="number" min="6" max="200" value="<?php echo e(old('servings', 12)); ?>" required>
                    </div>

                    <div>
                        <label for="size">Cake Size</label>
                        <select id="size" name="size" required>
                            <option value="6-inch" <?php if(old('size') === '6-inch'): echo 'selected'; endif; ?>>6-inch</option>
                            <option value="8-inch" <?php if(old('size', '8-inch') === '8-inch'): echo 'selected'; endif; ?>>8-inch</option>
                            <option value="10-inch" <?php if(old('size') === '10-inch'): echo 'selected'; endif; ?>>10-inch</option>
                            <option value="two-tier" <?php if(old('size') === 'two-tier'): echo 'selected'; endif; ?>>Two-tier</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 3. Build the Flavor</h3>
                    <p class="inline-note">Choose the sponge, filling, and frosting combination.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="sponge">Sponge / Base</label>
                        <select id="sponge" name="sponge" required>
                            <option value="Vanilla" <?php if(old('sponge', 'Vanilla') === 'Vanilla'): echo 'selected'; endif; ?>>Vanilla</option>
                            <option value="Chocolate" <?php if(old('sponge') === 'Chocolate'): echo 'selected'; endif; ?>>Chocolate</option>
                            <option value="Red Velvet" <?php if(old('sponge') === 'Red Velvet'): echo 'selected'; endif; ?>>Red Velvet</option>
                            <option value="Pandan" <?php if(old('sponge') === 'Pandan'): echo 'selected'; endif; ?>>Pandan</option>
                        </select>
                    </div>

                    <div>
                        <label for="filling">Filling</label>
                        <select id="filling" name="filling" required>
                            <option value="Fresh Cream" <?php if(old('filling', 'Fresh Cream') === 'Fresh Cream'): echo 'selected'; endif; ?>>Fresh Cream</option>
                            <option value="Chocolate Ganache" <?php if(old('filling') === 'Chocolate Ganache'): echo 'selected'; endif; ?>>Chocolate Ganache</option>
                            <option value="Strawberry Jam" <?php if(old('filling') === 'Strawberry Jam'): echo 'selected'; endif; ?>>Strawberry Jam</option>
                            <option value="Cream Cheese" <?php if(old('filling') === 'Cream Cheese'): echo 'selected'; endif; ?>>Cream Cheese</option>
                        </select>
                    </div>

                    <div>
                        <label for="frosting">Frosting</label>
                        <select id="frosting" name="frosting" required>
                            <option value="Buttercream" <?php if(old('frosting', 'Buttercream') === 'Buttercream'): echo 'selected'; endif; ?>>Buttercream</option>
                            <option value="Whipped Cream" <?php if(old('frosting') === 'Whipped Cream'): echo 'selected'; endif; ?>>Whipped Cream</option>
                            <option value="Ganache Finish" <?php if(old('frosting') === 'Ganache Finish'): echo 'selected'; endif; ?>>Ganache Finish</option>
                            <option value="Cream Cheese Frosting" <?php if(old('frosting') === 'Cream Cheese Frosting'): echo 'selected'; endif; ?>>Cream Cheese Frosting</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="step-card stack">
                <div>
                    <h3>Step 4. Decoration & Message</h3>
                    <p class="inline-note">Give the bakery the visual direction and any writing that needs to appear on the cake.</p>
                </div>

                <div class="form-grid">
                    <div>
                        <label for="decoration">Decoration Style</label>
                        <select id="decoration" name="decoration" required>
                            <option value="Minimal clean finish" <?php if(old('decoration', 'Minimal clean finish') === 'Minimal clean finish'): echo 'selected'; endif; ?>>Minimal clean finish</option>
                            <option value="Floral decoration" <?php if(old('decoration') === 'Floral decoration'): echo 'selected'; endif; ?>>Floral decoration</option>
                            <option value="Sprinkle party style" <?php if(old('decoration') === 'Sprinkle party style'): echo 'selected'; endif; ?>>Sprinkle party style</option>
                            <option value="Character / themed topper" <?php if(old('decoration') === 'Character / themed topper'): echo 'selected'; endif; ?>>Character / themed topper</option>
                        </select>
                    </div>

                    <div>
                        <label for="inscription">Cake Message</label>
                        <input id="inscription" name="inscription" type="text" value="<?php echo e(old('inscription')); ?>" placeholder="Happy Birthday Mira">
                    </div>
                </div>

                <div>
                    <label for="notes">Extra Notes</label>
                    <textarea id="notes" name="notes" placeholder="Color palette, no nuts, reference idea, delivery note, etc."><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <button class="button" type="submit">Send Custom Cake Request</button>
        </form>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Wilson Tjokro\Downloads\bakery-webapp\resources\views/public/custom-cake.blade.php ENDPATH**/ ?>