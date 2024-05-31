<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Imagem de perfil') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Campo de Upload de Imagem -->
        <div>
            <x-input-label for="profile_image" :value="__('Alterar imagem')" />
            <div id="image_preview" class="mt-4">
                <img src="{{ $user->profile_image ? Storage::url($user->profile_image) : '' }}" id="preview_img" style="max-width: 300px; max-height: 300px; {{ $user->profile_image ? '' : 'display: none;' }}" alt="Profile Image">
            </div>
            <input type="file" id="profile_image" name="profile_image" class="mt-1 block w-full" onchange="previewImage();">
            <small>Por favor carregue uma imagem não maior que 3MB.</small>
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
        </div>
    </form>
</section>

<script>
    function previewImage() {
        var fileInput = document.getElementById("profile_image");
        var file = fileInput.files[0];

        if (file) {
            if (file.size > 3145728) { // Tamanho em bytes (3MB)
                alert('File too large. The file size cannot exceed 3MB.');
                fileInput.value = ''; // Reset the input
                return; // Stop the function
            }

            var fileReader = new FileReader();
            fileReader.onload = function(event) {
                document.getElementById("preview_img").setAttribute("src", event.target.result);
                document.getElementById("preview_img").style.display = "block";
            };
            fileReader.readAsDataURL(file);
        }
    }

</script>
