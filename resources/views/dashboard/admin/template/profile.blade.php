@extends('dashboard.admin.template.main')

@push('scripts')
    <style>
        .img_priview {
            max-width: 250px;
        }
    </style>
@endpush

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
                <label for="picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Picture</label>
                <input type="file" id="picture"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    name="picture" onchange="previewImage(event)" accept="image/*" />
                <img id="preview" class="mt-2 rounded-lg img_priview object-cover"
                    src="{{ 'storage/' . Auth::user()->picture }}" />
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
