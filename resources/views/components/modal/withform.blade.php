@props([
    'formId' => null,
    'title',
    'btnActionName',
    'actionPath',
    'method' => 'POST',
    'enctype' => 'application/x-www-form-urlencoded',
    'withClose' => false
])

<form action="{{ $actionPath }}" method="{{ $method }}" enctype="{{ $enctype }}" @isset($formId)id="{{ $formId }}"@endisset>
    @csrf
    @if($withClose)
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">{{ $title }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    @endif
    <div {{ $attributes->class('modal-body') }}>
        {{ $slot }}
    </div>
    <div class="modal-footer">
        @if($withClose)
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        @endif
        <button type="submit" class="btn btn-primary">{{ $btnActionName }}</button>
    </div>
</form>
