<template>
    <a class="dropdown-item" @click.prevent="share" href="#"><i class="fas fa-share-square"></i> 
    {{ translate('Share') }}</a>
</template>
<script>
import translate from "../utils/translate";
export default {
    props: {
        id: String,
        status: String
    },
    data() {
        return {
            is_public: Boolean
        }
    },
    mounted() {
        var self = this;
        this.is_public = this.status == 'public';

        $('#confirm-share').on('click', function () {
            var $modal = $('#modal-confirm-share');
            var id = $modal.find('#id').val();
            console.log('modal id', id);
            if (parseInt(id) === parseInt(self.id)) {
                $('#modal-share').modal('show')
                self.$root.$emit('share', {id: self.id, data: {id: self.id}})
                $('#modal-confirm-share').modal('hide');
            }
        });

        this.$root.$on('book-shared', (data) => {
            if (parseInt(this.id) === parseInt(data.id)) {
                $('*[data-book-id="'+this.id+'"]').show();
                this.is_public = true;
            }
        });
    },
    methods: {
        translate,
        share() {
            if (!this.is_public) {
                var modal = $('#modal-confirm-share');
                modal.find('#id').val(this.id);
                modal.modal('show');
            } else {
                $('#modal-share').modal('show')
                this.$root.$emit('share', {id: this.id, data: {id: this.id}})
            }
        }
    }
}
</script>
