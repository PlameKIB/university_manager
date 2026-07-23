<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
            <x-app-logo class="size-20" href="#"></x-app-logo>
        </a>

        <flux:navlist variant="outline">

            <flux:navlist.group heading="University M" class="grid">

                {{-- Dashboard --}}
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>
                    Dashboard
                </flux:navlist.item>

                {{-- Inscription rapide --}}
                <flux:navlist.item icon="identification" :href="route('enrollment.create')"
                    :current="request()->routeIs('enrollment.create')" wire:navigate>
                    Inscription
                </flux:navlist.item>

                {{-- Payment --}}
                <flux:navlist.item icon="credit-card" :href="route('admin.payments')"
                    :current="request()->routeIs('admin.payments')" wire:navigate>
                    Paiements
                </flux:navlist.item>

                {{-- MENU COTATION (ENSEIGNANT UNIQUEMENT) --}}
                @hasanyrole('enseignant|admin')
                <flux:navlist.item icon="clipboard-document-check" :href="route('cotation.index')"
                    :current="request()->routeIs('cotation.*')" wire:navigate>
                    Mes cours à coter
                </flux:navlist.item>
                @endhasanyrole

                {{-- MENU INSCRIPTIONS --}}
                <flux:navlist.group expandable collapsed heading="Inscriptions" icon="document-text">

                    <flux:navlist.item icon="list-bullet" :href="route('enrollment.index')"
                        :current="request()->routeIs('enrollment.index')" wire:navigate>
                        Liste des inscriptions
                    </flux:navlist.item>

                    <flux:navlist.item icon="plus-circle" :href="route('enrollment.create')"
                        :current="request()->routeIs('enrollment.create')" wire:navigate>
                        Nouvelle inscription
                    </flux:navlist.item>

                    <flux:navlist.item icon="academic-cap" :href="route('dashboard')" wire:navigate>
                        Palmarès
                    </flux:navlist.item>

                </flux:navlist.group>

                {{-- MENU ETUDIANTS --}}
                <flux:navlist.group expandable collapsed heading="Etudiants" icon="users">

                    <flux:navlist.item icon="user-group" :href="route('student.index')"
                        :current="request()->routeIs('student.index')" wire:navigate>
                        Liste des étudiants
                    </flux:navlist.item>

                    <flux:navlist.item icon="user-plus" :href="route('student.create')"
                        :current="request()->routeIs('student.create')" wire:navigate>
                        Nouvel étudiant
                    </flux:navlist.item>

                </flux:navlist.group>

                {{-- MENU COURS / COTATION (ADMIN) --}}
                <flux:navlist.group expandable collapsed heading="Cours" icon="book-open">

                    <flux:navlist.item icon="book-open" :href="route('admin.course')"
                        :current="request()->routeIs('admin.course')" wire:navigate>
                        Catalogue des cours
                    </flux:navlist.item>

                    <flux:navlist.item icon="link" :href="route('admin.course_assignment')"
                        :current="request()->routeIs('admin.course_assignment')" wire:navigate>
                        Attributions (enseignant / promotion)
                    </flux:navlist.item>

                </flux:navlist.group>

                {{-- MENU PARAMETRES --}}
                <flux:navlist.group expandable collapsed heading="Paramètres" icon="cog-6-tooth">

                    <flux:navlist.item icon="building-office" icon:class="text-bg-dark" :href="route('admin.faculty')"
                        wire:navigate>
                        Faculté
                    </flux:navlist.item>

                    <flux:navlist.item icon="calendar-days" :href="route('admin.academic_year')" wire:navigate>
                        Année académique
                    </flux:navlist.item>

                    <flux:navlist.item icon="squares-2x2" :href="route('admin.department')" wire:navigate>
                        Département
                    </flux:navlist.item>

                    <flux:navlist.item icon="bookmark" :href="route('admin.promotion')" wire:navigate>
                        Promotion
                    </flux:navlist.item>

                    <flux:navlist.item icon="currency-dollar" :href="route('admin.fee')" wire:navigate>
                        Frais academiques
                    </flux:navlist.item>

                </flux:navlist.group>

                {{-- Teachers --}}
                <flux:navlist.group expandable collapsed heading="Enseignants" icon="user">

                    <flux:navlist.item icon="user-plus" :href="route('admin.teacher.create')" wire:navigate>
                        Nouvel enseignant
                    </flux:navlist.item>

                </flux:navlist.group>

                {{-- MENU UTILISATEURS / ROLES (ADMIN UNIQUEMENT) --}}
                @role('admin')
                <flux:navlist.item icon="user-circle" :href="route('admin.users')"
                    :current="request()->routeIs('admin.users')" wire:navigate>
                    Utilisateurs &amp; rôles
                </flux:navlist.item>
                @endrole

            </flux:navlist.group>


        </flux:navlist>
        <flux:spacer />

        <flux:dropdown position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon-trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                    {{ auth()->user()->initials() }}
                                </span>
                            </span>

                            <div class="grid flex-1 text-left text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>