<div class="header">
    <div class="flag-bar">
        <span class="blue"></span>
        <span class="yellow"></span>
        <span class="red"></span>
    </div>

    <div class="header-row">
        <img src="{{ asset('images/Mt_bg_null.png') }}" alt="{{ config('app.name') }}" class="app-logo" />

        <div class="header-text">
            <div class="country">République Démocratique du Congo</div>
            <div class="ministry">Ministère de l'Enseignement Supérieur et Universitaire</div>
            <div class="institution">{{ config('app.institution') }}</div>
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

        <div class="app-logo spacer"></div>
    </div>
</div>
