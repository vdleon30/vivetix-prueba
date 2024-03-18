@php
    $type = session('message_info')
        ? 'info'
        : (session('message_success')
            ? 'success'
            : (session('message_warning')
                ? 'warning'
                : (session('message_error')
                    ? 'danger'
                    : '')));
@endphp

@if (!empty($type))
    <div class="alert alert-{{ $type }}" role="alert">
        {{ session('message_error') ?? session("message_$type") }}
    </div>
@endif



@if (isset($errors) && $errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{ $error }}
        </div>
    @endforeach
@endif
