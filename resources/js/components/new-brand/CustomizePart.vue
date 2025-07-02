<template>
    <section>
        <div class="d-flex gap-2 flex-grow-1 flex-grow-0"  v-if="isEditBook">
            <button type="button" class="btn main-btn" @click.prevent="saveBrandbook">Save changes</button>
            <button type="button" class="btn sec-btn" @click.prevent="cancelSaveBrandbook">Cancel</button>
        </div>
        <a
            type="button"
            class="btn bg-transparent gap-2 text-decoration-underline fs-16 fw-500"
            data-toggle="modal"
            data-target="#customizeModal"
            v-else
        >
            <svg class="icon icon-edit" width="16" height="16">
                <use href="@/utils/new-brand/icons/symbol-defs.svg#icon-edit"></use>
            </svg>
            Customize
        </a>
    </section>
</template>

<script>
import {mapActions, mapState} from "vuex";
import { EventBus } from '@/event-bus';

export default {
    data() {
        return {
            endpoints  : endpoints,
        };
    },

    computed: {
        ...mapState(['isEditBook', 'defaultBrandbook', 'currentBrandTabs'])
    },
    methods: {
        ...mapActions([
            'setDefaultBrandbook',
            'setIsEditBookLoader',
            'setIsEditBook',
            'setCurrentBrandTabs'
        ]),
        saveBrandbook() {
            if(this.defaultBrandbook != null) {
               this.setIsEditBookLoader(true);
               let brandbookId = this.$route.params.id;
                this.defaultBrandbook.current_brand_tabs = this.currentBrandTabs;
                this.defaultBrandbook.main_color_hex = (this.defaultBrandbook.colors_list && this.defaultBrandbook.colors_list[0]) ? this.defaultBrandbook.colors_list[0].color.hex.value : null;
                this.defaultBrandbook.secondary_color_hex = (this.defaultBrandbook.colors_list && this.defaultBrandbook.colors_list[1]) ? this.defaultBrandbook.colors_list[1].color.hex.value : null;
                axios.put(endpoints.ajax.put.edit_custom_field + '/' + brandbookId, this.defaultBrandbook).then( response => {
                   if(response.data) {
                       EventBus.$emit('getBrandbookList');
                       this.setDefaultBrandbook(null);
                       this.setIsEditBookLoader(false);
                   }
               });
               this.setDefaultBrandbook(null);
           }
            this.setIsEditBook(false);
        },
        cancelSaveBrandbook() {
            this.setDefaultBrandbook(null);
            this.setIsEditBook(false);
            EventBus.$emit('getBrandbookList');
        }
    }
}
</script>
