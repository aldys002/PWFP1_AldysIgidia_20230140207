<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Header Section --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold tracking-tight text-gray-800 dark:text-white">Product List</h2>
                            <p class="text-sm text-gray-400 mt-1">Manage your inventory and product authorization</p>
                        </div>

                        <div class="flex items-center gap-3">
                            {{-- 🔥 TUGAS KELAS B: Gate Export hanya untuk Admin --}}
                            @can('export-product')
                                <a href="{{ route('product.export') }}"
                                   style="background-color: #16a34a !important;" {{-- Cadangan warna hijau --}}
                                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-200">
                                    Export Excel
                                </a>
                            @endcan

                            {{-- Tombol Add Product --}}
                            <a href="{{ route('product.create') }}"
                               style="background-color: #2563eb !important;" {{-- Cadangan warna biru --}}
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Add Product</span>
                            </a>
                        </div>
                    </div>

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-200 text-green-800 rounded-lg text-sm flex justify-between items-center">
                            <span>{{ session('success') }}</span>
                            <button type="button" class="font-bold" onclick="this.parentElement.remove();">&times;</button>
                        </div>
                    @endif

                    {{-- Table --}}
                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-gray-300">#</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-gray-300">Product Name</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-gray-300">Qty</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-gray-300">Price</th>
                                    <th class="px-6 py-4 text-left font-semibold text-gray-600 dark:text-gray-300">Owner</th>
                                    <th class="px-6 py-4 text-center font-semibold text-gray-600 dark:text-gray-300">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                                @forelse ($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition duration-150">
                                        <td class="px-6 py-4">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                        <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">{{ $product->name }}</td>
                                        <td class="px-6 py-4">{{ $product->quantity }}</td>
                                        <td class="px-6 py-4 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                                {{ $product->user->name ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center items-center gap-3">
                                                <a href="{{ route('product.show', $product->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition">View</a>

                                                {{-- 🔥 POLICY: Update --}}
                                                @can('update', $product)
                                                    <a href="{{ route('product.edit', $product) }}" class="text-yellow-600 hover:text-yellow-700 font-medium transition border-l pl-3 dark:border-gray-600">Edit</a>
                                                @endcan

                                                {{-- 🔥 POLICY: Delete --}}
                                                @can('delete', $product)
                                                    <form action="{{ route('product.delete', $product) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition border-l pl-3 dark:border-gray-600">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">
                                            No products available in the inventory.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>