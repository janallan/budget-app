@if ($errors->any())
    <flux:card class="mb-4">
        <ul class="list-disc ps-5 space-y-1">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </flux:card>
@endif
