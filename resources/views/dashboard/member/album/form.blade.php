@extends('dashboard.member.template.main')

@section('content')
    <div class="container mt-5">
        <form class="max-w mx-auto grid grid-cols-2 gap-4" action="{{ route('album.form.post') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Album <label
                        class="text-red-500">*</label></label>
                <input type="text" id="name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Nama Album" name="nama_album" required />
            </div>
            <div class="col-span-2">
                <label for="picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Picture <label
                        class="text-red-500">*</label></label>
                <div class="max-w mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-4 py-6">
                        <div id="preview-container"
                            class="max-w p-6 mb-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                            <input id="upload-btn" type="file" name="thumbnail_album" class="hidden" accept="image/*" />
                            <label for="upload-btn" class="cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-700 mx-auto mb-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-700">Upload picture</h5>
                                <p class="font-normal text-sm text-gray-400 md:px-6">Choose photo size should be less
                                    than <b class="text-gray-600">2mb</b></p>
                                <p class="font-normal text-sm text-gray-400 md:px-6">and should be in <b
                                        class="text-gray-600">JPG, PNG, or GIF</b> format.</p>
                                <span id="filename" class="text-gray-500 bg-gray-200 z-50"></span>
                            </label>
                        </div>
                        <div class="flex justify-center">
                            <img id="image-preview" class="mt-2 rounded-lg object-cover hidden" style="max-width: 230px" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2">
                <label for="deskripsi"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                <textarea id="deskripsi"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Deskripsi Album" name="deskripsi_album" required></textarea>
                <img id="preview" class="mt-2 rounded-lg  object-cover" style="max-width: 230px" />
            </div>

            <button type="submit"
                class="col-span-2 text-white bg-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
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
@endpush
