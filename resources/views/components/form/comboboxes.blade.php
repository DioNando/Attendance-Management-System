@props([
    'name',
    'options' => [],
    'placeholder' => 'Sélectionner une option',
    'autocomplete' => 'on',
    'size' => 'md',
    'class' => '',
])
@php
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3 py-1.5 text-base',
        'lg' => 'px-4 py-2 text-lg',
    ];
    $inputClasses =
        'col-start-1 row-start-1 w-full rounded-md bg-gray-100 dark:bg-white/5 py-1.5 pr-8 pl-3 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 *:bg-gray-200 dark:*:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-500 sm:text-sm/6' .
        ' ' .
        ($errors->has($name) ? 'outline-red-500 dark:outline-red-400' : 'outline-gray-300 dark:outline-white/10') .
        ' ' .
        $sizes[$size] .
        ' ' .
        $class;
    $id = str_replace('.', '_', $name);
@endphp

<div class="mt-2 grid grid-cols-1" x-data="combobox{{ $id }}">
    <div class="col-start-1 row-start-1 relative">
        <input x-ref="input" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
            autocomplete="{{ $autocomplete }}" class="{{ $inputClasses }}" role="combobox"
            aria-controls="{{ $name }}-options" x-bind:aria-expanded="open.toString()" @click="toggle()"
            @keydown.arrow-down.prevent="open = true" @keydown.arrow-up.prevent="open = true"
            @keydown.escape="open = false">

        <ul class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white dark:bg-gray-800 py-1 text-base ring-1 shadow-lg ring-black/5 dark:ring-white/10 focus:outline-hidden sm:text-sm"
            id="{{ $name }}-options" role="listbox" x-show="open" x-cloak>
            @forelse($options as $value => $label)
                <li class="relative cursor-pointer py-2 pr-9 pl-3 text-gray-900 dark:text-white hover:bg-blue-100 dark:hover:bg-blue-900/50 select-none"
                    id="{{ $name }}-option-{{ $loop->index }}" role="option"
                    x-bind:class="{ 'bg-blue-100 dark:bg-blue-900/50 font-semibold': value === '{{ $value }}' }"
                    @click="select('{{ $value }}', '{{ $label }}')">
                    <span class="block truncate">{{ $label }}</span>
                    <template x-if="value === '{{ $value }}'">
                        <span
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600 dark:text-blue-500">
                            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </template>
                </li>
            @empty
                <li class="relative cursor-default py-2 pr-9 pl-3 text-gray-500 dark:text-gray-400 select-none">
                    <span class="block truncate">Aucune option disponible</span>
                </li>
            @endforelse
        </ul>
    </div>
    <x-heroicon-o-chevron-up-down
        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4" />
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('combobox{{ $id }}', () => ({
            open: false,
            value: @entangle($name),

            init() {
                this.updateSelectedLabel();

                this.$watch('value', () => {
                    this.updateSelectedLabel();
                });

                // Fermer le dropdown si on clique ailleurs
                document.addEventListener('click', (event) => {
                    if (!this.$el.contains(event.target)) {
                        this.open = false;
                    }
                });
            },

            updateSelectedLabel() {
                const options = @js($options);
                this.$refs.input.value = options[this.value] || '';
            },

            toggle() {
                this.open = !this.open;
            },

            select(value, label) {
                this.value = value;
                this.$refs.input.value = label;
                this.open = false;
            }
        }));
    });
</script>
