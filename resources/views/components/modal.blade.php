@props(['id', 'maxWidth', 'submit'])

@php
    $id = $id ?? md5($attributes->wire('model'));

        $maxWidth = [
            'sm' => 'sm:max-w-screen-sm',
            'md' => 'sm:max-w-screen-md',
            'lg' => 'sm:max-w-screen-lg',
            'xl' => 'sm:max-w-screen-xl',
            '2xl' => 'sm:max-w-screen-2xl',
        ][$maxWidth ?? '2xl'];
@endphp

<div
    x-data="{
        show: @entangle($attributes->wire('model')).defer
    }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-cloak
    class="fixed inset-0 z-10 h-screen overflow-y-auto py-10">
    <div x-show="show" x-cloak
         @click="show = false"
         class="fixed inset-0 w-full h-full z-40 bg-black bg-opacity-50"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    ></div>

    <div x-show="show" x-cloak
         class="overflow-y-auto bg-white w-11/12 {{$maxWidth}} xl:text-lg fixed z-50 top-1/2 left-1/2 w-full max-h-[90vh] transform -translate-x-1/2 -translate-y-1/2"
         x-transition:enter="ease-out duration-500"
         x-transition:enter-start="opacity-0 sm:scale-95"
         x-transition:enter-end="opacity-100 sm:scale-100"
         x-transition:leave="ease-in duration-300"
         x-transition:leave-start="opacity-100 sm:scale-100"
         x-transition:leave-end="opacity-0 sm:scale-95"
    >
        <div class="py-4 px-6 md:py-6 md:px-8 flex items-center bg-gray-800 text-white">
            <div class="flex-grow w-1/2 pr-6 md:pr-10 lg:pr-20 text-xl xl:text-2xl">
                {{$title}}
            </div>

            <a href="javascript:void(0);"
               @click="show = false"
               class="stext-xl lg:text-3xl px-3 py-1 hover:bg-white w-12 h-12 flex items-center justify-center rounded-full hover:bg-opacity-10 transition-colors">
                <i class="fal fa-times"></i>
            </a>
        </div>

        <div class="px-4 py-6 md:p-8 space-y-8">
            {{ $slot }}

            <div class="flex justify-end space-x-4 pt-2">
                <x-jet-button
                    @click="show = false"
                    class="min-w-[100px] md:px-6 xl:px-8 max-w-full text-center lg:text-lg">
                    {{ $cancelbutton }}
                </x-jet-button>

                @if(isset($button))
                    <x-jet-button
                        wire:loading.attr="disabled"
                        x-on:click="$wire.{{ $submit ?? '' }}"
                        class="min-w-[100px] md:px-6 xl:px-8 max-w-full text-center lg:text-lg outline-none focus:outline-none">
                        {{ $button }}
                    </x-jet-button>
                @endif
            </div>
        </div>
    </div>
</div>
