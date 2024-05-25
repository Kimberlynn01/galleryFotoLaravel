@extends('dashboard.member.template.main')

@section('content')
    <div class="container mt-5">
        <form class="max-w mx-auto grid grid-cols-2 gap-4" action="{{ route('profile.update') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" id="name"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Your Name" name="name" value="{{ Auth::user()->name }}" required />
            </div>
            <div>
                @error('email')
                    <span class="text-red-500 text-sm mb-2">{{ $message }}</span>
                @enderror
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                <input type="email" id="email"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    value="{{ Auth::user()->email }}" name="email" required />
            </div>

            <div class="">
                @error('old_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Old
                    Password</label>
                <div class="relative">
                    <input type="password" id="old_password" name="old_password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" />
                    <span id="toggleOldPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-6 h-6 text-gray-400 dark:text-gray-600 toggle-eye">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM12 14V7a3 3 0 00-6 0v7m6 0h1m-2 5v1a2 2 0 11-4 0v-1a2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                    Password</label>
                <div class="relative">
                    <input type="password" id="password"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                        name="password" />
                    <span id="togglePassword" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-6 h-6 text-gray-400 dark:text-gray-600 toggle-eye">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM12 14V7a3 3 0 00-6 0v7m6 0h1m-2 5v1a2 2 0 11-4 0v-1a2 2 0 014 0z" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="col-span-2">
                <div class="max-w mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="px-4 py-6">
                        {{-- <img src="" id="preview"
                        class=" object-cover object-center border-dashed border-2 border-gray-400 p-2 hidden preview-image"
                        style="max-width: 20%; max-height: 250px; margin: 20px auto;" alt=""> --}}
                        <div id="preview"
                            class="max-w p-6 mb-4 bg-gray-100 border-dashed border-2 border-gray-400 rounded-lg items-center mx-auto text-center cursor-pointer">
                            <input id="upload-btn" type="file" name="picture" class="hidden" accept="image/*" />
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
                    </div>
                </div>
            </div>
            <button type="submit"
                class="col-span-2 text-white bg-purple-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const uploadInput = document.getElementById('upload-btn');
        const imagePreview = document.querySelector('.preview-image');
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
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            this.classList.toggle('toggle-eye');
        });

        const toggleRepeatPassword = document.getElementById('toggleRepeatPassword');
        const repeatPasswordInput = document.getElementById('repeat-password');

        toggleRepeatPassword.addEventListener('click', function() {
            const type = repeatPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            repeatPasswordInput.setAttribute('type', type);

            this.classList.toggle('toggle-eye');
        });

        const toggleOldPassword = document.getElementById('toggleOldPassword');
        const oldPasswordInput = document.getElementById('old_password');

        toggleOldPassword.addEventListener('click', function() {
            const type = oldPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            oldPasswordInput.setAttribute('type', type);

            this.classList.toggle('toggle-eye');
        });
    </script>
@endpush
