{{-- resources/views/partials/flash.blade.php --}}
@if (session('success') || session('error') || $errors->any())
    <div class="space-y-2 mb-4">
        @if (session('success'))
            <div class="rounded border border-green-200 bg-green-50 px-3 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded border border-red-200 bg-red-50 px-3 py-2 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded border border-amber-200 bg-amber-50 px-3 py-2 text-sm" role="alert" aria-live="polite">
                <p>入力内容を確認してください。</p>
                <ul class="list-disc pl-4 mt-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif

