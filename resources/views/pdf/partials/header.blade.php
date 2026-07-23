<div class="header">
    <div class="institution">{{ config('app.name') }}</div>
    <div class="sub">
        @if(!empty($enrollment) && $enrollment->faculty)
            {{ $enrollment->faculty->name }}
            @if($enrollment->department) &middot; {{ $enrollment->department->name }} @endif
        @elseif(!empty($promotion) && $promotion->department)
            {{ $promotion->department->faculty->name ?? '' }}
            &middot; {{ $promotion->department->name }}
        @else
            Direction Académique
        @endif
    </div>
</div>
