@extends('dashboard.admin.template.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@push('styles')
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

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

        #status1 {
            background-color: #5AB2FF;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
        }

        #status2 {
            background-color: #FFAF61;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
        }

        #status3 {
            background-color: #7ABA78;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
        }

        #status4 {
            background-color: #8B322C;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('content')
    <div class="mx-auto mt-5 ">
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <div class="card">
                <div class="card-header">
                    <h2 class="font-bold text-xl m-2">Status Gallery</h2>
                </div>
                <div class="card-body">
                    <table id="albumsTable" class="min-w-full bg-white">
                        <thead>
                            <tr class="w-full bg-gray-500 text-white">
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">#</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Name
                                    Registrasion
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Photo
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Name
                                    Photo</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">
                                    Description
                                    Photo
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Status
                                    Photo
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 tracking-wider">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuss as $photo)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $photo->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"><a
                                            href="{{ '../storage/' . $photo->lokasifoto }}" target="_blank"
                                            class="px-3 py-1 border rounded text-white hover:bg-purple-600 bg-purple-400 text-sm">See
                                            Photo</a></td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        {{ $photo->nama_foto }}</td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <button type="button">
                                            {{ \Illuminate\Support\Str::limit($photo->deskripsi_foto, 17, '...') }}</button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if ($photo->statusId == 3)
                                            <button type="button" id="status{{ $photo->statusId }}"
                                                class="px-3 py-1 border rounded text-sm">{{ $photo->status->nama_status }}</button>
                                        @else
                                            <button type="button" id="status{{ $photo->statusId }}" data-bs-toggle="modal"
                                                data-bs-target="#editStatus{{ $photo->id }}"
                                                class="px-3 py-1 border rounded text-sm">{{ $photo->status->nama_status }}</button>
                                        @endif
                                    </td>



                                    <!-- Modal -->
                                    <div class="modal fade" id="editStatus{{ $photo->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('status.update', $photo->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Judul Modal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-4">
                                                            <label for="status"
                                                                class="block text-gray-700 font-bold mb-2">Status
                                                                Photo</label>
                                                            <select name="statusId" id=""
                                                                class="block w-full rounded-md border-gray-300 border px-3 py-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                                @foreach ($status as $stat)
                                                                    @if ($photo->statusId == 2 && ($stat->id == 3 || $stat->id == 4))
                                                                        <option value="{{ $stat->id }}"
                                                                            {{ $stat->id == $photo->statusId ? 'selected' : '' }}>
                                                                            {{ $stat->nama_status }}
                                                                        </option>
                                                                    @elseif ($stat->id == $photo->statusId + 1)
                                                                        <option value="{{ $stat->id }}"
                                                                            {{ $stat->id == $photo->statusId ? 'selected' : '' }}>
                                                                            {{ $stat->nama_status }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach

                                                                @if ($photo->statusId === 4)
                                                                    <option value="2">Ajukan Banding Ulang</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @if ($photo->statusId == 4)
                                            <button type="button" id="openModalButton"
                                                class="px-3 py-1 border rounded bg-purple-700 text-white text-sm">Edit</button>
                                        @else
                                            <p>No Action</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
                    // $('#albumsTable_wrapper').addClass('p-4');
                    $('#albumsTable_filter input').addClass(
                        ' appearance-none border rounded w-50 mb-3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    );
                    $('#albumsTable_length select').addClass(
                        ' appearance-none border rounded  py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                    );
                    // $('#albumsTable_paginate').addClass('flex justify-end mt-4');
                    // $('#albumsTable_paginate .paginate_button').addClass(
                    //     'px-3 py-1 border rounded bg-blue-500 text-white hover:bg-blue-700');
                    // $('#albumsTable_paginate .paginate_button.disabled').addClass(
                    //     'bg-blue-300 text-gray-500 cursor-not-allowed');
                    // $('#albumsTable_info').addClass('mt-4 text-gray-700');
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
