<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bakery Management System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

        :root {
            --bg: #f5efe6;
            --surface: rgba(255, 252, 247, 0.96);
            --surface-soft: rgba(255, 249, 242, 0.82);
            --line: rgba(91, 67, 49, 0.12);
            --ink: #2e241e;
            --muted: #6c6158;
            --accent: #b66a3b;
            --accent-dark: #8d4d2c;
            --accent-soft: #f3dfcf;
            --success: #556646;
            --shadow: 0 18px 40px rgba(69, 44, 26, 0.08);
            --shadow-lg: 0 28px 70px rgba(69, 44, 26, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(207, 153, 101, 0.16), transparent 22%),
                radial-gradient(circle at 85% 12%, rgba(170, 118, 76, 0.10), transparent 18%),
                linear-gradient(180deg, #f9f4ee 0%, #f5efe6 48%, #f1e7db 100%);
            color: var(--ink);
            font-family: "Manrope", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.55;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .page {
            width: min(1160px, calc(100vw - 40px));
            margin: 0 auto;
        }

        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 0;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #4a392e;
        }

        .brand-dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #d48f5a, #9a5830);
            box-shadow: 0 0 0 8px rgba(182, 106, 59, 0.14);
        }

        .header-actions,
        .hero-actions,
        .cta-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 46px;
            padding: 0 20px;
            border-radius: 999px;
            border: 1px solid transparent;
            font-weight: 600;
            transition: 160ms ease;
        }

        .button-primary {
            background: var(--accent);
            color: #fff8f2;
            box-shadow: 0 14px 26px rgba(182, 106, 59, 0.22);
        }

        .button-primary:hover {
            background: var(--accent-dark);
        }

        .button-secondary {
            background: rgba(255, 252, 247, 0.82);
            border-color: var(--line);
            color: var(--ink);
        }

        .button-secondary:hover {
            background: #fffaf4;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
            gap: 36px;
            align-items: center;
            padding: 24px 0 34px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 250, 245, 0.88);
            border: 1px solid var(--line);
            color: #7a573f;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.10em;
            text-transform: uppercase;
        }

        .eyebrow::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--accent);
        }

        h1,
        h2 {
            margin: 0;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: -0.045em;
            line-height: 1.02;
        }

        .hero h1 {
            margin-top: 18px;
            max-width: 10ch;
            font-size: clamp(3rem, 5vw, 4.9rem);
            font-weight: 800;
        }

        .hero-copy p {
            max-width: 58ch;
            margin: 18px 0 0;
            font-size: 1.06rem;
            color: var(--muted);
        }

        .hero-actions {
            margin-top: 28px;
        }

        .hero-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 32px;
        }

        .hero-strip-item {
            padding: 16px 18px;
            border-radius: 18px;
            background: rgba(255, 250, 244, 0.78);
            border: 1px solid var(--line);
        }

        .hero-strip-item strong {
            display: block;
            margin-bottom: 6px;
            font-size: 0.96rem;
        }

        .hero-strip-item span {
            display: block;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .hero-panel {
            padding: 22px;
            border-radius: 30px;
            background: linear-gradient(180deg, rgba(255, 252, 247, 0.96), rgba(247, 238, 229, 0.98));
            border: 1px solid rgba(103, 73, 53, 0.12);
            box-shadow: var(--shadow-lg);
        }

        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 18px;
        }

        .panel-title {
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
            color: #7c5f49;
        }

        .panel-badge {
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(85, 102, 70, 0.12);
            color: var(--success);
            font-size: 0.74rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-transform: uppercase;
        }

        .panel-window {
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(103, 73, 53, 0.10);
            background: #fffdfa;
        }

        .panel-window-top {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(103, 73, 53, 0.08);
            background: rgba(248, 241, 233, 0.9);
        }

        .panel-window-top span {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #d6b79f;
        }

        .panel-body {
            padding: 18px;
            display: grid;
            gap: 14px;
        }

        .panel-summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .summary-box {
            padding: 14px;
            border-radius: 16px;
            background: var(--surface-soft);
            border: 1px solid rgba(103, 73, 53, 0.08);
        }

        .summary-box small {
            display: block;
            color: #8a7464;
            font-size: 0.74rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .summary-box strong {
            display: block;
            margin-top: 7px;
            font-size: 1.1rem;
        }

        .panel-list {
            display: grid;
            gap: 10px;
        }

        .panel-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(255, 251, 246, 0.9);
            border: 1px solid rgba(103, 73, 53, 0.08);
        }

        .panel-row strong {
            display: block;
            font-size: 0.98rem;
        }

        .panel-row span {
            display: block;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .panel-pill {
            padding: 7px 11px;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent-dark);
            font-size: 0.76rem;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            padding: 18px 0 8px;
        }

        .stat-card {
            padding: 20px 22px;
            border-radius: 22px;
            background: var(--surface);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .stat-card strong {
            display: block;
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-size: 2rem;
            font-weight: 800;
        }

        .stat-card span {
            display: block;
            margin-top: 8px;
            color: var(--muted);
        }

        .section {
            padding: 54px 0 0;
        }

        .section-head {
            max-width: 720px;
            margin-bottom: 24px;
        }

        .section-head h2 {
            margin-top: 14px;
            font-size: clamp(2rem, 3vw, 3.2rem);
        }

        .section-head p {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 1rem;
        }

        .module-grid,
        .challenge-grid,
        .audience-grid {
            display: grid;
            gap: 18px;
        }

        .module-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .challenge-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .audience-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .card {
            padding: 24px;
            border-radius: 24px;
            background: var(--surface);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .module-label {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            margin-bottom: 16px;
            border-radius: 14px;
            background: var(--accent-soft);
            color: var(--accent-dark);
            font-family: "Plus Jakarta Sans", "Manrope", sans-serif;
            font-weight: 700;
        }

        .card h3 {
            margin: 0;
            font-size: 1.14rem;
        }

        .card p {
            margin: 10px 0 0;
            color: var(--muted);
        }

        .challenge-card {
            padding-bottom: 18px;
        }

        .challenge-card ul,
        .audience-card ul {
            list-style: none;
            margin: 16px 0 0;
            padding: 0;
            display: grid;
            gap: 10px;
        }

        .challenge-card li,
        .audience-card li {
            color: var(--muted);
            padding-left: 18px;
            position: relative;
        }

        .challenge-card li::before,
        .audience-card li::before {
            content: "";
            position: absolute;
            top: 10px;
            left: 0;
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--accent);
        }

        .cta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            margin: 56px 0 60px;
            padding: 28px 30px;
            border-radius: 28px;
            background: linear-gradient(135deg, #503729, #6b4932 58%, #8a5b3f);
            color: #fff7ef;
            box-shadow: var(--shadow-lg);
        }

        .cta h2 {
            font-size: clamp(1.9rem, 2.9vw, 2.7rem);
            max-width: 14ch;
        }

        .cta p {
            margin: 12px 0 0;
            max-width: 56ch;
            color: rgba(255, 246, 237, 0.78);
        }

        .cta .button-secondary {
            background: rgba(255, 251, 246, 0.10);
            border-color: rgba(255, 244, 232, 0.18);
            color: #fff7ef;
        }

        @media (max-width: 1024px) {
            .hero,
            .module-grid,
            .challenge-grid,
            .audience-grid,
            .stats,
            .hero-strip {
                grid-template-columns: 1fr;
            }

            .cta {
                flex-direction: column;
                align-items: flex-start;
            }

            .cta h2 {
                max-width: none;
            }
        }

        @media (max-width: 720px) {
            .page {
                width: min(100vw - 24px, 1160px);
            }

            .site-header {
                padding: 18px 0;
            }

            .hero {
                gap: 24px;
                padding-top: 16px;
            }

            .hero h1 {
                max-width: none;
                font-size: 2.7rem;
            }

            .header-actions,
            .hero-actions,
            .cta-actions {
                width: 100%;
            }

            .button {
                width: 100%;
            }

            .panel-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <header class="site-header">
            <a class="brand" href="<?php echo e(route('landing')); ?>">
                <span class="brand-dot"></span>
                <span>Bakery Management System</span>
            </a>

            <div class="header-actions">
                <a class="button button-secondary" href="<?php echo e(route('login')); ?>">Login</a>
                <a class="button button-primary" href="<?php echo e(route('register')); ?>">Register</a>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="hero-copy">
                    <span class="eyebrow">Bakery software landing page</span>
                    <h1>Bakery operations, ordering, and reporting in one place.</h1>
                    <p>
                        This project packages the bakery's daily work into one Laravel MVC system: owner login, menu management,
                        inventory updates, counter sales, pre-orders, custom cake requests, discount windows, and revenue visibility.
                    </p>

                    <div class="hero-actions">
                        <a class="button button-primary" href="<?php echo e(route('register')); ?>">Create owner account</a>
                        <a class="button button-secondary" href="<?php echo e(route('login')); ?>">Open login</a>
                    </div>

                    <div class="hero-strip">
                        <div class="hero-strip-item">
                            <strong>Clearer workflow</strong>
                            <span>Menu, stock, orders, and reports stay connected.</span>
                        </div>
                        <div class="hero-strip-item">
                            <strong>Bakery-specific</strong>
                            <span>Built around pre-orders, low stock, and cake requests.</span>
                        </div>
                        <div class="hero-strip-item">
                            <strong>Presentation-ready</strong>
                            <span>Clean enough to show as the project front door.</span>
                        </div>
                    </div>
                </div>

                <aside class="hero-panel">
                    <div class="panel-head">
                        <div class="panel-title">Platform Snapshot</div>
                        <div class="panel-badge">Owner view</div>
                    </div>

                    <div class="panel-window">
                        <div class="panel-window-top">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <div class="panel-body">
                            <div class="panel-summary">
                                <div class="summary-box">
                                    <small>Products</small>
                                    <strong>Menu + pricing</strong>
                                </div>
                                <div class="summary-box">
                                    <small>Orders</small>
                                    <strong>Counter + preorder</strong>
                                </div>
                                <div class="summary-box">
                                    <small>Inventory</small>
                                    <strong>Real-time stock</strong>
                                </div>
                            </div>

                            <div class="panel-list">
                                <div class="panel-row">
                                    <div>
                                        <strong>Timed discount rules</strong>
                                        <span>Customer totals adjust automatically during active windows.</span>
                                    </div>
                                    <div class="panel-pill">Pricing</div>
                                </div>
                                <div class="panel-row">
                                    <div>
                                        <strong>Order status handling</strong>
                                        <span>Pending, ready, completed, or expired with inventory sync.</span>
                                    </div>
                                    <div class="panel-pill">Orders</div>
                                </div>
                                <div class="panel-row">
                                    <div>
                                        <strong>Analytics and production</strong>
                                        <span>Revenue tracking and preparation reports are grouped together.</span>
                                    </div>
                                    <div class="panel-pill">Reports</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="stats">
                <article class="stat-card">
                    <strong>9+</strong>
                    <span>Main bakery workflows already implemented in the MVP.</span>
                </article>
                <article class="stat-card">
                    <strong>Laravel MVC</strong>
                    <span>Controllers, models, routes, migrations, and Blade views are in place.</span>
                </article>
                <article class="stat-card">
                    <strong>MySQL Ready</strong>
                    <span>Database seeding and migrations run through the current setup.</span>
                </article>
                <article class="stat-card">
                    <strong>Public + Admin</strong>
                    <span>Owner dashboard and customer-facing ordering pages are separated cleanly.</span>
                </article>
            </section>

            <section class="section">
                <div class="section-head">
                    <span class="eyebrow">What's included</span>
                    <h2>The core modules are grouped the way bakery software usually presents them.</h2>
                    <p>
                        This section takes structural cues from bakery software platforms: feature buckets first, details second.
                    </p>
                </div>

                <div class="module-grid">
                    <article class="card">
                        <div class="module-label">01</div>
                        <h3>Orders</h3>
                        <p>Handle walk-in sales, pre-orders, order status updates, expiration, and item-level order records.</p>
                    </article>
                    <article class="card">
                        <div class="module-label">02</div>
                        <h3>Inventory</h3>
                        <p>Monitor stock, keep reorder thresholds visible, and sync deductions or returns with order events.</p>
                    </article>
                    <article class="card">
                        <div class="module-label">03</div>
                        <h3>Pricing</h3>
                        <p>Maintain product pricing and apply time-based discount rules without changing product master data manually.</p>
                    </article>
                    <article class="card">
                        <div class="module-label">04</div>
                        <h3>Reporting</h3>
                        <p>View revenue transparency, analytics summaries, and production-oriented reports from the same app.</p>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="section-head">
                    <span class="eyebrow">Challenges solved</span>
                    <h2>Focused on practical bakery problems instead of generic admin screens.</h2>
                    <p>
                        The structure here follows the same pattern strong software landing pages use: identify business pain points,
                        then show how the platform resolves them.
                    </p>
                </div>

                <div class="challenge-grid">
                    <article class="card challenge-card">
                        <h3>Reduce order confusion</h3>
                        <p>Counter orders and pickup pre-orders flow through the same system instead of separate notes or chats.</p>
                        <ul>
                            <li>Status transitions are recorded clearly.</li>
                            <li>Customer records can be reused on later orders.</li>
                            <li>Order totals stay tied to the selected items.</li>
                        </ul>
                    </article>
                    <article class="card challenge-card">
                        <h3>Keep stock visible</h3>
                        <p>Product visibility and inventory are treated as operational data, not something checked manually after the fact.</p>
                        <ul>
                            <li>Stock deducts during successful order placement.</li>
                            <li>Expired no-show orders can return stock automatically.</li>
                            <li>Low-stock watch keeps attention on refill points.</li>
                        </ul>
                    </article>
                    <article class="card challenge-card">
                        <h3>Show real business numbers</h3>
                        <p>Revenue and fee logic are exposed more clearly so the owner is not blind to what each order actually contributes.</p>
                        <ul>
                            <li>Discount totals are reflected in the order flow.</li>
                            <li>Analytics and export pages give a reporting path.</li>
                            <li>Production reporting supports daily preparation planning.</li>
                        </ul>
                    </article>
                </div>
            </section>

            <section class="section">
                <div class="section-head">
                    <span class="eyebrow">Two experiences</span>
                    <h2>One side for internal control, one side for customer convenience.</h2>
                    <p>
                        This is the cleaner story to tell in a presentation: the same project serves two audiences without mixing them together.
                    </p>
                </div>

                <div class="audience-grid">
                    <article class="card audience-card">
                        <h3>For the bakery owner</h3>
                        <p>Internal pages focus on control, updates, and business oversight.</p>
                        <ul>
                            <li>Manage products, categories, prices, and stock.</li>
                            <li>Create orders and update their progress.</li>
                            <li>Track customers, discount rules, and reports.</li>
                            <li>Review dashboard summaries from one place.</li>
                        </ul>
                    </article>
                    <article class="card audience-card">
                        <h3>For the customer</h3>
                        <p>Public pages stay much simpler and only expose what customers need to complete an order.</p>
                        <ul>
                            <li>Browse the menu from a public bakery link.</li>
                            <li>Place a pickup order without entering the admin area.</li>
                            <li>See active discount-adjusted totals when applicable.</li>
                            <li>Send custom cake requests through a guided form.</li>
                        </ul>
                    </article>
                </div>
            </section>

            <section class="cta">
                <div>
                    <span class="eyebrow" style="background: rgba(255, 250, 245, 0.12); border-color: rgba(255, 245, 236, 0.18); color: #fff2e7;">Separate route</span>
                    <h2>Keep the real app entry on login, and use this as the polished landing page.</h2>
                    <p>
                        This route exists only as the public-facing showcase. It does not replace your current root path or authentication flow.
                    </p>
                </div>

                <div class="cta-actions">
                    <a class="button button-secondary" href="<?php echo e(route('login')); ?>">Go to login</a>
                    <a class="button button-primary" href="<?php echo e(route('register')); ?>">Go to register</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
<?php /**PATH D:\SE\bakery-webapp\resources\views/landing-showcase.blade.php ENDPATH**/ ?>