@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Manage Coloring Game: {{ $game->title }}</h1>
        <a href="{{ route('admin.games.edit', $game) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
            </svg>
            Back to Game
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Game Settings</h2>
        <form action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brush Sizes</label>
                <div id="brushSizes" class="space-y-2">
                    @foreach($game->content['settings']['brush_sizes'] ?? [2, 5, 10, 15] as $index => $size)
                    <div class="flex items-center space-x-2">
                        <input type="number" name="content[settings][brush_sizes][]" value="{{ $size }}" min="1" max="50"
                               class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-24 sm:text-sm border-gray-300 rounded-md">
                        <button type="button" onclick="removeBrushSize(this)"
                                class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addBrushSize()" class="mt-2 text-sm text-primary-600 hover:text-primary-700">
                    + Add Brush Size
                </button>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Default Colors</label>
                <div id="defaultColors" class="space-y-2">
                    @foreach($game->content['settings']['default_colors'] ?? [] as $index => $color)
                    <div class="flex items-center space-x-2">
                        <input type="color" name="content[settings][default_colors][]" value="{{ $color }}"
                               class="h-8 w-16 p-0 border-gray-300 rounded">
                        <button type="button" onclick="removeColor(this)"
                                class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addColor()" class="mt-2 text-sm text-primary-600 hover:text-primary-700">
                    + Add Color
                </button>
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Update Settings
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-medium text-gray-900">Manage Coloring Pages</h2>
            <div class="flex items-center space-x-4">
                <form id="uploadForm" action="{{ route('admin.games.content.update', $game) }}" method="POST" enctype="multipart/form-data" class="inline">
                    @csrf
                    @method('PUT')
                    <label class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 cursor-pointer">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Image
                        <input type="file" class="hidden" id="imageUpload" name="image" accept="image/*" onchange="handleImageUpload(event)">
                    </label>
                </form>
            </div>
        </div>

        <form id="imagesForm" action="{{ route('admin.games.content.update', $game) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div id="imagesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($game->content['images'] ?? [] as $index => $image)
                <div class="image-item border rounded-lg p-4 bg-gray-50">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-md font-medium text-gray-900">Image {{ $index + 1 }}</h3>
                        <button type="button" onclick="removeImage(this, '{{ $image['path'] }}')" class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="aspect-w-4 aspect-h-3">
                            <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['title'] }}" 
                                 class="w-full h-48 object-contain rounded shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="content[images][{{ $index }}][title]" value="{{ $image['title'] }}"
                                   class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <input type="hidden" name="content[images][{{ $index }}][path]" value="{{ $image['path'] }}">
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pt-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function addBrushSize() {
        const container = document.getElementById('brushSizes');
        const template = `
            <div class="flex items-center space-x-2">
                <input type="number" name="content[settings][brush_sizes][]" value="5" min="1" max="50"
                       class="shadow-sm focus:ring-primary-500 focus:border-primary-500 block w-24 sm:text-sm border-gray-300 rounded-md">
                <button type="button" onclick="removeBrushSize(this)"
                        class="text-red-600 hover:text-red-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
    }

    function removeBrushSize(button) {
        button.closest('div').remove();
    }

    function addColor() {
        const container = document.getElementById('defaultColors');
        const template = `
            <div class="flex items-center space-x-2">
                <input type="color" name="content[settings][default_colors][]" value="#000000"
                       class="h-8 w-16 p-0 border-gray-300 rounded">
                <button type="button" onclick="removeColor(this)"
                        class="text-red-600 hover:text-red-800">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
    }

    function removeColor(button) {
        button.closest('div').remove();
    }

    async function handleImageUpload(event) {
        const file = event.target.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append('image', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('_method', 'PUT');
        formData.append('title', file.name.split('.')[0]); // Add the filename as the default title

        try {
            const response = await fetch("{{ route('admin.games.content.update', $game) }}", {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Upload failed');
            }

            const data = await response.json();
            if (data.success) {
                location.reload();
            } else {
                throw new Error(data.message || 'Upload failed');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to upload image: ' + error.message);
        }
    }

    async function removeImage(button, imagePath) {
        if (!confirm('Are you sure you want to delete this image?')) return;

        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        formData.append('_method', 'PUT');
        formData.append('delete_image', imagePath);
        formData.append('action', 'delete_image');

        try {
            const response = await fetch("{{ route('admin.games.content.update', $game) }}", {
                method: 'POST',
                body: formData
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Delete failed');
            }

            const data = await response.json();
            if (data.success) {
                const imageItem = button.closest('.image-item');
                imageItem.remove();
                updateImageNumbers();
            } else {
                throw new Error(data.message || 'Delete failed');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to delete image: ' + error.message);
        }
    }

    function updateImageNumbers() {
        const images = document.querySelectorAll('.image-item');
        images.forEach((image, index) => {
            image.querySelector('h3').textContent = `Image ${index + 1}`;
            
            // Update input names
            const titleInput = image.querySelector('input[name*="[title]"]');
            const pathInput = image.querySelector('input[name*="[path]"]');
            
            titleInput.name = `content[images][${index}][title]`;
            pathInput.name = `content[images][${index}][path]`;
        });
    }
</script>
@endpush
@endsection 