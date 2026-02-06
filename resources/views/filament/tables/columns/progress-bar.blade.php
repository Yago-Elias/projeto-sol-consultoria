<div class="w-full min-w-50 flex flex-row gap-2 pr-3">
    <span><strong>{{ $percent }}%</strong></span>
    @include('filament.resources.projects.partials.progress', ['percent' => $percent])
</div>
