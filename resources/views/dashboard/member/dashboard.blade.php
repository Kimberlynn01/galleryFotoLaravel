@extends('dashboard.member.template.main')

@section('content')
    <div class="grid-container" id="grid-container">
        @foreach ($photos as $photo)
            <div class="grid-item relative">
                <img src="{{ asset('storage/' . $photo->lokasifoto) }}" alt="{{ $photo->nama_foto }}">
                <div
                    class="overlay flex justify-between items-end p-2 absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black to-transparent text-white">
                    <div class="status text-sm">{{ $photo->nama_foto }}</div>
                    <div class="user-profile flex items-center">
                        <img src="{{ asset('storage/' . $photo->user->picture) }}" alt="{{ $photo->user->name }}"
                            class="profile-picture">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($photos->isEmpty())
        <p class="text-center text-gray-500 dark:text-gray-400 mt-4">No photos found.</p>
    @endif
@endsection

@push('styles')
    <style>
        .grid-container {
            column-count: 6;
            column-gap: 10px;
        }

        .grid-item {
            break-inside: avoid;
            margin-bottom: 10px;
            position: relative;
        }

        .grid-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
        }

        .overlay {
            border-radius: 8px;
            transition: opacity 0.3s;
            opacity: 0;
        }

        .grid-item:hover .overlay {
            opacity: 1;
        }

        .profile-picture {
            width: 34px !important;
            height: 34px !important;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Script to shuffle photos
        const gridContainer = document.getElementById('grid-container');

        const photosData = {!! json_encode($photos) !!};

        const shuffledPhotos = photosData.sort(() => 0.5 - Math.random());

        gridContainer.innerHTML = '';

        shuffledPhotos.forEach(photo => {
            const gridItem = document.createElement('div');
            gridItem.className = 'grid-item relative';
            const img = document.createElement('img');
            img.src = `storage/${photo.lokasifoto}`;
            img.alt = photo.nama_foto;
            gridItem.appendChild(img);

            const overlay = document.createElement('div');
            overlay.className =
                'overlay flex justify-between items-end p-2 absolute bottom-0 left-0 w-full h-full bg-gradient-to-t from-black to-transparent text-white';
            const status = document.createElement('div');
            status.className = 'status text-sm';
            status.textContent = photo.nama_foto;

            const userProfile = document.createElement('div');
            userProfile.className = 'user-profile flex items-center';
            const userImg = document.createElement('img');
            userImg.src = `storage/${photo.user.picture}`;
            userImg.alt = photo.user.name;
            userImg.className = 'profile-picture';

            userProfile.appendChild(userImg);
            overlay.appendChild(status);
            overlay.appendChild(userProfile);
            gridItem.appendChild(overlay);

            gridContainer.appendChild(gridItem);
        });
    </script>
@endpush
