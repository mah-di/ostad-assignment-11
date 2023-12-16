<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ (isset($searchVal)) ? "Search Results for \"{$searchVal}\"" : __('All Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if ($searchVal === null)
                <div class="flex justify-center py-8">
                    <div class="">
                        <a href="{{ route('product.create') }}">
                            <span class="px-4 py-2 rounded bg-gray-500 hover:bg-green-400 text-lg text-white">
                                Add New Product
                            </span>
                        </a>
                    </div>
                </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (count($products) == 0)
                    <div class="flex justify-center">
                        <div class="py-32">
                            <span>Oops, Nothing Found...</span>
                        </div>
                    </div>
                    @endif
                    @foreach ($products as $product)
                    <div class="p-4 bg-slate-50 dark:bg-gray-600 my-4">

                        <a href="{{ route('product.show', $product->id) }}">
                            <div class="p-2 bg-slate-100 dark:bg-gray-500">
                                <p class="text-xl">{{ $product->title }}</p>
                                <p class="text-sm">Price: {{ $product->price }}</p>
                                <p class="text-sm">Stock: {{ $product->stock }}</p>
                            </div>
                        </a>
                        <div class="py-4 flex justify-end">
                            <a href="{{ route('product.edit', $product->id) }}">
                                <span class="px-4 py-2 rounded bg-sky-500/75 hover:bg-sky-500 text-lg text-white">
                                    Update
                                </span>
                            </a>
                            &nbsp;
                            <a href="{{ route('sale.create', ['product_id' => $product->id]) }}">
                                <span class="px-4 py-2 rounded bg-green-500/75 hover:bg-green-500 text-lg text-white">
                                    Make Sale
                                </span>
                            </a>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            {{$products}}
        </div>
    </div>

</x-app-layout>
