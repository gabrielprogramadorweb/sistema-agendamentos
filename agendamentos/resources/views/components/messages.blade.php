{{-- resources/views/components/messages.blade.php --}}
@php
    $alertTypes = [
        'success' => ['class' => 'alert-success', 'icon' => 'fa-check-circle'],
        'info'    => ['class' => 'alert-info', 'icon' => 'fa-info-circle'],
        'error'   => ['class' => 'alert-danger', 'icon' => 'fa-exclamation-circle'],
    ];
@endphp

@foreach ($alertTypes as $type => $settings)
    @if (session($type))
        <div class="alert {{ $settings['class'] }} alert-dismissible fade show" role="alert">
            <i class="fas {{ $settings['icon'] }}"></i>
            {{ session($type) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

