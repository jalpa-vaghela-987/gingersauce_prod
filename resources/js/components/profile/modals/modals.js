import translate from '../../../utils/translate';

Vue.component( 'submit-modal', {
    template: `
        <div class="modal" id="vue-submit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">{{ title }}</div>
                <div class="modal-body" v-html="body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn"
                            :class="data_dismiss_class"
                            data-dismiss="modal">{{ button_cancel_text }}
                    </button>
                    <a type="button" class="btn" :class="data_confirm_class"
                       id="confirm-delete-pm"
                       @click="submit">{{ button_submit_text }}</a>
                </div>
            </div>
        </div>
        </div>
    `,
    data() {
        return {
            title             : String,
            body              : String,
            button_submit_text: String,
            button_cancel_text: String,
            action            : String,
            action_id         : String,
            data_dismiss_class: 'btn-danger',
            data_confirm_class: 'btn-outline-secondary',
        };
    },
    mounted() {
        this.$root.$on( 'show-submit-modal', data => {
            this.title = data.title;
            this.body = data.body;
            this.button_cancel_text = data.button_cancel_text;
            this.button_submit_text = data.button_submit_text;
            this.data_dismiss_class = typeof data.button_dismiss_class !==
                                      'undefined'
                                      ? data.button_dismiss_class
                                      : this.data_dismiss_class;
            this.data_confirm_class = typeof data.button_confirm_class !==
                                      'undefined'
                                      ? data.button_confirm_class
                                      : this.data_confirm_class;
            this.action = data.action;
            this.action_id = data.action_id;
            $( '#vue-submit-modal' ).modal( 'show' );
        } );
    },
    methods: {
        submit() {
            this.$root.$emit( this.action, {
                action_id: this.action_id,
            } );
            $( '#vue-submit-modal' ).modal( 'hide' );
        },
    },
} );

Vue.component( 'custom-dropdown', {
    template: `
        <div class="custom-vue-select" :tabindex="tabindex"
             @blur="open = false">
        <div class="selected" :class="{ open: open }" @click="open = !open"
             v-html="selected.value" v-if="selected">
        </div>
        <div class="items" :class="{ selectHide: !open }">
            <div v-for="(option, i) of options" :key="i"
                 @click=" selected = option; open = false; $emit('input', option);"
                 v-html="option.value">
            </div>
        </div>
        </div>
    `,
    props   : {
        options : {
            type    : Array,
            required: true,
        },
        default : {
            type    : String,
            required: false,
            default : null,
        },
        tabindex: {
            type    : Number,
            required: false,
            default : 0,
        },
    },
    data() {
        return {
            selected: this.default
                      ? this.default
                      : (this.options.length > 0
                        ? this.options[ 0 ]
                        : null),
            open    : false,
        };
    },
    mounted() {
        this.$emit( 'input', this.selected );
    },

} );

Vue.component( 'extend-modal', {
    template: `
        <div class="modal" id="vue-extend-book-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">{{ translate( 'Extend date' ) }}</div>
                <div class="modal-body">
                    <div class="modal-text"> {{ translate( 'Great choice!' ) }}
                        <br/><br/>
                        {{
                            translate(
                                'Extend date to ensure that your book will remain online uninterruptedly until the new chosen date.' )
                        }}
                    </div>
                    <div class="book-info row">
                        <div class="col-4"><img :src="preview_src"
                                                class="book-preview"></div>
                        <div class="col-8">
                            <div class="book-info-field">
                                <div class="book-preview-label">{{
                                        translate( 'Book Name' )
                                    }}
                                </div>
                                <div class="book-preview-value">
                                    {{ book.name }}
                                </div>
                            </div>
                            <div class="book-info-field">
                                <div class="book-preview-label">{{
                                        translate( 'Book number' )
                                    }}
                                </div>
                                <div class="book-preview-value">#{{ book.id }}
                                </div>
                            </div>
                            <div class="book-info-field">
                                <div class="book-preview-label">{{
                                        translate( 'Book Expiry Date' )
                                    }}
                                </div>
                                <div class="book-preview-value">
                                    {{ book.expiry }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="extend-select">
                        <div class="select-header">{{
                                translate( 'Choose option:' )
                            }}
                        </div>
                        <custom-dropdown :options="options" v-if="loaded"
                                         @input="extendSelected"></custom-dropdown>
                    </div>
                </div>
                <div class="modal-footer">
                    <form :action="endpoints.form.book_extend"
                          id="extend-book-from" method="post" v-if="book">
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="invoice_type" value="book"/>
                        <input type="hidden" name="book_id" :value="book.id"/>
                        <input type="hidden" name="extend_id"
                               :value="extend_id"/>
                    </form>
                    <button type="button" class="btn btn-danger"
                            @click="extendBook">{{ translate( 'Continue' ) }}
                    </button>
                    <a type="button" class="btn btn-outline-secondary"
                       data-dismiss="modal">{{ translate( 'Cancel' ) }}</a>
                </div>
            </div>
        </div>
        </div>
    `,

    props: {},
    data() {
        return {
            options    : [],
            book       : Object,
            endpoints  : endpoints,
            preview_src: String,
            loaded     : false,
            extend_id  : Number,
            csrf       : document.querySelector( 'meta[name="csrf-token"]' ).
                getAttribute( 'content' ),
        };
    },
    mounted() {
        axios.get( this.endpoints.ajax.get.extends ).then( response => {
            response.data.forEach( element => {
                let value = element.duration + translate( 'year' ) + ' @ $ ' +
                            element.price + ' USD';
                if ( element.save ) {
                    value += '<span class="save-extend" style="color: #EE6636; position: absolute; left: 350px">' +
                             translate( 'Save' ) + ' ' + element.save +
                             '%</span>';
                }
                
                this.options.push( {
                                       id   : element.id,
                                       value: value,
                                   } );
            } );
            this.loaded = true;
        } );
        this.$root.$on( 'show-extend-modal', data => {
            this.book = data.book;
            this.preview_src = data.preview_src;
            $( '#vue-extend-book-modal' ).modal( 'show' );
        } );
    },
    methods: {
        translate,
        extendSelected( data ) {
            this.extend_id = data.id;
        },
        extendBook() {
            $( '#extend-book-from' ).submit();
        },
    },
} );

Vue.component( 'upgrade-plan-modal', {
    template: `
        <div class="modal" id="vue-upgrade-plan-modal">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">{{
                        translate( 'Upgrade Plan' )
                    }}
                </div>
                <div class="modal-body">
                    <div class="body-text">
                        {{
                            translate(
                                'Change plan from Professional to Agency. Instead of receiving 5 books a month you will receive 30 books a month. For this month’s plan you will get 25 books in addition to the initial 5 and we will charge you the difference.' )
                        }}
                    </div>
                    <div class="plans-migration">
                        <div class="plan-container plans-container-left">
                            <div class="plan-header"
                                 :style="{ backgroundColor : package_from.color }">
                                <div class="plan-title-upper">
                                    {{ package_from.name }}
                                </div>
                                <div class="plan-title-lower">
                                    {{ package_from.lower_title }}
                                </div>
                            </div>
                            <div class="plan-body">
                                <div class="plan-sum">{{ package_from.price }}
                                    /month
                                </div>
                                <div class="plan-annually">
                                    {{
                                        annually
                                        ? translate( 'Billed Annually' )
                                        : translate( 'Billed Monthly' )
                                    }}
                                </div>
                                <div class="plan-books"><span
                                    class="books-count">{{ package_from.credits }}</span>
                                    {{ translate( 'Brand Books A Month' ) }}
                                    <br/> ({{ package_from.credits * 12 }}
                                    {{ translate( 'A Year' ) }})
                                </div>
                            </div>
                        </div>
                        <div class="migration-arrow">
                            <svg width="45" height="46" viewBox="0 0 45 46"
                                 fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M24.0575 45.1565L44.1652 25.0348C45.2783 23.909 45.2783 22.0885 44.1652 20.9626L24.0575 0.84095C22.2501 -0.955627 19.1502 0.313954 19.1502 2.87707V14.3752H2.87253C1.28067 14.3752 0 15.6567 0 17.2497V28.7478C0 30.3407 1.28067 31.6223 2.87253 31.6223H19.1502V43.1204C19.1502 45.6955 22.2621 46.9531 24.0575 45.1565Z"
                                    fill="black"/>
                            </svg>
                        </div>
                        <div class="plan-container plans-container-right">
                            <div class="plan-header"
                                 :style="{ backgroundColor : package_to.color }">
                                <div class="plan-title-upper">
                                    {{ package_to.name }}
                                </div>
                                <div class="plan-title-lower">
                                    {{ package_to.lower_title }}
                                </div>
                            </div>
                            <div class="plan-body">
                                <div class="plan-sum">{{ package_to.price }}
                                    /month
                                </div>
                                <div class="plan-annually">
                                    {{
                                        annually
                                        ? translate( 'Billed Annually' )
                                        : translate( 'Billed Monthly' )
                                    }}
                                </div>
                                <div class="plan-books"><span
                                    class="books-count">{{ package_to.credits }}</span>
                                    {{ translate( 'Brand Books A Month' ) }}
                                    <br/> ({{ package_to.credits * 12 }}
                                    {{ translate( 'A Year' ) }})
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form :action="endpoints.form.book_extend"
                          id="upgrade-package-form" method="post">
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="type" :value="annually"/>
                        <input type="hidden" name="invoice_type"
                               value="upgrade"/>
                        <input type="hidden" name="package_from"
                               :value="package_from.id"/>
                        <input type="hidden" name="package_to"
                               :value="package_to.id"/>
                    </form>
                    <button type="button" class="btn btn-danger"
                            @click="upgradeBook">{{ translate( 'Continue' ) }}
                    </button>
                    <a type="button" class="btn btn-outline-secondary"
                       data-dismiss="modal">{{ translate( 'Cancel' ) }}</a>
                </div>
            </div>
        </div>
        </div>
    `,

    props: {
        title             : String,
        body              : String,
        button_submit_text: String,
        button_cancel_text: String,
    },
    data() {
        return {
            package_from: Object,
            package_to  : Object,
            annually    : false,
            endpoints   : endpoints,
            csrf        : document.querySelector( 'meta[name="csrf-token"]' ).
                getAttribute( 'content' ),
        };
    },
    methods: {
        translate,
        upgradeBook() {
            $( '#upgrade-package-form' ).submit();
        },
    },
    mounted() {
        this.$root.$on( 'show-upgrade-modal', data => {
            axios.get( this.endpoints.ajax.get.upgrade_packages ).
                then( response => {
                    response.data.packages.forEach( plan => {
                        if ( plan.title == 'agency' ) {
                            this.package_to = plan;
                        } else {
                            this.package_from = plan;
                        }
                    } );
                    this.annually = response.data.annual;
                    $( '#vue-upgrade-plan-modal' ).modal( 'show' );
                } );
        } );
    },
} );

Vue.component( 'already-have-subscription-modal', {
    template: `
        <div class="modal" id="already-have-subscription">
        <div class="modal-dialog">
            <div class="modal-content" style="padding: 20px">
                <div class="modal-header">{{
                        translate( 'You already have a Subscription' )
                    }}
                </div>
                <div class="modal-body">
                    <div class="body-text">
                        {{
                            translate(
                                'If you need more credits, please refer to our On-demand packs or contact us for larger amounts of books.' )
                        }}
                    </div>
                </div>
                <div class="modal-footer" style="display: block;     text-align: center;">
                    <a type="button" class="btn btn-outline-secondary"
                       data-dismiss="modal" style="width: 300px;    font-size: 18px;    font-weight: bold;    border-radius: 5px;">{{ translate( 'Cancel' ) }}</a>
                </div>
            </div>
        </div>
        </div>
    `,
    methods : {
        translate,
    },
    mounted() {
        this.$root.$on( 'show-have-subscription-modal', data => {
            console.log( 'emited' );
            console.log( data );
            $( '#already-have-subscription' ).modal( 'show' );
        } );
    },
} );




