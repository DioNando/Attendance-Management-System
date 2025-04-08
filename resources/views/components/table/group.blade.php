@props(['headers' => []])

<div class="flow-root" x-data="doubleScrollbar()">
    <div class="">
        <!-- Top scrollbar wrapper -->
        <div x-ref="topScrollWrapper" @scroll="updateBottomScroll()" class="overflow-x-auto scrollbar-custom">
            <div x-ref="topScrollContent" style="height: 1px;"></div>
        </div>

        <!-- Table wrapper -->
        <div x-ref="tableWrapper" @scroll="updateTopScroll()"
            class="overflow-auto scrollbar-custom py-2">
            <table class="w-full md:rounded-lg overflow-hidden outline -outline-offset-1 outline-gray-300 dark:outline-gray-700">
                <x-table.head :headers="$headers" />
                {{ $slot }}
                {{-- <x-table.body :data="$data" /> --}}
            </table>
        </div>
    </div>
</div>

<script>
    function doubleScrollbar() {
        return {
            init() {
                this.syncScrollWidth();

                // Observer les changements de taille
                const resizeObserver = new ResizeObserver(() => this.syncScrollWidth());
                resizeObserver.observe(this.$refs.tableWrapper);
            },

            syncScrollWidth() {
                this.$refs.topScrollContent.style.width = this.$refs.tableWrapper.scrollWidth + 'px';
            },

            updateTopScroll() {
                this.$refs.topScrollWrapper.scrollLeft = this.$refs.tableWrapper.scrollLeft;
            },

            updateBottomScroll() {
                this.$refs.tableWrapper.scrollLeft = this.$refs.topScrollWrapper.scrollLeft;
            }
        };
    }
</script>
