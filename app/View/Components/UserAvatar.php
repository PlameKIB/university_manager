<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\User;

class UserAvatar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public User $user,
        public string $size = 'md',
        public bool $showName = false,
    ) {
    }

    /**
     * Get the size classes
     */
    protected function getSizeClasses(): string
    {
        return match($this->size) {
            'xs' => 'w-6 h-6 text-xs',
            'sm' => 'w-8 h-8 text-sm',
            'md' => 'w-10 h-10 text-base',
            'lg' => 'w-12 h-12 text-lg',
            'xl' => 'w-14 h-14 text-xl',
            '2xl' => 'w-20 h-20 text-2xl',
            default => 'w-10 h-10 text-base',
        };
    }

    /**
     * Get the display name
     */
    public function getDisplayName(): string
    {
        return $this->user->name ?? 'User';
    }

    /**
     * Get the initials
     */
    public function getInitials(): string
    {
        return $this->user->initials();
    }

    /**
     * Get the photo URL
     */
    public function getPhotoUrl(): ?string
    {
        if ($this->user->photo) {
            return asset('storage/' . $this->user->photo);
        }
        return null;
    }

    /**
     * Render the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-avatar', [
            'sizeClasses' => $this->getSizeClasses(),
            'photoUrl' => $this->getPhotoUrl(),
            'displayName' => $this->getDisplayName(),
            'initials' => $this->getInitials(),
        ]);
    }
}
