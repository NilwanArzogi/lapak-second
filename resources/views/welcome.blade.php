<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapak Second - Elektronik Berkualitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 font-sans" x-data="cartSystem()">

    <nav class="bg-purple-700 p-4 shadow-lg sticky top-0 z-50 text-white">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-plug text-yellow-400"></i> Lapak Second
            </a>
            
            <div class="flex gap-6 items-center">
                <button @click="showCart = true" class="relative hover:text-yellow-400 transition">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    <span x-cloak x-show="cart.length > 0" x-text="cart.length" 
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-5 h-5 flex items-center justify-center rounded-full border-2 border-purple-700 animate-bounce"></span>
                </button>
                <i class="fas fa-user-circle text-2xl cursor-pointer"></i>
            </div>
        </div>
    </nav>

    <header class="bg-purple-600 text-white py-12 border-b-4 border-yellow-400">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-black mb-2">Pusat Gadget Murah & Berkualitas</h1>
            <p class="text-purple-100 italic">Temukan Smartphone, Laptop, dan Aksesoris pilihan terbaik.</p>
        </div>
    </header>

    <main class="container mx-auto py-8 px-4">
        <div class="flex flex-col md:flex-row gap-6">
            
            <aside class="w-full md:w-1/4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                        <i class="fas fa-filter text-purple-600"></i> Filter Kategori
                    </h3>
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-4 h-4 accent-purple-600">
                                <span class="text-gray-600 group-hover:text-purple-600">Smartphone</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-4 h-4 accent-purple-600">
                                <span class="text-gray-600 group-hover:text-purple-600">Laptop & PC</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="w-4 h-4 accent-purple-600">
                                <span class="text-gray-600 group-hover:text-purple-600">Aksesoris</span>
                            </label>
                        </div>
                        <button class="w-full py-2 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-800 transition">Terapkan</button>
                    </div>
                </div>
            </aside>

            <div class="w-full md:w-3/4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all border border-gray-100 overflow-hidden flex flex-col">
                        <div class="relative">
                            <img src="{{ $product->gambar }}" alt="{{ $product->nama_barang }}" class="w-full h-48 object-cover">
                            <span class="absolute top-3 left-3 {{ $product->kondisi == 'baru' ? 'bg-green-500' : 'bg-orange-500' }} text-white text-[10px] px-3 py-1 rounded-full font-bold uppercase">
                                {{ $product->kondisi }}
                            </span>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-bold text-gray-800 text-lg mb-1 truncate">{{ $product->nama_barang }}</h3>
                            <p class="text-purple-700 font-black text-xl mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                            <button @click="addToCart({ id: {{ $product->id }}, nama: '{{ $product->nama_barang }}', harga: {{ $product->harga }} })" 
                                    class="w-full py-3 bg-purple-100 text-purple-700 rounded-xl font-bold hover:bg-purple-700 hover:text-white transition duration-300">
                                <i class="fas fa-plus-circle mr-2"></i> Tambah
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center py-20 text-gray-400">Data produk kosong.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <div x-cloak x-show="showCart" class="fixed inset-0 z-[100] flex justify-end">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showCart = false"></div>
        <div class="relative w-full max-w-md bg-white h-full shadow-2xl p-6 flex flex-col overflow-y-auto">
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-black text-purple-700 uppercase underline">Checkout Pesanan</h2>
                <button @click="showCart = false" class="text-3xl text-gray-400 hover:text-red-500">&times;</button>
            </div>

            <div class="space-y-4 mb-8">
                <h3 class="font-bold text-gray-700 border-l-4 border-purple-500 pl-2">Produk Dipilih</h3>
                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl border">
                        <div>
                            <p x-text="item.nama" class="font-bold text-sm text-gray-800"></p>
                            <p x-text="'Rp ' + item.harga.toLocaleString('id-ID')" class="text-purple-600 font-bold text-xs"></p>
                        </div>
                        <button @click="removeFromCart(index)" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition"><i class="fas fa-trash"></i></button>
                    </div>
                </template>
                <p x-show="cart.length === 0" class="text-center text-gray-400 italic py-4">Keranjang kosong.</p>
            </div>

            <div class="space-y-4 mb-8" x-show="cart.length > 0">
                <h3 class="font-bold text-gray-700 border-l-4 border-purple-500 pl-2">Informasi Pembeli</h3>
                <input type="text" x-model="customer.name" placeholder="Nama Lengkap" class="w-full p-3 border rounded-xl outline-none focus:ring-2 focus:ring-purple-400">
                <input type="email" x-model="customer.email" placeholder="Email Aktif" class="w-full p-3 border rounded-xl outline-none focus:ring-2 focus:ring-purple-400">
                <input type="tel" x-model="customer.phone" placeholder="Nomor HP" class="w-full p-3 border rounded-xl outline-none focus:ring-2 focus:ring-purple-400">
            </div>

            <div class="space-y-4 mb-8" x-show="cart.length > 0">
                <h3 class="font-bold text-gray-700 border-l-4 border-purple-500 pl-2">Metode Pembayaran</h3>
                <div class="grid grid-cols-1 gap-2">
                    <template x-for="pay in paymentMethods">
                        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-purple-50" :class="selectedPayment === pay ? 'border-purple-600 bg-purple-50' : ''">
                            <input type="radio" name="payment" :value="pay" x-model="selectedPayment" class="accent-purple-600">
                            <span class="text-sm font-medium text-gray-700" x-text="pay"></span>
                        </label>
                    </template>
                </div>
            </div>

            <div class="mt-auto border-t pt-6 sticky bottom-0 bg-white">
                <div class="flex justify-between items-center font-black text-xl mb-6 text-purple-700">
                    <span class="text-gray-400 text-sm uppercase">Total</span>
                    <span x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                </div>
                <button @click="checkout()" 
                        class="w-full py-4 bg-purple-700 text-white rounded-2xl font-black text-lg hover:bg-purple-800 shadow-xl transition active:scale-95 disabled:bg-gray-300"
                        :disabled="cart.length === 0 || !customer.name || !customer.phone || !selectedPayment">
                    <i class="fas fa-check-double mr-2"></i> KONFIRMASI SEKARANG
                </button>
            </div>
        </div>
    </div>

    <div x-cloak x-show="orderSuccess" class="fixed inset-0 z-[200] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="orderSuccess = false"></div>
        <div class="relative bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                <i class="fas fa-check-circle text-5xl"></i>
            </div>
            <h2 class="text-2xl font-black text-gray-800 mb-2">Pesanan Diterima!</h2>
            <p class="text-gray-500 mb-6 text-sm">Terima kasih <span class="font-bold text-purple-700" x-text="customer.name"></span>, pesanan anda sedang kami proses secara internal.</p>
            <button @click="orderSuccess = false; cart = []; showCart = false;" class="w-full py-3 bg-purple-700 text-white rounded-xl font-bold hover:bg-purple-800 transition shadow-lg">
                Kembali Belanja
            </button>
        </div>
    </div>

    <script>
        function cartSystem() {
            return {
                showCart: false,
                orderSuccess: false,
                cart: [],
                customer: { name: '', email: '', phone: '' },
                selectedPayment: '',
                paymentMethods: ['Transfer Bank (BCA/Mandiri)', 'E-Wallet (OVO/DANA/GoPay)', 'QRIS (Otomatis)'],
                get total() { return this.cart.reduce((sum, item) => sum + item.harga, 0); },
                addToCart(product) {
                    this.cart.push(product);
                    const toast = document.createElement("div");
                    toast.className = "fixed bottom-5 left-1/2 -translate-x-1/2 bg-gray-800 text-white px-6 py-3 rounded-full shadow-2xl z-[200]";
                    toast.innerHTML = `<i class="fas fa-check-circle mr-2 text-purple-400"></i> ${product.nama} ditambahkan`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2000);
                },
                removeFromCart(index) { this.cart.splice(index, 1); },
                checkout() {
    // Kirim data ke Laravel menggunakan Fetch API
    fetch("{{ route('checkout') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}" // Penting untuk keamanan Laravel
        },
        body: JSON.stringify({
            nama: this.customer.name,
            email: this.customer.email,
            phone: this.customer.phone,
            items: this.cart,
            total: this.total,
            payment: this.selectedPayment
        })
    })
    .then(response => {
        if(response.ok) {
            this.orderSuccess = true;
        } else {
            alert("Terjadi kesalahan saat menyimpan pesanan.");
        }
    })
    .catch(error => console.error("Error:", error));
}
            }
        }
    </script>
</body>
</html>
