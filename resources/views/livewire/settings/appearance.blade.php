<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="flex flex-col items-start">
    @include('partials.settings-heading')

    <x-settings.layout heading="Apparence" subheading="Modifiez les paramètres d'apparence de votre compte">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">Mode clair</flux:radio>
            <flux:radio value="dark" icon="moon">Mode sombre</flux:radio>
            <flux:radio value="system" icon="computer-desktop">Suivre le système</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</div>
