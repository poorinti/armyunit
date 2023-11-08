<div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0" style="
background-position: 100%;
background-size: 100%;

background-image: url('{{ asset('/image/logo/bg2.jpg') }}');
;
">
<div
        class="absolute top-0 bottom-0 left-0 right-0 flex flex-col items-center w-full h-full min-h-screen pt-6 sm:justify-center sm:pt-0 "
        style="background-color: rgba(0, 0, 0, 0.384)">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">
        {{ $slot }}

    </div>
</div>
</div>
