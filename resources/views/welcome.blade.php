<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#12352d">
    <title>Stockroom — Inventory</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="grain"></div>

<div class="app-shell">

    {{-- ================= SIDEBAR ================= --}}
    <aside class="sidebar">
        <a class="brand" href="{{ route('dashboard') }}">
            <span class="brand-mark">S</span> stockroom
        </a>

        <p class="workspace-label">WORKSPACE</p>
        <a class="workspace" href="#">
            <span class="workspace-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
            My inventory <span class="chevron">⌄</span>
        </a>

        <nav class="side-nav">
            <a class="active" href="#inventory"><span>⊞</span> Inventory</a>
            <a href="#"><span>◫</span> Orders</a>
            <a href="#"><span>♧</span> Suppliers</a>
            <a href="#"><span>◔</span> Reports</a>
        </nav>

        <div class="sidebar-bottom">
            <a href="#"><span>⚙</span> Settings</a>

            <div class="account">
                <span class="account-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div>
                    <strong>{{ auth()->user()->name }}</strong>
                    <small>Administrator</small>
                </div>
            </div>

            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <button class="logout" type="submit">Log out</button>
            </form>
        </div>
    </aside>

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="content" id="inventory">

        <header class="topbar">
            <button class="mobile-menu" type="button">☰</button>
            <div>
                <p class="date">YOUR CATALOGUE</p>
                <h1>Inventory <em>overview.</em></h1>
            </div>
            <div class="top-actions">
                <button class="icon-button" type="button">♢<i></i></button>
                <button class="add-button" id="open-add" type="button">+ Add product</button>
            </div>
        </header>

        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        {{-- ---- Summary cards ---- --}}
        <section class="summary-grid">
            <article class="summary-card total">
                <p>Total products</p>
                <strong>{{ $totalProducts }}</strong>
                <span>{{ $totalProducts ? 'Products in your catalogue' : 'Start building your catalogue' }}</span>
                <div class="card-art boxes-art"><i></i><i></i><i></i></div>
            </article>

            <article class="summary-card value">
                <p>Inventory value</p>
                <strong>₱ {{ number_format((float) $inventoryValue, 2) }}</strong>
                <span>Based on your current stock</span>
                <div class="card-art coin-art">₱</div>
            </article>

            <article class="summary-card alert">
                <p>Need attention</p>
                <strong>{{ $attentionCount }}</strong>
                <span>Low or out of stock</span>
                <a href="#product-list">Review items <b>→</b></a>
            </article>
        </section>

        {{-- ---- Product table ---- --}}
        <section class="table-section" id="low-stock">
            <div class="section-title">
                <div>
                    <p class="eyebrow">CURRENT CATALOGUE</p>
                    <h2>All products <span>{{ $products->total() }} item{{ $products->total() === 1 ? '' : 's' }}</span></h2>
                </div>
                <button class="text-button" id="open-add-bottom" type="button">Add product <span>+</span></button>
            </div>

            <div class="table-tools">
                <label class="search">
                    <span>⌕</span>
                    <input id="product-search" type="search" placeholder="Search current products...">
                </label>
            </div>

            @if($products->isEmpty())
                <div class="empty-state">
                    <span>□</span>
                    <h2>Your inventory is empty.</h2>
                    <p>Add your first product to start tracking stock, prices, and low-stock items.</p>
                    <button class="add-button open-add" type="button">+ Add your first product</button>
                </div>
            @else
                <div class="table-wrap">
                    <table>
                        <thead>
                        <tr>
                            <th>PRODUCT</th>
                            <th>SKU</th>
                            <th>CATEGORY</th>
                            <th>IN STOCK</th>
                            <th>PRICE</th>
                            <th>STATUS</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="product-list">
                        @foreach($products as $product)
                            <tr data-search="{{ strtolower($product->name.' '.$product->sku.' '.$product->category) }}">
                                <td>
                                    <div class="product-cell">
                                        <span class="product-image">{{ strtoupper(substr($product->name, 0, 1)) }}</span>
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <small>{{ $product->variant ?: 'No variant details' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category }}</td>
                                <td><b>{{ $product->stock }}</b> <small>units</small></td>
                                <td>₱ {{ number_format((float) $product->price, 2) }}</td>
                                <td>
                                    @if($product->stock === 0)
                                        <span class="status out-stock">Out of stock</span>
                                    @elseif($product->stock <= 5)
                                        <span class="status low-stock">Low stock</span>
                                    @else
                                        <span class="status in-stock">In stock</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <button class="edit-product" type="button"
                                                data-id="{{ $product->id }}"
                                                data-name="{{ $product->name }}"
                                                data-sku="{{ $product->sku }}"
                                                data-category="{{ $product->category }}"
                                                data-stock="{{ $product->stock }}"
                                                data-price="{{ $product->price }}"
                                                data-variant="{{ $product->variant }}">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}"
                                              onsubmit="return confirm('Delete this product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="delete-product" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>Showing {{ $products->count() }} of {{ $products->total() }} products</span>
                    {{ $products->links() }}
                </div>
            @endif
        </section>

    </main>
</div>

{{-- ================= ADD / EDIT PRODUCT DIALOG ================= --}}
<dialog id="product-dialog">
    <form id="product-form" method="POST" action="{{ route('products.store') }}">
        @csrf
        <input id="method-field" type="hidden" name="_method">

        <button class="dialog-close" type="button" value="cancel">×</button>

        <p class="eyebrow" id="dialog-kicker">NEW CATALOGUE ITEM</p>
        <h2 id="dialog-title">Add a product</h2>

        <label>Product name
            <input id="name" name="name" required value="{{ old('name') }}" placeholder="e.g. Sola table lamp">
        </label>

        <div class="form-row">
            <label>SKU
                <input id="sku" name="sku" required value="{{ old('sku') }}" placeholder="LGT-037">
            </label>
            <label>Starting stock
                <input id="stock" name="stock" type="number" min="0" required value="{{ old('stock', 0) }}">
            </label>
        </div>

        <div class="form-row">
            <label>Category
                <input id="category" name="category" required value="{{ old('category') }}" placeholder="e.g. Lighting">
            </label>
            <label>Price (₱)
                <input id="price" name="price" type="number" min="0" step="0.01" required value="{{ old('price', 0) }}">
            </label>
        </div>

        <label>Variant / details
            <input id="variant" name="variant" value="{{ old('variant') }}" placeholder="Optional">
        </label>

        @if($errors->any())
            <p class="form-error">{{ $errors->first() }}</p>
        @endif

        <button class="add-button" id="dialog-submit" type="submit">Save product</button>
    </form>
</dialog>

{{-- ================= SCRIPT ================= --}}
<script>
    const dialog = document.querySelector('#product-dialog');
    const form = document.querySelector('#product-form');
    const method = document.querySelector('#method-field');

    const openAdd = () => {
        form.reset();
        form.action = '{{ route('products.store') }}';
        method.value = '';
        document.querySelector('#dialog-title').textContent = 'Add a product';
        document.querySelector('#dialog-kicker').textContent = 'NEW CATALOGUE ITEM';
        document.querySelector('#dialog-submit').textContent = 'Save product';
        dialog.showModal();
    };

    document.querySelector('#open-add').onclick = openAdd;
    document.querySelector('#open-add-bottom').onclick = openAdd;
    document.querySelectorAll('.open-add').forEach(b => b.onclick = openAdd);

    document.querySelector('.dialog-close').onclick = () => dialog.close();

    document.querySelectorAll('.edit-product').forEach(button => button.onclick = () => {
        form.action = '{{ url('/products') }}/' + button.dataset.id;
        method.value = 'PUT';

        ['name', 'sku', 'category', 'stock', 'price', 'variant'].forEach(key => {
            document.querySelector('#' + key).value = button.dataset[key] || '';
        });

        document.querySelector('#dialog-title').textContent = 'Edit product';
        document.querySelector('#dialog-kicker').textContent = 'UPDATE CATALOGUE ITEM';
        document.querySelector('#dialog-submit').textContent = 'Save changes';
        dialog.showModal();
    });

    document.querySelector('#product-search').addEventListener('input', e => {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('#product-list tr').forEach(row => {
            row.hidden = !row.dataset.search.includes(term);
        });
    });

    document.querySelector('.mobile-menu').onclick = () => document.querySelector('.sidebar').classList.toggle('open');

    @if($errors->any())
        dialog.showModal();
    @endif
</script>
</body>
</html>