<?php $__env->startSection('content'); ?>
    <section class="landing-hero">
        <div class="landing-hero-copy">
            <span class="eyebrow">Bakery Operations Platform</span>
            <h1>One bakery workspace for stock, orders, cashflow, and customer pickup.</h1>
            <p class="muted">
                This project turns a bakery’s daily workflow into one Laravel MVC web app: owner login, menu updates,
                live inventory, pre-orders, flash sale pricing, production planning, and customer-facing order links.
            </p>

            <div class="actions">
                <a class="button-inline" href="<?php echo e(route('register')); ?>">Create Owner Account</a>
                <a class="button-inline button-secondary" href="<?php echo e(route('login')); ?>">Login</a>
            </div>

            <div class="landing-proof">
                <div class="landing-proof-item">
                    <strong>Laravel MVC</strong>
                    <span>Controllers, models, migrations, Blade views</span>
                </div>
                <div class="landing-proof-item">
                    <strong>MySQL Ready</strong>
                    <span>Seeded data, migrations, inventory sync</span>
                </div>
                <div class="landing-proof-item">
                    <strong>Bakery Focused</strong>
                    <span>Counter sales, pre-orders, custom cakes</span>
                </div>
            </div>
        </div>

        <div class="landing-hero-panel">
            <div class="landing-kicker">Current Scope</div>
            <ul class="landing-checklist">
                <li>Owner authentication and bakery profile</li>
                <li>Product, pricing, and inventory management</li>
                <li>Counter sale and preorder flow</li>
                <li>Order status and expiration handling</li>
                <li>Flash sale rules and revenue transparency</li>
                <li>Sales analytics, custom cakes, production report</li>
            </ul>
        </div>
    </section>

    <section class="grid grid-4 landing-metrics">
        <article class="stat landing-stat">
            <small>Order Flow</small>
            <h2>Counter + Preorder</h2>
            <p class="muted">One system for walk-in and scheduled pickup orders.</p>
        </article>
        <article class="stat landing-stat">
            <small>Inventory Logic</small>
            <h2>Real-time Sync</h2>
            <p class="muted">Stock is reduced on order placement and restored on expiration.</p>
        </article>
        <article class="stat landing-stat">
            <small>Pricing Logic</small>
            <h2>Timed Discounts</h2>
            <p class="muted">Flash sale rules update customer-facing prices automatically.</p>
        </article>
        <article class="stat landing-stat">
            <small>Reporting</small>
            <h2>Analytics + Prep</h2>
            <p class="muted">Owner can review sales trends and production needs in one place.</p>
        </article>
    </section>

    <section class="grid grid-2 landing-section">
        <article class="card landing-card">
            <div class="landing-card-head">
                <span class="eyebrow landing-eyebrow">What Owners Handle</span>
                <h2>Internal bakery control panel</h2>
            </div>

            <div class="landing-feature-list">
                <div class="landing-feature">
                    <strong>Products and Pricing</strong>
                    <p class="muted">Add, edit, categorize, and activate menu items without touching the database directly.</p>
                </div>
                <div class="landing-feature">
                    <strong>Order Processing</strong>
                    <p class="muted">Create rapid counter sales or manage pre-orders with status transitions from pending to completed.</p>
                </div>
                <div class="landing-feature">
                    <strong>Inventory and Recovery</strong>
                    <p class="muted">Watch reorder levels, track stock deductions, and return stock when no-show orders expire.</p>
                </div>
            </div>
        </article>

        <article class="card landing-card">
            <div class="landing-card-head">
                <span class="eyebrow landing-eyebrow">What Customers See</span>
                <h2>Simple public ordering experience</h2>
            </div>

            <div class="landing-feature-list">
                <div class="landing-feature">
                    <strong>Public Menu Link</strong>
                    <p class="muted">Customers can browse active products, see stock visibility, and submit pickup pre-orders.</p>
                </div>
                <div class="landing-feature">
                    <strong>Custom Cake Request</strong>
                    <p class="muted">A guided form collects event details, flavors, decorations, and pickup date step by step.</p>
                </div>
                <div class="landing-feature">
                    <strong>Transparent Pricing</strong>
                    <p class="muted">Active discount windows are reflected directly in the menu and order totals.</p>
                </div>
            </div>
        </article>
    </section>

    <section class="card landing-flow">
        <div class="landing-card-head">
            <span class="eyebrow landing-eyebrow">Workflow Snapshot</span>
            <h2>How the system moves through a bakery day</h2>
        </div>

        <div class="landing-steps">
            <article class="landing-step">
                <span>01</span>
                <strong>Owner sets products and stock</strong>
                <p class="muted">Menu items, categories, prices, and reorder levels are configured from the dashboard.</p>
            </article>
            <article class="landing-step">
                <span>02</span>
                <strong>Orders come from counter or public link</strong>
                <p class="muted">The app supports both fast in-store orders and scheduled pickup pre-orders.</p>
            </article>
            <article class="landing-step">
                <span>03</span>
                <strong>Inventory and finance update automatically</strong>
                <p class="muted">Totals, discounts, fees, and stock movement are calculated during the transaction flow.</p>
            </article>
            <article class="landing-step">
                <span>04</span>
                <strong>Owner reviews analytics and production</strong>
                <p class="muted">Sales patterns, custom cake requests, and next-day prep needs are visible in reporting pages.</p>
            </article>
        </div>
    </section>

    <section class="landing-cta">
        <div>
            <span class="eyebrow">Presentation View</span>
            <h2>Use this page as the polished front door, while keeping login as the actual app entry.</h2>
        </div>
        <div class="actions">
            <a class="button-inline" href="<?php echo e(route('login')); ?>">Open Login</a>
            <a class="button-inline button-secondary" href="<?php echo e(route('register')); ?>">Open Register</a>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\SE\bakery-webapp\resources\views/landing.blade.php ENDPATH**/ ?>