<?php

namespace App\Livewire\Faculty;

use App\Models\Faculty;
use Livewire\Component;

class Index extends Component
{
    public $name;
    public $facultyId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|min:3'
    ];

    public function save()
    {
        $this->validate();

        Faculty::create([
            'name' => $this->name
        ]);

        $this->reset();

        $this->dispatch('success', message: 'Faculté ajoutée avec succès');
    }

    public function edit($id)
    {
        $faculty = Faculty::findOrFail($id);

        $this->facultyId = $faculty->id;
        $this->name = $faculty->name;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        Faculty::findOrFail($this->facultyId)
            ->update([
                'name' => $this->name
            ]);

        $this->reset();

        $this->isEditing = false;

        $this->dispatch('success', message: 'Faculté modifiée');
    }

    public function delete($id)
    {
        Faculty::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Faculté supprimée');
    }

    public function render()
    {
        return view('livewire.faculty.index', [
            'faculties' => Faculty::latest()->get()
        ]);
    }
}