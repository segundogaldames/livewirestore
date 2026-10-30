<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Locked;

class Save extends Component
{
    use WithFileUploads;

    #[Locked]
    public ?Category $category = null;

    public string $title = '';
    public string $slug = '';
    public string $text = '';
    public $image = null;

    public function mount(?Category $category = null)
    {
        if ($category && $category->exists) {
            $this->category = $category;
            $this->title = $this->category->title;
            $this->slug = $this->category->slug;
            $this->text = $this->category->text;
        }
    }

    protected function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'title')->ignore($this->category),
            ],
            'text'  => 'required|string|min:3',
            'image' => 'nullable|image|max:2048'
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.category.save');
    }

    public function updatedTitle(string $value): void
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($this->title);
        }

        // Ejecuta la validación con las reglas dinámicas
        $validatedData = $this->validate();
        $validatedData['slug'] = $this->slug;

        // 3. Procesar y guardar la imagen si se seleccionó una nueva
        if ($this->image) {
            // Guarda el archivo en storage/app/public/categories
            $validatedData['image'] = $this->image->store('categories', 'public');
        } else {
            // Removemos la clave si no se subió una nueva imagen para no sobreescribir con null
            unset($validatedData['image']);
        }

        if ($this->category && $this->category->exists) {
            $this->category->update($validatedData);
            session()->flash('status', 'Categoría actualizada correctamente.');
        } else {
            Category::create($validatedData);
            session()->flash('status', 'Categoría creada correctamente.');
        }

        return $this->redirectRoute('d-category-index', navigate: true);
    }
}
