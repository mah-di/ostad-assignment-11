<x-app-layout>
    <x-slot name="header">
        <h2 style="text-align: center;" class="font-semibold text-xl text-gray-800 leading-tight">
            Sales Overview
        </h2>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Sales Report - Daily Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $today->format('d M Y') }} (Today)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Total Sales Made</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $salesReportToday->salesMade }}</td>
                                    <td class="border border-slate-300 p-4">{{ $salesReportToday->revenue }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $yesterday->format('d M Y') }} (Yesterday)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Total Sales Made</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $salesReportYesterday->salesMade }}</td>
                                    <td class="border border-slate-300 p-4">{{ $salesReportYesterday->revenue }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Sales Report - Monthly Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $thisMonth->format('M Y') }} (This Month)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Total Sales Made</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $salesReportThisMonth->salesMade }}</td>
                                    <td class="border border-slate-300 p-4">{{ $salesReportThisMonth->revenue }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $lastMonth->format('M Y') }} (Last Month)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Total Sales Made</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $salesReportLastMonth->salesMade }}</td>
                                    <td class="border border-slate-300 p-4">{{ $salesReportLastMonth->revenue }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Sales Report - Historical Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>Historical Report</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Total Sales Made</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $salesReportHistorical->salesMade }}</td>
                                    <td class="border border-slate-300 p-4">{{ $salesReportHistorical->revenue }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Top Performers - Daily Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $today->format('d M Y') }} (Today)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Product</th>
                                    <th class="border border-slate-300 p-4">Units Sold</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPerformerToday as $product)
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $product->title }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->unitSold }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->revenue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $yesterday->format('d M Y') }} (Yesterday)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Product</th>
                                    <th class="border border-slate-300 p-4">Units Sold</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPerformerYesterday as $product)
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $product->title }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->unitSold }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->revenue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Top Performers - Monthly Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $thisMonth->format('M Y') }} (This Month)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Product</th>
                                    <th class="border border-slate-300 p-4">Units Sold</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPerformerThisMonth as $product)
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $product->title }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->unitSold }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->revenue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>{{ $lastMonth->format('M Y') }} (Last Month)</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Product</th>
                                    <th class="border border-slate-300 p-4">Units Sold</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPerformerLastMonth as $product)
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $product->title }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->unitSold }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->revenue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 style="text-align: center;" class="font-semibold text-xl">Top Performers - Historical Analysis</h2><br>
                <div style="display: flex; justify-content: space-evenly;">
                    <div>
                        <table class=" table-auto">
                            <caption>
                                <b>Historical Report</b>
                            </caption>
                            <br>
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-slate-300 p-4">Product</th>
                                    <th class="border border-slate-300 p-4">Units Sold</th>
                                    <th class="border border-slate-300 p-4">Revenue Generated</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topPerformerHistorical as $product)
                                <tr>
                                    <td class="border border-slate-300 p-4">{{ $product->title }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->unitSold }}</td>
                                    <td class="border border-slate-300 p-4">{{ $product->revenue }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
