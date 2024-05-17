@extends('dashboard.member.template.main')

@section('content')
    <div class="grid-container" id="grid-container">
        @foreach ($photos as $photo)
            <div class="grid-item">
                <img src="{{ asset('storage/' . $photo->lokasifoto) }}" alt="{{ $photo['nama_foto'] }}">
            </div>
        @endforeach
    </div>
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
        }

        .grid-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const gridContainer = document.getElementById('grid-container');

        const photosData = {!! json_encode($photos) !!};

        const shuffledPhotos = photosData.sort(() => 0.5 - Math.random());

        gridContainer.innerHTML = '';

        shuffledPhotos.forEach(photo => {
            const gridItem = document.createElement('div');
            gridItem.className = 'grid-item';
            const img = document.createElement('img');
            img.src = `storage/${photo.lokasifoto}`;
            img.alt = photo.alt;
            gridItem.appendChild(img);
            gridContainer.appendChild(gridItem);
        });
    </script>
@endpush
