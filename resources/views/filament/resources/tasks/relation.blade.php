<div class="grid grid-cols-3 gap-4">
    @foreach($this->getTabelas() as $board_id => $table)
        <div>
            <p>board {{ $board_id }}</p>
            {{ $table }}
        </div>
    @endforeach
</div>

