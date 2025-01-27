<template>
    <RenderlessPagination
        :data="data"
        :limit="limit"
        :keep-length="keepLength"
        @pagination-change-page="onPaginationChangePage"
        v-slot="slotProps"
    >
        <nav
            v-bind="$attrs"
            aria-label="Pagination"
            v-if="slotProps.computed.total > slotProps.computed.perPage"
            class="flex justify-between mt-5"
        >
            <button
                :disabled="!slotProps.computed.prevPageUrl"
                v-on="slotProps.prevButtonEvents"
                class="dark:bg-gray-800 px-3 py-2 disabled:opacity-50 disabled:bg-gray-600">
                <slot name="prev-nav">
                    {{ $t('Previous') }}
                </slot>
            </button>

            <div class="w-full flex justify-center items-center">
                <p>{{ $t('Pagination') }}</p>
            </div>

<!--            <button-->
<!--                :aria-current="slotProps.computed.currentPage ? 'page' : null"-->
<!--                v-for="(page, key) in slotProps.computed.pageRange"-->
<!--                :key="key"-->
<!--                v-on="slotProps.pageButtonEvents(page)"-->
<!--                class="dark:bg-gray-800 px-3 py-2"-->
<!--                :class="slotProps.computed.currentPage === page ? 'border border-green-500' : ''"-->
<!--            >-->
<!--                {{ page }}-->
<!--            </button>-->

            <button
                :disabled="!slotProps.computed.nextPageUrl"
                v-on="slotProps.nextButtonEvents"
                class="dark:bg-gray-800 px-3 py-2 disabled:opacity-50 disabled:bg-gray-600"
            >
                <slot name="next-nav">
                    {{ $t('Next') }}
                </slot>
            </button>
        </nav>
    </RenderlessPagination>
</template>

<script>
import RenderlessPagination from 'laravel-vue-pagination/src/RenderlessPagination.vue';

export default {
    inheritAttrs: false,

    emits: ['pagination-change-page'],

    components: {
        RenderlessPagination
    },

    props: {
        data: {
            type: Object,
            default: () => {}
        },
        limit: {
            type: Number,
            default: 0
        },
        keepLength: {
            type: Boolean,
            default: false
        },
    },

    methods: {
        onPaginationChangePage(page) {
            this.$emit('pagination-change-page', page);
        }
    }
}
</script>
