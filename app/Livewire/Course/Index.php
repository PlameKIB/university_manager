<?php

namespace App\Livewire\Course;

use App\Models\Course;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    #[Rule('required|string|max:20', as: 'Code du cours')]
    public $code;

    #[Rule('required|string|min:2', as: 'Intitulé du cours')]
    public $intitule;

    public $course_id;

    public $isEditing = false;

    public function save()
    {
        $this->validate([
            'code' => 'required|string|max:20|unique:courses,code',
            'intitule' => 'required|string|min:2',
        ]);

        Course::create([
            'code' => $this->code,
            'intitule' => $this->intitule,
        ]);

        $this->reset();

        $this->dispatch('success', message: 'Cours ajouté avec succès');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        $this->course_id = $course->id;
        $this->code = $course->code;
        $this->intitule = $course->intitule;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate([
            'code' => 'required|string|max:20|unique:courses,code,' . $this->course_id,
            'intitule' => 'required|string|min:2',
        ]);

        Course::findOrFail($this->course_id)->update([
            'code' => $this->code,
            'intitule' => $this->intitule,
        ]);

        $this->reset();
        $this->isEditing = false;

        $this->dispatch('success', message: 'Cours modifié avec succès');
    }

    public function delete($id)
    {
        Course::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Cours supprimé');
    }

    public function render()
    {
        return view('livewire.course.index', [
            'courses' => Course::latest()->get(),
        ]);
    }
}