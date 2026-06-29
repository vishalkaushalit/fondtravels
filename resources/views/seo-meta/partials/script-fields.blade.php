@php
    $scriptSource = $scriptSource ?? $seoMeta ?? null;
    $scriptFields = [
        'header_scripts' => [
            'label' => 'Header Schema / Scripts',
            'help' => 'Injected before the closing head tag. Use this for JSON-LD schema, verification tags, or header scripts.',
        ],
        'body_scripts' => [
            'label' => 'Body Scripts',
            'help' => 'Injected immediately after the opening body tag.',
        ],
        'footer_scripts' => [
            'label' => 'Footer Scripts',
            'help' => 'Injected before the closing body tag. Use this for scripts that should load at the end of the page.',
        ],
    ];
@endphp

@foreach ($scriptFields as $field => $config)
    <div class="col-md-12 mb-3">
        <label for="{{ $field }}" class="form-label">{{ $config['label'] }}</label>
        <textarea id="{{ $field }}" name="{{ $field }}" rows="6" class="form-control font-monospace"
            placeholder="&lt;script&gt;...&lt;/script&gt;">{{ old($field, $scriptSource?->{$field}) }}</textarea>
        <small class="text-muted">{{ $config['help'] }}</small>
    </div>
@endforeach
