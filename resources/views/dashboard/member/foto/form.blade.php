@extends('dashboard.member.template.main')

@section('content')
    <div class="container mt-5">
        <form class="max-w-sm mx-auto grid grid-cols-2 gap-4" action="{{ route('foto.form.post') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div>
                <label for="judulfoto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Foto</label>
                <input type="text" id="judulfoto"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Nama Foto" name="nama_foto" required />
            </div>
            <div>
                <label for="album" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                    Album</label>
                <select name="albumId" id="album" required
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                    <option>Select Album</option>
                    @foreach ($albums as $album)
                        <option value="{{ $album->id }}">{{ $album->nama_album }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-2">
                <label for="foto" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                    Foto</label>
                <input type="file" name="lokasifoto" id="foto" onchange="previewImage(event)" accept="image/*"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    required>
            </div>
            <div class="col-span-2">
                <label for="deskripsi"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea id="deskripsi"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Deskripsi Foto" name="deskripsi_foto" required></textarea>
                <img id="preview" class="mt-2 rounded-lg object-cover" style="max-width: 150px" />
            </div>

            <button type="submit"
                class="col-span-2 text-white bg-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
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
