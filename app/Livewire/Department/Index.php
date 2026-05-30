<?php

namespace App\Livewire\Department;

use App\Models\Department;
use App\Models\Faculty;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    #[Rule('required|string|min:3', as:"Designation du departement")]
    public $name;
    #[Rule("required|exists:faculties,id", as:"Faculté")]
    public $faculty_id;

    public $departmentId;

    public $isEditing = false;

    public function save()
    {
        $this->validate();

        Department::create([
            'name' => $this->name,
            'faculty_id' => $this->faculty_id
        ]);

        $this->reset();

        $this->dispatch('success', message: 'Département ajouté avec succès');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        $this->departmentId = $department->id;

        $this->name = $department->name;
        $this->faculty_id = $department->faculty_id;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        Department::findOrFail($this->departmentId)
            ->update([
                'name' => $this->name,
                'faculty_id' => $this->faculty_id
            ]);

        $this->reset();

        $this->isEditing = false;

        $this->dispatch('success', message: 'Département modifié avec succès');
    }

    public function delete($id)
    {
        Department::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Département supprimé');
    }
    public function render()
    {
        return view('livewire.department.index', [
            'departments' => Department::with('faculty')
                ->latest()
                ->get(),
            'faculties' => Faculty::orderBy('name')->get()
        ]);
    }
}
