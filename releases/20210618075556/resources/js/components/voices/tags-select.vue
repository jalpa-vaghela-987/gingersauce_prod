<template>
    <div class="tags">
        <div class="step-title" style="padding: 45px 0 0 0 !important;">
            {{ translate( 'Choose 6 to 8 Adjectives that Best Describe Your Brand' ) }}
        </div>
        <div class="tag-wrap">
            <div class="selected-tags">
                <span v-for="(item, index) in selected_default"
                      :class="{selected : typeof selected[index] !== 'undefined' }"
                      :key="index">{{
                        typeof selected[ index ] !== 'undefined' ? selected[ index ] : '   css is shit'
                    }}</span>
            </div>
            <div class="tag-container">
                <span v-for="tag in allTagsArr" class="voice-tag"
                      :class="{selected : selected.indexOf(tag) > -1}"
                      @click="triggerTag(tag)">{{ tag }}</span>
            </div>
        </div>
        <div class="upload-footer">
            <button :disabled="selected.length < 6" class="btn btn-outline-success"
                    @click="approveTags">
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

export default {
    name : 'tags-select',
    props: {},
    data() {
        return {
            selected        : [],
            selected_default: [ 1, 2, 3, 4, 5, 6, 7, 8 ],
            all_tags        : {
                'The Magician' : [ 'Mysterious', 'Imaginative', 'Visionary', 'Сharismatic' ],
                'The Creator'  : [ 'Creative', 'Slightly provocative', 'Enthusiastic', 'Authentic', 'Perfectionist' ],
                'The Ruler'    : [ 'Refined', 'Commanding', 'Articulate', 'Higher class' ],
                'The Jester'   : [ 'Fun', 'Light-hearted', 'Mischievous', 'Irreverent', 'Playful', 'Optimistic' ],
                'The Sage'     : [
                    'Knowledgeable',
                    'Trustworthy',
                    'Thoughtful',
                    'Analytical',
                    'Mentor',
                    'Guru',
                    'Advisor' ],
                'The Explorer' : [
                    'Restless',
                    'Adventurous',
                    'Ambitious',
                    'Individualistic',
                    'Independent',
                    'Pioneering' ],
                'The Lover'    : [ 'Passionate', 'Sensual', 'Romantic', 'Committed', 'Idealistic' ],
                'The Caregiver': [ 'Caring', 'Maternal', 'Nurturing', 'Generous', 'Compassionate', 'Warm' ],
                'The Everyman' : [
                    'Down to earth',
                    'Supportive',
                    'Faithful',
                    'Folksy',
                    'Person next door',
                    'Connects with others' ],
                'The Innocent' : [ 'Strives to be good', 'Pure', 'Young', 'Simple', 'Loyal' ],
                'The Rebel'    : [
                    'Rebellious',
                    'Wild',
                    'Paving the way for change',
                    'Free-spirited',
                    'Counter-cultural' ],
                'The Hero'     : [ 'Courageous', 'Bold', 'Honorable', 'Strong', 'Confident', 'Inspirational' ],
            },
        };
    },
    methods : {
        translate,
        selectedTag( index ) {
            return typeof this.selected[ index ] !== 'undefined';
        },
        triggerTag( tag ) {
            let index = this.selected.indexOf( tag );
            if ( index !== -1 ) {
                this.selected.splice( index, 1 );
            } else if ( this.selected.length < 8 ) {
                this.selected.push( tag );
            }
        },
        approveTags() {
            let matches = {};
            Object.keys( this.all_tags ).forEach( key => {
                this.selected.forEach( tag => {
                    if ( this.all_tags[ key ].indexOf( tag ) > -1 ) {
                        if ( typeof matches[ key ] === 'undefined' ) {
                            matches[ key ] = 1;
                        } else {
                            matches[ key ]++;
                        }
                    }
                } );
            } );

            let sure_selected_archetypes = [];
            let not_sure_selected = [];
            Object.keys( matches ).forEach( archetype => {
                if ( matches[ archetype ] >= 3 ) {
                    sure_selected_archetypes.push( archetype );
                }
                if ( matches[ archetype ] < 3 && not_sure_selected.length < 4 ) {
                    not_sure_selected.push( archetype );
                }
            } );

            if ( sure_selected_archetypes.length ) {
                this.$emit( 'submit', sure_selected_archetypes );
            } else {
                this.$emit( 'submit', not_sure_selected );
            }
        },
    },
    computed: {
        allTagsArr: function() {
            let allTags = [];
            Object.keys( this.all_tags ).forEach( key => {
                this.all_tags[ key ].forEach( tag => {
                    allTags.push( tag );
                } );
            } );
            return allTags;
        },
    },
};
</script>

<style scoped lang="scss">
.tags {
    .tag-wrap {
        padding: 20px 50px;

        .voice-tag {
            border-radius: 12px;
            display: inline-block;
            border: 1px solid black;
            padding: 2px 10px;
            margin-right: 10px;
            cursor: pointer;
            margin-top: 15px;
        }

        .selected-tags span {
            border-radius: 12px;
            display: inline-block;
            border: 1px solid black;
            min-width: 11%;
            margin-right: 10px;
            color: white;
        }

        .selected-tags span.selected, .voice-tag.selected {
            background: var(--main_color);
            border-color: var(--main_color);
            color: white;
        }

        .selected-tags span.selected {
            min-width: unset;
            padding: 2px 10px;
            font-size: 12px;
        }

        .tag-container {
            height: 240px;
            overflow-y: scroll;
            border: 1px solid #999999;
            padding-bottom: 20px;
            padding-left: 20px;
            margin-top: 20px;
        }
    }
}
</style>
