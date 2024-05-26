@extends('dashboard.member.template.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@push('styles')
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">

    <!-- SweetAlert2 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <!-- Toastr CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        #albumsTable_paginate .paginate_button.current {
            color: black !important;
            padding: 6px 12px;
            background-color: white !important;
            border-radius: 4px;
            margin: 0 4px;
            font-size: 14px;
        }

        #albumsTable_paginate .paginate_button {
            background-color: white !important;
            color: black !important;
            border-radius: 4px;
            font-size: 14px;
        }



        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="table-responsive">
        <table id="albumsTable" class="table table-bordered responsive nowrap w-[screen] bg-white" style="width:100%">
            <thead>
                <tr class="w-full bg-gray-500 text-white">
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">#</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Nama Album
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Deskripsi
                        Album
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Cover Album
                    </th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($albums as $album)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} ">
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $album->nama_album }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {!! \Illuminate\Support\Str::limit($album->deskripsi_album, 17, '...') !!}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <img src="{{ '../storage/' . $album->thumbnail_album }}" class="w-20"
                                alt="{{ $album->nama_album }}">
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="action-buttons">
                                <button type="button"
                                    class="bg-blue-500 mb-3 text-white px-4 py-2 rounded hover:bg-blue-700"
                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $album->id }}">Edit</button>
                                <!-- Modal Edit -->
                                <div class="modal fade" id="editModal{{ $album->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form action="{{ route('album.form.update', $album->id) }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Album
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-4">
                                                        <label for="nama_album"
                                                            class="block text-gray-700 font-bold mb-2">Nama
                                                            Album</label>
                                                        <input type="text" id="nama_album" name="nama_album"
                                                            value="{{ $album->nama_album }}"
                                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="deskripsi_album"
                                                            class="block text-gray-700 font-bold mb-2">Deskripsi
                                                            Album</label>
                                                        <textarea id="deskripsi_album" name="deskripsi_album"
                                                            class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                                            rows="4">{{ $album->deskripsi_album }}</textarea>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="picture"
                                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Picture
                                                            <label class="text-red-500">*</label></label>
                                                        <div
                                                            class="max-w mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                                                            <div class="px-4 py-6">
                                                                <div id="preview-container"
                                                                    class="max-w p-6 mb-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                                                                    <input id="upload-btn" type="file"
                                                                        name="thumbnail_album" class="hidden"
                                                                        accept="image/*" />
                                                                    <label for="upload-btn" class="cursor-pointer">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            fill="none" viewBox="0 0 24 24"
                                                                            stroke-width="1.5" stroke="currentColor"
                                                                            class="w-8 h-8 text-gray-700 mx-auto mb-4">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                                                        </svg>
                                                                        <h5
                                                                            class="mb-2 text-xl font-bold tracking-tight text-gray-700">
                                                                            Upload picture</h5>
                                                                        <p
                                                                            class="font-normal text-sm text-gray-400 md:px-6">
                                                                            Choose photo size should be less
                                                                            than <b class="text-gray-600">2mb</b>
                                                                        </p>
                                                                        <p
                                                                            class="font-normal text-sm text-gray-400 md:px-6">
                                                                            and should be in <b class="text-gray-600">JPG,
                                                                                PNG, or
                                                                                GIF</b> format.</p>
                                                                        <span id="filename"
                                                                            class="text-gray-500 bg-gray-200 z-50"></span>
                                                                    </label>
                                                                </div>
                                                                <div class="flex justify-center">
                                                                    <img id="image-preview"
                                                                        src="{{ '../storage/' . $album->thumbnail_album }}"
                                                                        class="mt-2 rounded-lg object-cover "
                                                                        style="max-width: 230px" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save
                                                        changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('album.delete', $album->id) }}" method="post"
                                    class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 delete-btn">Delete</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@push('scripts')
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- DataTables JS CDN -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>

    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

    <!-- Toastr JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const uploadInput = document.getElementById('upload-btn');
        const imagePreview = document.getElementById('image-preview');
        const filenameDisplay = document.getElementById('filename');

        uploadInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function() {
                    imagePreview.src = reader.result;
                    filenameDisplay.textContent = file.name;
                    imagePreview.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.src = '';
                filenameDisplay.textContent = '';
                imagePreview.classList.add('hidden');
            }
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#albumsTable').DataTable({
                responsive: true,

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
                    $('#albumsTable_filter input').addClass(
                        ' appearance-none border rounded w-50 mb-3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-3 me-3'
                    );
                    $('#albumsTable_length select').addClass(
                        ' appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mt-3 me-3 '
                    );
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

        // @if (session('success'))
        //     toastr.success("{{ session('success') }}", 'Success');
        // @endif
        @if (session('success2'))
            toastr.error("{{ session('success2') }}", 'Success');
        @endif
    </script>
@endpush
