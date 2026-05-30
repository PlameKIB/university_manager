<?php

namespace App\Livewire\AcadeYear;

use App\Models\AcademicYear;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    #[Rule('string|max:10', as: "Année academique")]
    public $name;
    public $isEditing = false;
    public $academYear;
    public function save()
    {
        $this->validate();
        AcademicYear::create([
            'name' => $this->name
        ]);
        $this->reset();

        $this->dispatch('success', message: 'Année academique ajoutée avec succès');
    }
    public function edit($id)
    {
        $this->academYear = AcademicYear::findOrFail($id);
        $this->name = $this->academYear->name;
        $this->isEditing = true;
    }
    public function update()
    {
        $this->validate();
        AcademicYear::findOrFail($this->academYear->id)->update([
            'name' => $this->name
        ]);
        $this->reset();
        $this->dispatch('success', message: 'Année Academique modifiée avec succès');
        $this->isEditing = false;
    }
    public function delete($id)
    {
        AcademicYear::findOrFail($id)->delete();
        $this->dispatch('success', message: 'Année Academique supprimée avec succès');
    }
    public function setStatus($id)
    {

        $this->academYear = AcademicYear::findOrFail($id);

        $this->academYear->is_active = !$this->academYear->is_active;
        $this->academYear->save();
        $this->reset();
    }
    public function render()
    {
        return view('livewire.acade-year.index', [
            'academ_years' => AcademicYear::orderBy('name', 'desc')->get()
        ]);
    }
}
