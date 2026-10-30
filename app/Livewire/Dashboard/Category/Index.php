<?php

namespace App\Livewire\Dashboard\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $sortBy = 'id';
    public string $sortDirection = 'desc';

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $categories = Category::orderBy($this->sortBy, $this->sortDirection)->paginate(10);
        return view('livewire.dashboard.category.index', compact('categories'));
    }

    public function delete(Category $category)
    {
        $category->delete();

        session()->flash('status', 'Categoría eliminada correctamente.');
        return $this->redirectRoute('d-category-index', navigate: true);
    }
}
