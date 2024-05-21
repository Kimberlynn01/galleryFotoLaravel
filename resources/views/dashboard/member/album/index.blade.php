@extends('dashboard.member.template.main')

@push('styles')
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <!-- SweetAlert2 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <!-- Toastr CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        #albumsTable_paginate .paginate_button.current {
            background-color: black !important;
            color: black !important;
            padding: 6px 12px;
            border-radius: 4px;
            margin: 0 4px;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto mt-5">
        <div class="overflow-x-auto  bg-white shadow-md rounded-lg">
            <table id="albumsTable" class="min-w-full bg-white">
                <thead>
                    <tr class="w-full bg-gray-500 text-white">
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">#</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Nama Album</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Deskripsi Album
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Cover Album
                        </th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($albums as $album)
                        <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $album->nama_album }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $album->deskripsi_album }}
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                <img src="{{ '../storage/' . $album->thumbnail_album }}" class="w-20"
                                    alt="{{ $album->nama_album }}">
                            </td>
                            <td
                                class="mt-10 px-6 py-4 whitespace-no-wrap text-sm flex items-center justify-center space-x-2">
                                <button type="button" id="openModalButton"
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</button>
                                <!-- Modal -->
                                <div id="myModal" class="fixed inset-0  z-50 hidden overflow-y-auto">
                                    <div class="flex items-center justify-center min-h-screen">
                                        <div class="fixed inset-0 bg-black opacity-50"></div>
                                        <div class="relative bg-white rounded-lg p-8 max-w-md w-full">
                                            <!-- Close Button -->
                                            <button id="closeModalButton"
                                                class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700">
                                                <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12">
                                                    </path>
                                                </svg>
                                            </button>
                                            <div class="text-start">
                                                <h3 class="text-xl font-bold mb-4">Edit Album</h3>
                                                <form action="{{ route('album.form.update', $album->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-4">
                                                        <label for="nama_album"
                                                            class="block text-gray-700 font-bold mb-2">Nama Album</label>
                                                        <input type="text" id="nama_album" name="nama_album"
                                                            value="{{ $album->nama_album }}"
                                                            class=" appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="deskripsi_album"
                                                            class="block text-gray-700 font-bold mb-2">Deskripsi
                                                            Album</label>
                                                        <textarea id="deskripsi_album" name="deskripsi_album"
                                                            class=" appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                            rows="4">{{ $album->deskripsi_album }}</textarea>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="thumbnail_album"
                                                            class="block text-gray-700 font-bold mb-2">Thumbnail
                                                            Album</label>
                                                        <input type="file" id="thumbnail_album"
                                                            class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                                                            name="thumbnail_album" onchange="previewImage(event)"
                                                            accept="image/*" />

                                                    </div>
                                                    <!-- Tambahkan tag img untuk menampilkan priview gambar -->
                                                    <img id="preview" class="mt-2 rounded-lg w-20 h-20 object-cover"
                                                        src="{{ '../storage/' . $album->thumbnail_album }}"
                                                        alt="Preview Image" />

                                                    <div class="flex justify-end">
                                                        <button type="button"
                                                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                                                            id="closeModalButton">Close</button>
                                                        <button type="submit"
                                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('album.delete', $album->id) }}" method="post" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 delete-btn">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

    <!-- Toastr JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const closeModalInsideButton = document.getElementById('closeModalInsideButton');
        const modal = document.getElementById('myModal');

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        closeModalInsideButton.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#albumsTable').DataTable({
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ entri per halaman",
                    "zeroRecords": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(disaring dari total _MAX_ entri)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "<i class='fas fa-angle-double-left'></i>",
                        "last": "<i class='fas fa-angle-double-right'></i>",
                        "next": "<i class='fas fa-angle-right'></i>",
                        "previous": "<i class='fas fa-angle-left'></i>"
                    }
                },
                "initComplete": function() {
                    $('#albumsTable_wrapper').addClass('p-4');
                    $('#albumsTable_filter input').addClass(
                        'shadow appearance-none border rounded w-50 mb-3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    );
                    $('#albumsTable_length select').addClass(
                        'shadow appearance-none border rounded w-50 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    );
                    $('#albumsTable_paginate').addClass('flex justify-end mt-4');
                    $('#albumsTable_paginate .paginate_button').addClass(
                        'px-3 py-1 border rounded bg-blue-500 text-white hover:bg-blue-700');
                    $('#albumsTable_paginate .paginate_button.disabled').addClass(
                        'bg-blue-300 text-gray-500 cursor-not-allowed');
                    $('#albumsTable_info').addClass('mt-4 text-gray-700');
                }
            });

            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('.delete-form');

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Anda tidak akan bisa mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('success'))
            toastr.success("{{ session('success') }}", 'Success');
        @endif
        @if (session('success2'))
            toastr.error("{{ session('success2') }}", 'Success');
        @endif
    </script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
