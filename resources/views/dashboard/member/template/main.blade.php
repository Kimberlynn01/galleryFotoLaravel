<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Member</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }

        .fixed-sidebar {
            position: fixed;
            height: 100%;
            z-index: 10;
            overflow-y: auto;
        }

        .fixed-navbar {
            position: fixed;
            width: calc(100% - 16rem);
            /* Adjust width considering the sidebar width */
            top: 0;
            right: 0;
            z-index: 10;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 60px;
            /* Adjust width considering the sidebar width */
            z-index: 10;
        }

        .content {
            margin-left: 16rem;
            /* Same width as the sidebar */
            margin-top: 4rem;
            /* Same height as the navbar */
        }

        @media (max-width: 768px) {
            .fixed-navbar {
                width: 100%;
            }

            .fixed-sidebar {
                margin-top: calc(64px);
            }


            footer {
                position: relative;
                bottom: 0;
                left: 0px;
                /* Adjust width considering the sidebar width */
                z-index: 10;
            }

            .content {
                margin-left: 0;
                margin-top: 4rem;
            }
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-purple-700 text-white flex flex-col fixed-sidebar hidden md:block">
            <div class="flex items-center justify-center h-20 border-b border-purple-800">
                <h1 class="text-2xl font-bold">Gallery Foto</h1>
            </div>
            <div class="flex-1 overflow-y-auto">
                <ul class="p-4">
                    <li class="mb-2">
                        <a href="/" class="flex items-center p-2 rounded hover:bg-purple-600">
                            <i class="fas fa-home mr-2"></i> Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/dashboard" class="flex items-center p-2 rounded hover:bg-purple-600">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <button
                            class="dropdown-toggle w-full flex items-center p-2 rounded hover:bg-purple-600 focus:outline-none">
                            <i class="fas fa-images mr-2"></i> Album
                            <i class="arrow-icon fas fa-chevron-down ml-auto transition-transform duration-300"></i>
                        </button>
                        <ul class="dropdown-content hidden pl-6">
                            <li class="mb-2">
                                <a href="/album/" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-images mr-2"></i> Album
                                </a>
                                <a href="/album/tambah" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-plus mr-2"></i> Tambah Baru
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/album/sort" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-list mr-2"></i> Category
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="mb-2">
                        <button
                            class="dropdown-toggle w-full flex items-center p-2 rounded hover:bg-purple-600 focus:outline-none">
                            <i class="fas fa-camera mr-2"></i> Foto
                            <i class="arrow-icon fas fa-chevron-down ml-auto transition-transform duration-300"></i>
                        </button>
                        <ul class="dropdown-content hidden pl-6">
                            <li class="mb-2">
                                <a href="/foto" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-camera mr-2"></i> Foto
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="/foto/form" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-plus mr-2"></i> Tambah Baru
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="/foto/status" class="flex items-center p-2 rounded hover:bg-purple-600">
                                    <i class="fas fa-clock mr-2"></i> Status
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <footer class="flex items-center justify-center h-20 border-t border-purple-800">
                <p class="text-sm">© 2024 <a href="https://github.com/Kimberlynn01/">Danudiraja</a></p>
            </footer>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="h-16 bg-white shadow-md flex items-center justify-between px-4 fixed-navbar">
                <div class="flex items-center">
                    <button id="menuButton" class="text-blue-900 hover:text-blue-700 md:hidden">
                        <i class="fas fa-bars fa-2x"></i>
                    </button>
                    <h1 class="text-xl font-bold text-purple-900 ml-2">Dashboard Member</h1>
                </div>
                <div class="flex items-center">
                    <button class="text-gray-500 hover:text-gray-900">
                        <i class="fas fa-bell fa-2x mr-5"></i>
                    </button>
                    <button id="profileButton" class="text-gray-500 hover:text-gray-700 relative">
                        <div class="rounded-full overflow-hidden w-8 h-8 flex items-center justify-center">
                            @if (!empty(Auth::user()->picture))
                                <img src="{{ '../storage/' . Auth::user()->picture }}" alt="Profile Picture"
                                    class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user fa-2x"></i>
                            @endif
                        </div>
                        <ul id="profileDropdown"
                            class="dropdown-content hidden absolute right-5 mt-2 bg-white border border-gray-300 rounded shadow-md z-10 w-40">
                            <li>
                                <a href="{{ route('profile.index') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200"><i
                                        class="fas fa-user text-gray-500 mr-2"></i>Profile</a>
                            </li>
                            <li>
                                <a href="/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-200"><i
                                        class="fas fa-sign-out-alt text-gray-500 mr-2"></i>Logout</a>
                            </li>
                        </ul>
                    </button>
                </div>
            </header>

            <!-- Content -->
            <main class=" p-4 content">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.getElementById('menuButton').addEventListener('click', function() {
            document.querySelector('.fixed-sidebar').classList.toggle('hidden');
        });

        document.querySelectorAll('.dropdown-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const dropdownContent = this.nextElementSibling;
                const arrowIcon = this.querySelector('.arrow-icon');
                dropdownContent.classList.toggle('hidden');
                arrowIcon.classList.toggle('rotate-180');
            });
        });

        document.getElementById('profileButton').addEventListener('click', function() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        });
    </script>

    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        @if (session('success'))
            toastr.success("{{ session('success') }}", 'Success');
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", 'Error');
        @endif
    </script>

    @stack('scripts')
</body>

</html>
