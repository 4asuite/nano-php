<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>4AFW — Nano Framework</title>
    <style>
        @import "https://fonts.googleapis.com/css2?family=Sofia+Sans:wght@400;500&display=swap";
        :root {
            --bg:          #e0e0e0;
            --bg-2:        #d8d8d8;
            --bg-3:        #c9c9c9;
            --border:      #aaaaaa;
            --text:        #1a1a1a;
            --text-muted:  #555555;
            --primary:     #333333;
            --code-bg:     #d0d0d0;
            --code-text:   #1a1a1a;
            --ok-color:    #222222;
            --ok-bg:       #c8c8c8;
            --warn-color:  #222222;
            --warn-bg:     #bebebe;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: "Sofia Sans", sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            transition: background 0.2s, color 0.2s;
        }

        .page {
            max-width: 880px;
            margin: 0 auto;
            padding: 3rem 1.5rem 5rem;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 3.5rem;
        }
        .brand {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 0.6rem;
        }
        .headline {
            font-size: clamp(2rem, 5vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            margin-bottom: 0.6rem;
        }
        .tagline {
            color: var(--text-muted);
            font-size: 1rem;
            max-width: 480px;
        }


        /* ── Sections ── */
        .section { margin-bottom: 3rem; }
        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }

        /* ── Status grid ── */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.75rem;
        }
        .status-card {
            background: var(--bg-2);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 0.9rem 1rem;
        }
        .status-card-label {
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 0.3rem;
        }
        .status-card-value {
            font-size: 0.875rem;
            font-weight: 600;
            font-family: monospace;
        }
        .badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.15rem 0.5rem;
            border-radius: 99px;
        }
        .badge-ok   { background: var(--ok-bg);   color: var(--ok-color); }
        .badge-warn { background: var(--warn-bg);  color: var(--warn-color); }

        /* ── Components list ── */
        .components-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.4rem 2rem;
        }
        @media (max-width: 540px) { .components-grid { grid-template-columns: 1fr; } }

        .components-grid ul {
            list-style: disc;
            padding-left: 1.2rem;
        }
        .components-grid li {
            padding: 0.3rem 0;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
        }
        .components-grid li:last-child { border-bottom: none; }
        .comp-name { font-weight: 600; }
        .comp-desc { color: var(--text-muted); font-size: 0.8rem; }

        /* ── Directory tree ── */
        .tree {
            font-family: 'Courier New', monospace;
            font-size: 0.825rem;
            background: var(--code-bg);
            color: var(--code-text);
            border: 1px solid var(--border);
            border-radius: 0.5rem;
            padding: 1.25rem 1.5rem;
            line-height: 1.8;
        }
        .tree-dir  { font-weight: 700; }
        .tree-muted { color: var(--text-muted); }

        /* ── Steps ── */
        .steps { display: flex; flex-direction: column; gap: 1.5rem; }
        .step {
            display: grid;
            grid-template-columns: 2rem 1fr;
            gap: 0 1rem;
            align-items: start;
        }
        .step-num {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--primary);
            border: 1.5px solid var(--primary);
            border-radius: 50%;
            width: 1.6rem;
            height: 1.6rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 0.15rem;
        }
        .step-title {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.4rem;
        }
        pre {
            background: var(--code-bg);
            color: var(--code-text);
            border: 1px solid var(--border);
            border-radius: 0.4rem;
            padding: 0.75rem 1rem;
            font-size: 0.8rem;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            line-height: 1.6;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 4rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .footer a { color: var(--primary); text-decoration: none; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="page">

    <!-- Header -->
    <header class="header">
        <div>
            <div class="brand">Nano PHP</div>
            <h1 class="headline">Environment ready.</h1>
            <p class="tagline">Minimal core. No magic. Just your code.</p>
        </div>
    </header>

    <!-- System status -->
    <section class="section">
        <div class="section-title">System status</div>
        <div class="status-grid">
            <div class="status-card">
                <div class="status-card-label">PHP version</div>
                <div class="status-card-value"><?= e(PHP_VERSION) ?></div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Environment</div>
                <div class="status-card-value">
                    <?php if (defined('APP_ENV')): ?>
                        <span class="badge <?= APP_ENV === 'production' ? 'badge-ok' : 'badge-warn' ?>">
                            <?= e(APP_ENV) ?>
                        </span>
                    <?php else: ?>
                        <span class="badge badge-warn">not set</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Current route</div>
                <div class="status-card-value"><?= e($current_route) ?></div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Controller</div>
                <div class="status-card-value" style="font-size:0.75rem; word-break:break-all;"><?= e($controller) ?></div>
            </div>
            <div class="status-card">
                <div class="status-card-label">HTTPS</div>
                <div class="status-card-value">
                    <span class="badge <?= $is_https ? 'badge-ok' : 'badge-warn' ?>">
                        <?= $is_https ? 'yes' : 'no' ?>
                    </span>
                </div>
            </div>
            <div class="status-card">
                <div class="status-card-label">Session</div>
                <div class="status-card-value">
                    <span class="badge <?= $session_active ? 'badge-ok' : 'badge-warn' ?>">
                        <?= $session_active ? 'active' : 'inactive' ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Framework core -->
    <section class="section">
        <div class="section-title">What's in the core</div>
        <div class="components-grid">
            <ul>
                <li>
                    <span class="comp-name">Router</span><br>
                    <span class="comp-desc">GET/POST, parameterized routes</span>
                </li>
                <li>
                    <span class="comp-name">Controller</span><br>
                    <span class="comp-desc">Base class, view / json / redirect</span>
                </li>
                <li>
                    <span class="comp-name">View + Layout</span><br>
                    <span class="comp-desc">PHP templates, helper <code>e()</code>, multiple layouts</span>
                </li>
                <li>
                    <span class="comp-name">Request</span><br>
                    <span class="comp-desc">Method, path, get / post / input</span>
                </li>
            </ul>
            <ul>
                <li>
                    <span class="comp-name">Response</span><br>
                    <span class="comp-desc">Fluent API, HTML / JSON / redirect, security headers</span>
                </li>
                <li>
                    <span class="comp-name">Session</span><br>
                    <span class="comp-desc">Secure session management, httponly, samesite</span>
                </li>
                <li>
                    <span class="comp-name">CSRF</span><br>
                    <span class="comp-desc">Token with rotation, form helper</span>
                </li>
                <li>
                    <span class="comp-name">EnvLoader</span><br>
                    <span class="comp-desc">Loading <code>.env</code>, constant definition</span>
                </li>
            </ul>
        </div>
    </section>

    <!-- Project structure -->
    <section class="section">
        <div class="section-title">Project structure</div>
        <pre class="tree">
<span class="tree-dir">App/</span>
├── <span class="tree-dir">Config/</span>
│   └── routes.php          <span class="tree-muted"># route definitions</span>
├── <span class="tree-dir">Controllers/</span>
│   └── NanofwController.php
├── <span class="tree-dir">Core/</span>                  <span class="tree-muted"># framework core</span>
│   ├── App.php
│   ├── Controller.php
│   ├── Csrf.php
│   ├── EnvLoader.php
│   ├── HttpException.php
│   ├── Request.php
│   ├── Response.php
│   ├── Router.php
│   ├── Session.php
│   └── View.php
├── <span class="tree-dir">Models/</span>
├── <span class="tree-dir">views/</span>
│   ├── <span class="tree-dir">layouts/</span>
│   │   ├── main.php        <span class="tree-muted"># main layout</span>
│   │   └── blank.php       <span class="tree-muted"># clean passthrough</span>
│   └── <span class="tree-dir">partials/</span>
│       ├── head.php
│       └── meta.php        <span class="tree-muted"># all meta tags (OG, Twitter, SEO, PWA…)</span>
├── bootstrap.php           <span class="tree-muted"># application bootstrap</span>
└── .env                    <span class="tree-muted"># environment config</span>

<span class="tree-dir">public/</span>
├── index.php               <span class="tree-muted"># single entry point</span>
└── .htaccess
        </pre>
    </section>

    <!-- Next steps -->
    <section class="section">
        <div class="section-title">Next steps</div>
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div>
                    <div class="step-title">Add a route in <code>App/Config/routes.php</code></div>
                    <pre>'GET' => [
    '/'        => [HomeController::class, 'index'],
    '/about'   => [HomeController::class, 'about'],
    '/post/(:num:id)' => [BlogController::class, 'show'],
]</pre>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div>
                    <div class="step-title">Create a Controller in <code>App/Controllers/</code></div>
                    <pre>class HomeController extends Controller
{
    public function index(): Response
    {
        return $this->view('home', ['title' => 'Home']);
    }
}</pre>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div>
                    <div class="step-title">Create a View in <code>App/views/home.php</code></div>
                    <pre>&lt;h1&gt;&lt;?= e($title) ?&gt;&lt;/h1&gt;
&lt;p&gt;This is my first view.&lt;/p&gt;</pre>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <span>PHP <?= e(PHP_VERSION) ?></span>
        <a href="https://github.com" target="_blank" rel="noopener">GitHub</a>
    </footer>

</div>


</body>
</html>