<?php

namespace App\Livewire\Promotion;

use App\Models\Department;
use App\Models\Promotion;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    #[Rule('required|string|min:2', as: "Designation de la promotion")]
    public $name;
    #[Rule("required|exists:departments,id", as: "Département")]
    public $department_id;

    public $promotion_id;

    public $isEditing = false;

    public function save()
    {
        $this->validate();

        Promotion::create([
            'name' => $this->name,
            'department_id' => $this->department_id
        ]);

        $this->reset();

        $this->dispatch('success', message: 'Promotion ajoutée avec succès');
    }

    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);

        $this->promotion_id = $promotion->id;

        $this->name = $promotion->name;
        $this->promotion_id = $promotion->faculty_id;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        Promotion::findOrFail($this->promotion_id)
            ->update([
                'name' => $this->name,
                'department_id' => $this->department_id
            ]);

        $this->reset();

        $this->isEditing = false;

        $this->dispatch('success', message: 'Promotion modifiée avec succès');
    }

    public function delete($id)
    {
        Promotion::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Promotion supprimée');
    }
    public function render()
    {
        return view('livewire.promotion.index', [
            'promotions' => Promotion::with('department')
                ->latest()
                ->get(),
            'departments' => Department::orderBy('name')->get()
        ]);
    }
}
