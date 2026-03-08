<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Lapak Second</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex min-h-screen">
        <aside class="w-64 bg-purple-800 text-white p-6 hidden md:block">
            <h1 class="text-2xl font-bold mb-8">Admin Lapak</h1>
            <nav class="space-y-4">
                <a href="#" class="block py-2.5 px-4 rounded bg-purple-900 transition font-bold">
                    <i class="fas fa-shopping-cart mr-2"></i> Pesanan Masuk
                </a>
                <a href="/" class="block py-2.5 px-4 rounded hover:bg-purple-700 transition">
                    <i class="fas fa-store mr-2"></i> Lihat Toko
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-8 bg-white p-6 rounded-2xl shadow-sm">
                <h2 class="text-2xl font-black text-gray-800 uppercase">Kelola Pesanan</h2>
                <div class="text-sm text-gray-500">Total: {{ $orders->count() }} Pesanan</div>
            </header>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-400 uppercase text-xs font-bold">
                        <tr>
                            <th class="p-4 border-b">ID</th>
                            <th class="p-4 border-b">Pembeli</th>
                            <th class="p-4 border-b">Produk</th>
                            <th class="p-4 border-b">Total</th>
                            <th class="p-4 border-b">Pembayaran</th>
                            <th class="p-4 border-b text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition border-b border-gray-100">
                            <td class="p-4 font-bold text-purple-700">#{{ $order->id }}</td>
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $order->nama_pembeli }}</div>
                                <div class="text-xs text-gray-400">{{ $order->nomor_hp }}</div>
                            </td>
                            <td class="p-4">
                                <ul class="text-xs list-disc pl-4">
                                    @foreach($order->item_pesanan as $item)
                                        <li>{{ $item['nama'] }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-4 font-black">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td class="p-4 text-xs">{{ $order->metode_pembayaran }}</td>
                            <td class="p-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-green-100 text-green-600 border border-green-200">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-20 text-center text-gray-400">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>