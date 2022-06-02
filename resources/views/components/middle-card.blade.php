<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div {{ $attributes->merge(['style' => 'width:400px', 'class' => 'rounded bg-white p-4 shadow']) }}>
        {{ $slot }}
    </div>
</div>
