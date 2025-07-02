<template>
    <div class="col-9 d-md-flex flex-column flex-grow-1 ms-auto" id="main-book" ref="mainBook" v-if="brandbook">
        <ZeroLine v-if="brandbook.logo_b64" :mockups="brandbook.mockups" :logo="brandbook.logo_b64" class="d-flex d-xl-none masonry-item"/>
        <FirstLine v-if="!isMobile" :approved="brandbook.approved"
                   :logo="brandbook"
                   :approved_icon="brandbook.approved_icon"
                   :icon_b64="brandbook.icon_b64"
                   :mockups="brandbook.mockups"/>
        <template v-else>
            <FirstLine
                v-for="(block, index) in blocksFirstLine"
                :key="`${index}-FirstLine`"
                :block-index="index"
                class="masonry-item"
                :logo="brandbook"
                :approved="brandbook.approved"
                :approved_icon="brandbook.approved_icon"
                :icon_b64="brandbook.icon_b64"
                :mockups="brandbook.mockups"
            />
        </template>

        <ColorLine :colors="colors()" class="masonry-item"/>
        <ThirdLine v-if="!isMobile && brandbook" :brandbook="brandbook"/>
        <template v-if="isMobile && brandbook" :brandbook="brandbook">
            <ThirdLine
                v-for="(block, index) in blocks"
                :key="`${index}-ThirdLine`"
                :block-index="index"
                class="masonry-item"
                :brandbook="brandbook"
            />
        </template>
        <IconsLine v-if="Array.isArray(brandbook.icon_family) && brandbook.icon_family.length > 0" class="masonry-item" :icon_family="brandbook.icon_family"/>
        <SimpleLine v-if="!isMobile && Array.isArray(brandbook.graphic_element) && brandbook.graphic_element.length > 0"
                    :graphicElement="brandbook.graphic_element"/>
        <template v-if="isMobile && Array.isArray(brandbook.graphic_element) && brandbook.graphic_element.length > 0">
            <SimpleLine
                v-for="(block, index) in blocksSimpleLine"
                :key="`${index}-SimpleLine`"
                :block-index="index"
                class="masonry-item"
                :graphicElement="brandbook.graphic_element"
            />
        </template>
        <LogoSizes v-if="brandbook.logo_h" :brandbook="brandbook" class="masonry-item"/>
        <MisuseLine :missuses="brandbook.missuses" class="masonry-item"/>
        <VisionMissionLine v-if="(brandbook.vision && brandbook.vision.trim() !== '') || (brandbook.mission && brandbook.mission.trim() !== '')" :vision="brandbook.vision" :mission="brandbook.mission" class="masonry-item"/>
        <CoreValuesLine v-if="Array.isArray(brandbook.core_values) && brandbook.core_values.length > 0" :coreValues="brandbook.core_values" class="masonry-item"/>
        <BrandArchetype v-if="Array.isArray(brandbook.brand_archetype) && brandbook.brand_archetype.length > 0" :archetypes="brandbook.brand_archetype" class="masonry-item"/>

        <BrandDesigner :user="brandbook.user" class="masonry-item d-flex d-xl-none w-100"/>
        <DownloadModal :title="modalTitle" :items="items" :isLogoVersions="isLogoVersions"/>
    </div>
</template>
<script>

    import {onMounted, ref, nextTick} from 'vue';
    import { EventBus } from '../../../event-bus';
    import FirstLine from '../Chapters/FirstLine.vue';
    import ColorLine from '../Chapters/ColorLine.vue';
    import ThirdLine from '../Chapters/ThirdLine.vue';
    import IconsLine from '../Chapters/IconsLine.vue';
    import DownloadModal from '../Modal/DownloadModal.vue';
    import SimpleLine from '../Chapters/SimpleLine.vue';
    import LogoSizes from '../Chapters/LogoSizes.vue';
    import MisuseLine from '../Chapters/MisuseLine.vue';
    import VisionMissionLine from '../Chapters/VisionMissionLine.vue';
    import CoreValuesLine from '../Chapters/CoreValuesLine.vue';
    import BrandArchetype from '../Chapters/BrandArchetype.vue';
    import ZeroLine from '../Chapters/ZeroLine.vue';
    import BrandDesigner from '../new-book/sidebar/BrandDesigner.vue';

    export default {
        props: {
            brandbook: {
                type: Object,
                default: () => ({
                    approved_icon: [], // Add default values for missing fields
                    icon_b64: '',
                    mockups: [],
                })
            },
        },
        components: {
            FirstLine,
            ColorLine,
            ThirdLine,
            IconsLine,
            DownloadModal,
            SimpleLine,
            LogoSizes,
            MisuseLine,
            VisionMissionLine,
            CoreValuesLine,
            BrandArchetype,
            ZeroLine,
            BrandDesigner
        },
        data() {
            return {
                windowWidth: window.innerWidth,
                blocks: [0, 1, 2, 3],
                blocksSimpleLine: [0, 1, 2],
                blocksFirstLine: [0, 1, 2],
                colorsLineRows: 1,
                modalTitle: '',
                items: [],
                isLogoVersions: false
            };
        },
        computed: {
            isMobile() {
                return this.windowWidth <= 768;
            },
        },
        mounted() {
            this.$nextTick(() => {
                const images = document.querySelectorAll('img');
                let loadedCount = 0;
                const totalImages = images.length;

                if (totalImages === 0) {
                    this.startTimer();
                    return;
                }

                images.forEach(img => {
                    img.addEventListener('load', () => {
                        loadedCount++;
                        if (loadedCount === totalImages) {
                            this.startTimer();
                        }
                    });
                    if (img.complete) {
                        loadedCount++;
                        if (loadedCount === totalImages) {
                            this.startTimer();
                        }
                    }
                });
            });
            EventBus.$on('show-modal', this.showModal);
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.handleResize);
            window.removeEventListener('resize', this.updateGridRows);
        },
        methods: {
            startTimer() {
                setTimeout(() => {
                    //console.log('Timer triggered after content load');
                    this.updateGridRows();
                }, 100);
                window.addEventListener('resize', this.updateGridRows);
                window.addEventListener('resize', this.handleResize);
            },
            handleResize() {
                this.windowWidth = window.innerWidth;
            },
            addFullWidthAfterSum(n) {
                const items = document.querySelectorAll('#main-book > .masonry-item');
                let rowSum = 0;
                let startIndex = -1;

                let number = 0;

                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    const computedStyle = window.getComputedStyle(item);
                    if (!item.classList.contains('colors-line') && !item.classList.contains('icons-line')) {
                        const spanValue = parseInt(computedStyle.getPropertyValue('grid-row-end').split(' ')[1]);

                        rowSum += spanValue;
                    }
                    if (rowSum >= n && startIndex === -1) {
                        number = rowSum;
                        startIndex = i + 1;
                    }
                }

                if (startIndex !== -1 && startIndex < items.length) {
                    for (let i = startIndex; i < items.length; i++) {
                        items[i].classList.add('full-width-masonry');
                    }

                    if (document.querySelectorAll('#main-book > .icons-line').length) {
                        document.querySelectorAll('#main-book > .icons-line')[0].style.gridRowStart = `${
                            this.colorsLineRows ? this.colorsLineRows : 1
                        }`;
                        document.querySelectorAll('#main-book > .icons-line')[0].style.gridRowEnd = `${number}`;
                    }
                }
            },
            updateGridRows() {
                //console.log('called the updateGridRows method');
                const items = document.querySelectorAll('#main-book > .masonry-item');
                const rowHeight = 2;
                const rowGap = 0;
                //console.log(items);
                items.forEach(item => {
                    const itemHeight = item.getBoundingClientRect().height;
                    // console.log('called the itemHeight from foreach...'+ itemHeight);
                    // console.log(item.childNodes);
                    const rowSpan = Math.ceil(itemHeight / (rowHeight + rowGap));
                    item.style.gridRowEnd = `span ${rowSpan}`;
                    //console.log('called the updateGridRows from foreach...'+ rowSpan + 'gird end' + item.style.gridRowEnd);

                });

                document.getElementById('main-book').style.display = 'grid';

                const getRowSpan = element => {
                    if (!element) return 0;
                    const computedStyle = getComputedStyle(element);
                    const gridRowStart = parseInt(computedStyle.gridRowStart) || 1;
                    const gridRowEndStr = computedStyle.gridRowEnd;
                    let gridRowEnd;
                    if (gridRowEndStr.startsWith('span')) {
                        const spanValue = parseInt(gridRowEndStr.replace('span', '').trim());
                        gridRowEnd = gridRowStart + spanValue;
                    } else if (gridRowEndStr === 'auto' || !gridRowEndStr) {
                        gridRowEnd = gridRowStart + 1;
                    } else {
                        gridRowEnd = parseInt(gridRowEndStr);
                    }

                    return gridRowEnd - gridRowStart;
                };

                const colorsLine = document.querySelector('.colors-line');
                const iconsLine = document.querySelector('.icons-line');

                const colorsLineRows = getRowSpan(colorsLine);
                this.colorsLineRows = getRowSpan(colorsLine);
                const iconsLineRows = getRowSpan(iconsLine);

                let totalRows;
                if (colorsLine && iconsLine) {
                    totalRows = colorsLineRows + iconsLineRows;
                } else if (colorsLine) {
                    totalRows = colorsLineRows;
                } else if (iconsLine) {
                    totalRows = iconsLineRows;
                } else {
                    totalRows = 0;
                }
                this.addFullWidthAfterSum(totalRows);
            },
            colors(){
                return this.brandbook.colors_list?.map(item => item.id) || [];
            },
            showModal(payload){
                this.resetModalAttributes();
                this.items = payload.items;
                this.modalTitle = payload.title;
                this.isLogoVersions = payload.isLogoVersions || false;
            },
            resetModalAttributes(){
                this.items = [];
                this.modalTitle = '';
                this.isLogoVersions = false;
            }
        },
    };
</script>
