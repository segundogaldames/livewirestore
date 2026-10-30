<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="w-full max-w-lg mx-auto mt-12 bg-white rounded shadow-md p-4">
        <h2 class="font-bold text-center text-2xl">Nueva Categoría</h2>
        <form wire:submit="store" class="md:px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <flux:label for="title">Title</flux:label>
                <flux:input id="title" type="text" wire:model="title" />
                <flux:error name="title" />
            </div>

            <div class="mb-4">
                <flux:label for="text">Text</flux:label>
                <flux:textarea id="text" wire:model="text" />
                <flux:error name="text" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Imagen de la Categoría</label>
                <input type="file" wire:model="image" accept="image/*" class="w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-zinc-900 file:text-white hover:file:bg-zinc-700" />
                <!-- Estado de carga -->
                <div wire:loading wire:target="image" class="text-xs text-zinc-500 mt-1">Cargando imagen...</div>

                @error('image') <span class="text-xs text-red-500 block mt-1">{{ $message }}</span> @enderror

                <!-- Previsualización -->
                <div class="mt-3">
                    @if ($image)
                        {{-- Muestra la vista previa temporal de la NUEVA imagen seleccionada --}}
                        <p class="text-xs text-zinc-500 mb-1">Nueva imagen seleccionada:</p>
                        <img
                            src="{{ $image->temporaryUrl() }}"
                            class="w-64 h-32 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm"
                        />
                    @elseif ($category && $category->image)
                        {{-- Muestra la imagen ACTUAL guardada en la base de datos al EDITAR --}}
                        <p class="text-xs text-zinc-500 mb-1">Imagen actual:</p>
                        <img
                            src="{{ $category->getImageURL() }}"
                            alt="{{ $category->title }}"
                            class="w-64 h-32 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm"
                        />
                    @endif
                </div>
            </div>
            <!-- Se eliminó wire:click="store" y se agregó protección contra doble clic -->
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="bg-green-700 hover:bg-green-600 disabled:opacity-50 text-white py-2 px-4 rounded rounded-xs transition-colors"
            >
                <span wire:loading.remove>Send</span>
                <span wire:loading>Sending...</span>
            </button>
            <a href="{{ route('d-category-index') }}" class="bg-blue-700 hover:bg-blue-600 disabled:opacity-50 text-white py-2 px-4 rounded rounded-xs transition-colors">Volver</a>
        </form>
    </div>
</div>
