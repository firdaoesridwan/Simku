<?php $total_aset = collect([]);
$total_kewajiban = collect([]);
$total_modal = collect([]); ?>
@extends('akuntansi.layouts.layout')

@section('content')
    {{-- SECTION tombol akses sebelum tabel --}}
    <div class="md:flex justify-between">
        <div class="md:flex">
            <form action="" class="md:flex md:mx-2 mx-1 md:mb-0 mb-5">

                <input id="date" type="date" class="h-10 md:mx-1 mt-1 form-input block w-full focus:bg-white"
                    id="my-textfield">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                    class="w-12 h-7 md:h-12 mx-auto">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>

                <input id="date" type="date" class="h-10 mt-1 md:mx-1 form-input block w-full focus:bg-white"
                    id="my-textfield">

                <div>
                    <a href="transaksi/cari">
                        <button
                            class="bg-amber-400 opacity-80 p-2 mt-1 font-medium text-sm lg:text-base antialiased">Oke</button>
                    </a>
                </div>
            </form>
        </div>
        <a href="transaksi/download">
            <button
                class="bg-amber-400 opacity-80 p-2 md:mb-0 mb-5 mx-1 mt-1 font-medium text-sm lg:text-base antialiased">Download</button>
        </a>
    </div>
    {{-- END SECTION tombol akses sebelum tabel --}}
    <div class="w-full my-2 bg-zinc-400 h-[1px]"></div>
    <div class="flex flex-col mt-1 mb-0">
        <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 ">
            <div class="inline-block min-w-full overflow-hidden border align-middle shadow-sm sm:rounded-sm">
                <table class="min-w-full">
                    {{-- SECTION Tabel Aset --}}
                    {{-- SECTION Header Tabel --}}
                    <thead class="bg-zinc-200">
                        <tr>
                            <th colspan="3"
                                class="w-20 sm:w-24 px-4 sm:px-6 py-3 text-base font-bold leading-4 tracking-wide text-left text-gray-500 uppercase border-b border-gray-200">
                                Aset
                            </th>
                        </tr>
                    </thead>
                    {{-- END SECTION Header Tabel --}}
                    {{-- SECTION Body Tabel --}}
                    <tbody class="bg-white">
                        @foreach ($aset as $aset)
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        {{ $aset->nama }}
                                    </div>
                                </td>
                            </tr>
                            @foreach ($transaksi->where('debit', $aset->id) as $debit)
                                <tr>
                                    {{-- Baris Debit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            DEBIT {{ Number::currency($debit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Debit --}}
                                </tr>
                            @endforeach
                            @foreach ($transaksi->where('kredit', $aset->id) as $kredit)
                                <tr>
                                    {{-- Baris Kredit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            KREDIT {{ Number::currency($kredit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Kredit --}}
                                </tr>
                            @endforeach
                            {{-- Baris Total per Rekening --}}
                            <tr class="border-gray-400">
                                <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        Total {{ $aset->nama }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        {{-- {{ dd($transaksi->where('kredit', $aset->id)->sum('nominal')) }} --}}
                                        <?php $total_aset_awal = $transaksi->where('debit', $aset->id)->sum('nominal') - $transaksi->where('kredit', $aset->id)->sum('nominal');
                                        $total_aset->push($total_aset_awal); ?>
                                        {{ Number::currency($total_aset_awal, 'IDR', 'id') }}
                                    </div>
                                </td>
                            </tr>
                            {{-- END Baris Total per Rekening --}}
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-2 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="invisible text-sm leading-5 text-gray-500 font-bold">
                                        / Baris kosong \
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- Baris Total Aset --}}
                        <tr class="border-gray-400">
                            <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base leading-5 text-gray-500 font-bold">
                                    Total Aset
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base underline leading-5 text-gray-500 font-bold">
                                    {{ Number::currency($total_aset->sum(), 'IDR', 'id') }}
                                </div>
                            </td>
                        </tr>
                        {{-- END Baris Total Aset --}}
                    </tbody>
                    {{-- END SECTION Body Tabel --}}
                    {{-- END SECTION Tabel Aset --}}
                    {{-- SECTION Tabel Kewajiban & Modal --}}
                    {{-- SECTION Header Tabel --}}
                    <thead class="bg-zinc-200">
                        <tr>
                            <th colspan="3"
                                class="w-20 sm:w-24 px-4 sm:px-6 py-3 text-base font-bold leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200">
                                Kewajiban dan Ekuitas
                            </th>
                        </tr>
                    </thead>
                    {{-- END SECTION Header Tabel --}}
                    <tbody class="bg-white">
                        {{-- SECTION Tabel Kewajiban --}}
                        @foreach ($kewajiban as $kewajiban)
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        {{ $kewajiban->nama }}
                                    </div>
                                </td>
                            </tr>
                            @foreach ($transaksi->where('debit', $kewajiban->id) as $debit)
                                <tr>
                                    {{-- Baris Debit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            DEBIT {{ Number::currency($debit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Debit --}}
                                </tr>
                            @endforeach
                            @foreach ($transaksi->where('kredit', $kewajiban->id) as $kredit)
                                <tr>
                                    {{-- Baris Kredit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            KREDIT {{ Number::currency($kredit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Kredit --}}
                                </tr>
                            @endforeach
                            {{-- Baris Total per Rekening --}}
                            <tr class="border-gray-400">
                                <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        Total {{ $kewajiban->nama }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        <?php $total_kewajiban_awal = $transaksi->where('kredit', $kewajiban->id)->sum('nominal') - $transaksi->where('debit', $kewajiban->id)->sum('nominal');
                                        $total_kewajiban->push($total_kewajiban_awal); ?>
                                        {{ Number::currency($total_kewajiban_awal, 'IDR', 'id') }}
                                    </div>
                                </td>
                            </tr>
                            {{-- END Baris Total per Rekening --}}
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-2 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="invisible text-sm leading-5 text-gray-500 font-bold">
                                        / Baris kosong \
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- Baris Total kewajiban --}}
                        <tr class="border-gray-400">
                            <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base leading-5 text-gray-500 font-bold">
                                    Total Kewajiban
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base underline leading-5 text-gray-500 font-bold">
                                    {{ Number::currency($total_kewajiban->sum(), 'IDR', 'id') }}
                                </div>
                            </td>
                        </tr>
                        {{-- END Baris Total Kewajiban --}}
                        {{-- END SECTION Tabel Kewajiban --}}
                        {{-- SECTION Tabel Ekuitas --}}
                        @foreach ($modal as $modal)
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        {{ $modal->nama }}
                                    </div>
                                </td>
                            </tr>
                            @foreach ($transaksi->where('debit', $modal->id) as $debit)
                                <tr>
                                    {{-- Baris Debit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $debit->rekeningDebit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            DEBIT {{ Number::currency($debit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Debit --}}
                                </tr>
                            @endforeach
                            @foreach ($transaksi->where('kredit', $modal->id) as $kredit)
                                <tr>
                                    {{-- Baris Kredit --}}
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nomor }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        {{ $kredit->rekeningKredit->nama }}
                                    </td>
                                    <td
                                        class="font-medium px-4 sm:px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500 font-medium">
                                            KREDIT {{ Number::currency($kredit->nominal, 'IDR', 'id') }}
                                        </div>
                                    </td>
                                    {{-- END Baris Kredit --}}
                                </tr>
                            @endforeach
                            {{-- Baris Total per Rekening --}}
                            <tr class="border-gray-400">
                                <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        Total {{ $modal->nama }}
                                    </div>
                                </td>
                                <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-500 font-bold">
                                        <?php $total_modal_awal = $transaksi->where('kredit', $modal->id)->sum('nominal') - $transaksi->where('debit', $modal->id)->sum('nominal');
                                        $total_modal->push($total_modal_awal); ?>
                                        {{ Number::currency($total_modal_awal, 'IDR', 'id') }}
                                    </div>
                                </td>
                            </tr>
                            {{-- END Baris Total per Rekening --}}
                            <tr>
                                <td colspan="3"
                                    class="font-medium px-4 sm:px-6 py-2 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                    <div class="invisible text-sm leading-5 text-gray-500 font-bold">
                                        / Baris kosong \
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- Baris Total Ekuitas --}}
                        <tr class="border-gray-400">
                            <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base leading-5 text-gray-500 font-bold">
                                    Total Ekuitas
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base underline leading-5 text-gray-500 font-bold">
                                    {{ Number::currency($total_modal->sum(), 'IDR', 'id') }}
                                </div>
                            </td>
                        </tr>
                        {{-- END Baris Total Ekuitas --}}
                        {{-- END SECTION Tabel Ekuitas --}}
                        {{-- Baris Total Kewajiban & Ekuitas --}}
                        <tr class="border-gray-400">
                            <td colspan="2" class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base leading-5 text-gray-500 font-bold">
                                    Kewajiban & Ekuitas
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 whitespace-no-wrap border-b border-gray-200">
                                <div class="text-base underline leading-5 text-gray-500 font-bold">
                                    {{ Number::currency($total_kewajiban->sum() + $total_modal->sum(), 'IDR', 'id') }}
                                </div>
                            </td>
                        </tr>
                        {{-- END Baris Total Kewajiban & Modal --}}
                    </tbody>
                    {{-- END SECTION Tabel Kewajiban & Modal --}}
                </table>
            </div>
        </div>
    </div>
@endsection
