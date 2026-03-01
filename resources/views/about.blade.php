<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tentang Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Biodata Mahasiswa</h3>
                    <table class="table-auto w-full text-left">
                        <tbody>
                            <tr>
                                <td class="font-bold py-2 w-32">Nama</td>
                                <td>: [Aldys Igidia Triatmaja]</td>
                            </tr>
                            <tr>
                                <td class="font-bold py-2">NIM</td>
                                <td>: [20230140207]</td>
                            </tr>
                            <tr>
                                <td class="font-bold py-2">Prodi</td>
                                <td>: [Teknologi Informasi]</td>
                            </tr>
                            <tr>
                                <td class="font-bold py-2">Hobi</td>
                                <td>: [Membaca]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>