<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Fees extends Component
{
    #[Rule('required|string', as: "designation")]
    public $name;
    #[Rule('required|numeric', as: "Promotion")]
    public $promotion_id;
    #[Rule('required|numeric', as: "Année académique")]
    public $academic_year_id;
    #[Rule('required|numeric', as: "Montant")]
    public $amount;
    public $isEditing = false;
    public $feeId;

    public function save()
    {
        $this->validate();

        \App\Models\Fee::create([
            'name' => $this->name,
            'promotion_id' => $this->promotion_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
        ]);

        $this->reset(['name', 'promotion_id', 'academic_year_id', 'amount']);
        $this->dispatch('success', message: 'Frais ajoutés avec succès');
    }

    public function cancel()
    {
        $this->isEditing = False;
        $this->reset();
    }
    public function edit($id)
    {
        $fee = \App\Models\Fee::findOrFail($id);
        $this->isEditing = true;
        $this->feeId = $fee->id;
        $this->name = $fee->name;
        $this->promotion_id = $fee->promotion_id;
        $this->academic_year_id = $fee->academic_year_id;
        $this->amount = $fee->amount;
    }
    public function update()
    {
        $this->validate();

        \App\Models\Fee::findOrFail($this->feeId)->update([
            'name' => $this->name,
            'promotion_id' => $this->promotion_id,
            'academic_year_id' => $this->academic_year_id,
            'amount' => $this->amount,
        ]);

        $this->reset(['name', 'promotion_id', 'academic_year_id', 'amount']);
        $this->isEditing = false;
        $this->dispatch('success', message: 'Frais modifiés avec succès');
    }

    public function delete($id)
    {
        \App\Models\Fee::findOrFail($id)->delete();
        $this->dispatch('success', message: 'Frais supprimés avec succès');
    }
    public function render()
    {
        $promotions = \App\Models\Promotion::all();
        return view('livewire.settings.fees', [
            'fees' => \App\Models\Fee::with(['promotion', 'academicYear'])->get(),
            'promotions' => $promotions,
            'academicYears' => \App\Models\AcademicYear::all(),
        ]);
    }
}
