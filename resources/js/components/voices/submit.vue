<template>
    <div class="submit-archetype">
        <div class="step-title" style="padding: 45px 0 0 0 !important;">
            {{ this.title }}
        </div>
        <div class="archetype-wrapper" :class="{double : double}">
            <div class="archetype-list" v-if="archetypes.length > 2">
                <div class="archetype-item"  v-for="archetype in archetypes">
                    <span :class="{selected : selected_archetypes.indexOf(archetype) > -1}" @click="triggerArchetype(archetype)">{{ archetype }}</span>
                </div>
            </div>
            <div class="archetype" v-if="selected_archetypes.length" v-for="archetype in selected_archetypes" :class="{ half : archetypes.length === 2}">
                <archetypes-svg :type="archetype" :main_color="main_color" :secondary_color="secondary_color"
                                :key="archetype"></archetypes-svg>
                <div class="archetype-info">
                    <div class="archetype-name">{{ archetype }}</div>
                    <div class="archetype-description">{{ archetypes_list[ archetype ].description }}</div>
                    <div class="archetype-short-description" v-if="selected_archetypes.length===1">{{ shortDescription }}</div>
                </div>
            </div>

            <div class="archetype" v-if="selected_archetypes.length === 0">
                <svg class="arrow" width="94" height="60" viewBox="0 0 94 60" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.710868 11.2736C0.167528 11.8989 0.234018 12.8463 0.859372 13.3897L11.0502 22.2439C11.6755 22.7873 12.6229 22.7208 13.1663 22.0954C13.7096 21.4701 13.6431 20.5227 13.0178 19.9793L3.95929 12.1089L11.8297 3.0504C12.3731 2.42504 12.3066 1.47762 11.6812 0.934281C11.0559 0.390941 10.1085 0.457428 9.56513 1.08278L0.710868 11.2736ZM92.3433 58.7573C93.7117 58.1429 93.7114 58.1424 93.7111 58.1417C93.711 58.1414 93.7106 58.1407 93.7103 58.14C93.7097 58.1386 93.7089 58.1369 93.708 58.1348C93.7061 58.1306 93.7035 58.1249 93.7003 58.1178C93.6938 58.1035 93.6845 58.0833 93.6726 58.0574C93.6487 58.0057 93.6138 57.9311 93.5679 57.8347C93.4762 57.6419 93.3403 57.3621 93.1594 57.0043C92.7976 56.2888 92.2556 55.261 91.5262 53.9935C90.0679 51.4595 87.8579 47.9623 84.8393 44.0857C78.8079 36.3402 69.5095 27.0307 56.482 20.9001L55.2046 23.6146C67.677 29.484 76.6286 38.4244 82.4723 45.9289C85.3911 49.6774 87.5249 53.0552 88.926 55.4899C89.6263 56.7068 90.1428 57.6868 90.4822 58.358C90.6519 58.6936 90.7772 58.9518 90.8591 59.1238C90.9 59.2098 90.93 59.2742 90.9493 59.3159C90.9589 59.3368 90.9659 59.3519 90.9701 59.3613C90.9722 59.3659 90.9737 59.3692 90.9745 59.3709C90.9749 59.3718 90.9751 59.3723 90.9752 59.3724C90.9752 59.3725 90.9751 59.3723 90.9751 59.3723C90.975 59.3721 90.9749 59.3717 92.3433 58.7573ZM56.482 20.9001C43.5215 14.8011 29.8362 12.2739 19.4255 11.2644C14.2133 10.7589 9.80485 10.6324 6.69475 10.6324C5.13932 10.6324 3.90754 10.664 3.0611 10.6959C2.63785 10.7119 2.31086 10.7279 2.08782 10.7401C1.9763 10.7461 1.89076 10.7513 1.83217 10.7549C1.80287 10.7568 1.78031 10.7582 1.76461 10.7593C1.75676 10.7598 1.75061 10.7602 1.74621 10.7605C1.744 10.7607 1.74223 10.7608 1.74088 10.7609C1.74021 10.7609 1.73954 10.761 1.7392 10.761C1.73863 10.761 1.73817 10.7611 1.84318 12.2574C1.94819 13.7537 1.94794 13.7537 1.94781 13.7537C1.94791 13.7537 1.94788 13.7537 1.94808 13.7537C1.94848 13.7537 1.9493 13.7536 1.95056 13.7535C1.95308 13.7534 1.95732 13.7531 1.96326 13.7527C1.97514 13.7519 1.99385 13.7507 2.01926 13.7491C2.07007 13.7459 2.14768 13.7413 2.25113 13.7356C2.45803 13.7243 2.76824 13.7091 3.17409 13.6938C3.98587 13.6632 5.17987 13.6324 6.69476 13.6324C9.7253 13.6324 14.0356 13.7558 19.1359 14.2503C29.3502 15.2408 42.665 17.7136 55.2046 23.6146L56.482 20.9001Z"
                        fill="#D6D6D6"/>
                </svg>
                <archetypes-svg type="empty" :main_color="main_color" :secondary_color="secondary_color"
                                key="empty"></archetypes-svg>
                <div class="archetype-info">
                    <div class="archetype-name">{{ translate( 'None chosen yet.' ) }}</div>
                    <div class="archetype-description"><p class="empty"></p>
                        <p class="empty"></p>
                        <p class="empty"></p>
                        <p class="empty"></p>
                        <p class="empty"></p>
                        <p class="empty"></p>
                        <p class="empty"></p>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="archetype-description-mixed" v-if="selected_archetypes.length === 2">{{ shortDescription }}</div>
        </div>
        <div class="clear"></div>
        <div class="upload-footer">
            <button class="btn btn-outline-secondary" @click="reject" v-if="archetypes.length <= 4">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M15.17 11L21.4244 4.74562C22.1919 3.97812 22.1919 2.73375 21.4244 1.96562L20.0344 0.575625C19.2669 -0.191875 18.0225 -0.191875 17.2544 0.575625L11 6.83L4.74563 0.575625C3.97813 -0.191875 2.73375 -0.191875 1.96563 0.575625L0.575625 1.96562C-0.191875 2.73312 -0.191875 3.9775 0.575625 4.74562L6.83 11L0.575625 17.2544C-0.191875 18.0219 -0.191875 19.2662 0.575625 20.0344L1.96563 21.4244C2.73312 22.1919 3.97813 22.1919 4.74563 21.4244L11 15.17L17.2544 21.4244C18.0219 22.1919 19.2669 22.1919 20.0344 21.4244L21.4244 20.0344C22.1919 19.2669 22.1919 18.0225 21.4244 17.2544L15.17 11Z"/>
                </svg>
                {{ translate( 'Reject' ) }}
            </button>
            <button class="btn btn-outline-success" @click="approve" :disabled="selected_archetypes.length === 0">
                <svg width="28" height="21" viewBox="0 0 28 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M27.2417 4.13797L10.6762 20.5227C10.2246 20.9694 9.49537 20.9665 9.04742 20.5162L0.334063 11.7579C-0.113886 11.3076 -0.111006 10.5804 0.340686 10.1337L2.5213 7.97691C2.9729 7.53027 3.70217 7.53314 4.15012 7.98351L9.88908 13.7522L23.4564 0.333103C23.9079 -0.113543 24.6372 -0.110671 25.0852 0.339612L27.2482 2.5138C27.6962 2.96417 27.6933 3.69133 27.2417 4.13797Z"/>
                </svg>
                {{ translate( 'Approve' ) }}
            </button>
        </div>
    </div>
</template>

<script>
import translate from '../../utils/translate';
import ArchetypesSvg from './svg/archetypes-svg';

export default {
    components: {
        ArchetypesSvg,
    },
    name      : 'submit',
    props     : {
        _archetypes    : Array,
        main_color     : String,
        secondary_color: String,
    },
    data() {
        return {
            archetypes_list    : {
                'The Magician' : {
                    'description'        : 'It is a smart and intelligent archetype, aiming to make all the wishes come true. The Magician brands oftentimes convert their groundbreaking knowledge into innovative technology. Audiences of this type need to be provided with a solution to their problem, or to be in on the secret information.',
                    'short_description_1': 'Think of Nikola Tesla',
                    'short_description_2': 'Disney or Apple.',
                },
                'The Creator'  : {
                    'description'        : 'The Creator are nonconformists, driven by a desire for the self-expression. They have their own vision, and try to create something truly unique. With their project, they aim at uncovering the true potential and creativity of their audience.',
                    'short_description_1': 'Think of Pharrell Williams',
                    'short_description_2': 'Adobe or Lego.',
                },
                'The Ruler'    : {
                    'description'        : 'The Ruler controls everything. They are too responsible, and have too many tasks on their plate. Goods catered to this archetype help balance the pressure, take off some of the tasks, while confirming the status and power of the client.',
                    'short_description_1': 'Think of Angela Merkel',
                    'short_description_2': 'Microsoft or Mercedes-Benz',
                },
                'The Lover'    : {
                    'description'        : 'The Lover brands help their clients to feel special and loved. If the brand puts the pleasure of a client as top priority, the customer will remain forever in love with the company.',
                    'short_description_1': 'Think of Antonio Banderas',
                    'short_description_2': 'Victoria\'s Secret, or Chanel.',
                },
                'The Caregiver': {
                    'description'        : 'The Caregiver is an altruist, driven by the generosity and desire to help others. The brands of this archetype do not just serve, they analyze and take note of their client\'s needs and wishes.',
                    'short_description_1': 'Think of Princess Diana',
                    'short_description_2': 'Johnson’s Baby, or Campbell’s Soup.',
                },
                'The Jester'   : {
                    'description'        : 'Jesters are the brands that laugh in every situation – they are playful and love to break the rules. They entertain their audince, make fun of seriousness, and offer positive experiences to live through.',
                    'short_description_1': 'Think of Jim Carrey',
                    'short_description_2': 'Fanta, or M&M.',
                },
                'The Rebel'    : {
                    'description'        : 'The Rebels believe that there is only one way to change the usual pace of things: through revolutions. Their meaning of life is to destroy something old to give way for something new.',
                    'short_description_1': 'Think of Vivienne Westwood',
                    'short_description_2': 'Harley Davidson, or Diesel.',
                },
                'The Sage'     : {
                    'description'        : 'The Sage want to get at the truth by learning how the world is built. They analyze, structurize and then share everything they have found with their audience. They want people to understand the world better.',
                    'short_description_1': 'Think of Oprah Winfrey',
                    'short_description_2': 'NASA, or The Discovery Channel.',
                },
                'The Explorer' : {
                    'description'        : 'The feeling of the life pulse, new experiences, travel are of the top priority for the Explorer. The fact of the journey means nothing to them, they love the process itself. The brands of this archetype aspire to ditch the norms and indulge in a new adventure.',
                    'short_description_1': 'Think of Elon Musk',
                    'short_description_2': 'Red Bull, or The North Face.',
                },
                'The Hero'     : {
                    'description'        : 'The Hero leads the way. They are impressive in their courage, and always do as they deem right. The Hero is always up for a challenge, and likes to challenge others as well. They fight villains, and aspire to make the world a better place.',
                    'short_description_1': 'Think of Martin Luther King',
                    'short_description_2': 'Nike, or Duracell.',
                },
                'The Everyman' : {
                    'description'        : 'The Everyman hates elitism and poshness. They are simple, wholesome and thinks that everyone in the world is born different. With their cheerful mood, and openness they are a friend, a companion, the guy next door.',
                    'short_description_1': 'Think of Jennifer Aniston',
                    'short_description_2': 'Facebook, or GAP.',
                },
                'The Innocent' : {
                    'description'        : 'The Innocent lives in the utopian world, where they need to be a part of it. They try their best to only do right things, so that they don\'t stand out. Can be easy to start following trends, if there is a chance to improve the world in any way.',
                    'short_description_1': 'Think of Michel Gondry',
                    'short_description_2': 'Coca Cola, or Dove soap.',
                },
            },
            selected_archetypes: [],
            archetypes         : [],
        };
    },
    mounted() {
        if ( this._archetypes.length > 2 ) { // from tags page, dont have certain archetype
            this.archetypes = this._archetypes;
        }

        if ( this._archetypes.length === 0 ) { // from initial select, knows archetype
            Object.keys( this.archetypes_list ).forEach( archetype => {
                this.archetypes.push( archetype );
            } );
        }

        if ( this._archetypes.length > 0 && this._archetypes.length < 3 ) { // from tags page, has match to 1-2 archetypes
            this.archetypes = this._archetypes;
            this.selected_archetypes = this._archetypes;
        }
    },
    methods : {
        translate,
        triggerArchetype(archetype){
            let index = this.selected_archetypes.indexOf(archetype);
            console.log(index);
            if(index > -1){
                this.selected_archetypes.splice(index, 1);
            } else if(index === -1 && this.selected_archetypes.length < 2){
                this.selected_archetypes.push(archetype);
            }
        },
        reject(){
            this.selected_archetypes = [];
            this.archetypes = [];
            Object.keys( this.archetypes_list ).forEach( archetype => {
                this.archetypes.push( archetype );
            } );
        },
        approve(){
            this.$emit('forward', this.selected_archetypes);
        }
    },
    computed: {
        shortDescription() {
            if ( this.selected_archetypes.length === 1 ) {
                return this.archetypes_list[ this.selected_archetypes[ 0 ] ].short_description_1 +
                       ', ' + this.archetypes_list[ this.selected_archetypes[ 0 ] ].short_description_2;
            } else if ( this.selected_archetypes.length === 2 ) {
                return this.archetypes_list[ this.selected_archetypes[ 0 ] ].short_description_1 +
                       ' meets ' + this.archetypes_list[ this.selected_archetypes[ 1 ] ].short_description_2;
            }
        },
        title() {
            if ( this.selected_archetypes.length === 1 ) {
                return this.translate( 'Your Archetype is' );
            } else if ( this.selected_archetypes.length === 2 ) {
                return this.translate( 'Your Brand is a Mix of 2 Archetypes' );
            } else if ( this.selected_archetypes.length === 0 && this.archetypes.length <= 4 ) {
                return this.translate( 'Choose 1-2 archetypes out of the few you landed on' );
            } else if ( this.selected_archetypes.length === 0 && this.archetypes.length > 4 ) {
                return this.translate( 'Choose up to 2 Archetypes' );
            }
        },
        double() {
            return this.selected_archetypes.length === 2;
        },
    },
};
</script>

<style lang="scss">
.submit-archetype {
    .archetype-wrapper {
        width: 90%;
        border: 1px solid #E4E4E4;
        margin: auto;
        height: 330px;
        margin-top: 20px;

        .archetype-item {
            margin-bottom: 3px;
        }

        .arrow {
            margin-top: 50px;
            float: left;
        }


        .svg-archetype {
            margin-left: 20px;
            margin-top: 33px;
            float: left;
        }

        .archetype-name {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
        }

        .archetype-info {
            float: left;
            padding: 50px 0;
            width: 55%;
            .archetype-description p{
                background: #E4E4E4;
                display: block;
                width: 100%;
                height: 10px;
                margin-bottom: 10px;
            }
        }

        .archetype-short-description {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }

        .svg-archetype.not-empty {
            width: 20%;
        }

        .svg-archetype.not-empty svg{
            width: 100%;
        }




        .double{
            .archetype{

            }
        }

        .archetype-list {
            width: 15%;
            float: left;
            padding: 10px;
            min-width: 150px;

            .archetype-item {
                span {
                    border: 1px solid #000000;
                    padding: 2px 10px;
                    border-radius: 13px;
                    cursor: pointer;
                }
                span.selected {
                    background: var(--main_color);
                    border-color: var(--main_color);
                    color: white;
                    font-weight: bold;
                }
            }
        }
    }

    .clear{
        clear: both;
    }

    .archetype-description-mixed{
        text-align: center;
        font-weight: bold;
        font-size: 16px;
        position: relative;
        top: -43px;
    }

    .double .archetype {
        width: 40%;
        float: left;
        position: relative;
        padding: 0 30px;

        .archetype-info {
            width: 100%;
        }

        .svg-archetype.not-empty {
            position: absolute;
            top: 0;
            right: 30px;
            float: none;
            height: auto;

            svg {
                height: 50px;
            }
        }
    }

    .double .archetype.half{
        width: 50%;
    }
}
</style>
