<div>
    {{-- Container con ancho adecuado para tablas y padding para que bleed haga efecto --}}
    <div class="w-full max-w-4xl mx-auto mt-12 bg-white dark:bg-zinc-900 rounded-xl shadow-md border border-zinc-200 dark:border-zinc-800 p-6">

        {{-- Mensaje de estado --}}
        @if (session('status'))
            <div x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3500)"
                    x-show="show"
                    x-transition.duration.500ms
                    class="mb-4 p-4 text-sm text-green-800 dark:text-green-200 rounded-lg bg-green-50 dark:bg-green-950 border border-green-200 dark:border-green-800" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-xl font-bold text-zinc-900 dark:text-white">Lista de Categorías</h1>
            <flux:button href="{{ route('d-category-save') }}" wire:navigate size="sm" variant="primary" color="blue" icon="plus">
                Nueva
            </flux:button>
        </div>

        {{-- La tabla absorbérá el p-6 lateral del contenedor padre --}}
        <flux:table bleed>
            <flux:table.columns>
                <flux:table.column sortable
                            :sorted="$sortBy === 'id'"
                            :direction="$sortDirection"
                            wire:click="sort('id')">Id</flux:table.column>

                <flux:table.column sortable
                            :sorted="$sortBy === 'title'"
                            :direction="$sortDirection"
                            wire:click="sort('title')">Title</flux:table.column>
                <flux:table.column sortable
                            :sorted="$sortBy === 'text'"
                            :direction="$sortDirection"
                            wire:click="sort('text')">Text</flux:table.column>
                <flux:table.column class="text-right">Acciones</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($categories as $categoria)
                    <flux:table.row :key="$categoria->id">
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $categoria->id }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex items-center gap-3">
                                @if ($categoria->image)
                                    <img
                                        src="{{ Storage::url($categoria->image) }}"
                                        alt="{{ $categoria->title }}"
                                        class="w-10 h-10 rounded-full object-cover border border-zinc-200 dark:border-zinc-700 shadow-sm"
                                    />
                                @else
                                    {{-- Placeholder elegante cuando la categoría no tiene imagen registrada --}}
                                    <div class="w-10 h-10 rounded-full bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-xs font-semibold text-zinc-500 uppercase">
                                        {{ substr($categoria->title, 0, 2) }}
                                    </div>
                                @endif

                                <span class="font-medium text-zinc-900 dark:text-white">
                                    {{ $categoria->title }}
                                </span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="font-medium text-zinc-900 dark:text-white">
                            {{ $categoria->title }}
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-600 dark:text-zinc-300">
                            {{ $categoria->text }}
                        </flux:table.cell>
                        <flux:table.cell class="text-right">
                            <flux:button href="{{ route('d-category-edit', $categoria->id) }}" wire:navigate size="sm" variant="outline" color="blue" icon="pencil">
                                Edit
                            </flux:button>
                            <flux:button wire:click="delete({{ $categoria }})" wire:confirm="¿Estás seguro de que deseas eliminar esta categoría?" wire:navigate size="sm" variant="danger" color="red" icon="trash">
                                Delete
                            </flux:button>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3" class="text-center py-4 text-zinc-500">
                            No hay categorías disponibles.
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
        {{$categories->links()}}
    </div>
</div>
