<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $searchVal ? "Showing Result for Invoice ID {$searchVal}" : __('All Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end">
                        <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <div class="mt-4">
                                <form action="{{ route('sale.index') }}" method="GET">
                                    <input class="py-1 px-3 rounded border-gray-200 bg-blue-50" placeholder="Invoices ID" value="{{ $searchVal ?? '' }}" type="text" name="q">
                                    <button class="py-1 px-3 rounded bg-sky-500 text-white text-xs" type="submit">Search Invoice ID</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (count($sales) == 0)
                        <div class="flex justify-center">
                            <div class="py-32">
                                <span>Oops, Nothing Found...</span>
                            </div>
                        </div>
                    @endif
                    @foreach ($sales as $sale)
                    <div class="my-4 p-4 bg-slate-50 dark:bg-gray-600">

                        <a href="{{ route('sale.show', $sale->id) }}">
                            <div class="p-2 bg-slate-100 dark:bg-gray-500">
                                <p class="text-sm">Invoice ID: {{ $sale->id }}</p>
                                <p class="text-xl">{{ $sale->title }}</p>
                                <p class="text-sm">S/N: {{ $sale->serial_number }}</p>
                                <p class="text-sm">Selling Price: {{ $sale->selling_price }}</p>
                                <p class="text-sm">Units: {{ $sale->unit }}</p>
                                <p class="text-sm">Total: {{ $sale->total }}</p>
                            </div>
                        </a>
                        <div class="flex justify-end pt-4">
                            <a href="{{ route('sale.create', ['product_id' => $sale->product_id]) }}">
                                <span class="px-4 py-2 rounded bg-green-500/75 hover:bg-green-500 text-lg text-white">
                                    Sell Again
                                </span>
                            </a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if ($searchVal === null)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {{$sales}}
        </div>
    </div>
    @endif

</x-app-layout>
