<div class="p-4 sm:p-6 bg-white dark:bg-[#0D1321] rounded-xl shadow-md">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Antrian Hari Ini</h2>

    @if ($queues->isEmpty())
        <p class="text-gray-500 dark:text-gray-300">Belum ada antrian hari ini.</p>
    @else
        <div class="space-y-4">
            @foreach ($queues as $queue)
                <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 transition hover:shadow">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div class="mb-2 sm:mb-0">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $queue->code }}</h3>
                            {{-- <p class="text-sm text-gray-600 dark:text-gray-300">Pelanggan: {{ $queue->customer_name }}</p> --}}
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 text-sm text-gray-700 dark:text-gray-200">
                            <span>{{ $queue->items_count }} item</span>
                            <span>Total: Rp {{ number_format($queue->total_price, 0, ',', '.') }}</span>
                            <span>Status: 
                                <span class="@class([
                                    'text-yellow-500' => $queue->status === 'menunggu',
                                    'text-blue-500' => $queue->status === 'diproses',
                                    'text-green-500' => $queue->status === 'selesai',
                                ])">
                                    {{ ucfirst($queue->status) }}
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- List Items Section -->
                    <div class="mt-4 pl-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Daftar Item:</h4>
                        <ul class="space-y-2">
                            @foreach ($queue->items as $item)
                                <li class="flex justify-between text-sm">
                                    <div class="text-gray-600 dark:text-gray-400">
                                        {{ $item->item_name }} × {{ $item->quantity }}
                                    </div>
                                    <div class="text-gray-700 dark:text-gray-300">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>