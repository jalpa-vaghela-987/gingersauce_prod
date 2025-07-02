<template>
  <div class="grid-container-clear">
    <div v-for="(cell, index) in cells" :key="index" :class="cell.class">
      <div v-if="cell.type === 'text'"><span v-html="cell.content"></span></div>
      <img v-else :src="icon" class="logo-favicon"  :style="{ backgroundColor: backgroundColor }"/>
    </div>
  </div>
</template>

<script>
export default {
    data() {
    return {
      cells: [
          { type: 'text', content: 'x', class: 'top-left' },
          { type: 'text', content: '', class: '' },
          { type: 'text', content: 'x', class: 'top-right' },
          { type: 'text', content: '', class: '' },
          { type: 'image', class: 'center' }, // Update the path to your image
          { type: 'text', content: '', class: '' },
          { type: 'text', content: 'x', class: 'bottom-left' },
          { type: 'text', content: '', class: '' },
          { type: 'text', content: 'x', class: 'bottom-right' },
      ],
    };
  },
    props: {
        icon: String,
        backgroundColor: String,
        brandbook: Object,
        width: {
            type: Number,
            required: true,
        },
        height: {
            type: Number,
            required: true,
        },
        widthL: {
            type: Number,
            required: true,
        },
        heightL: {
            type: Number,
            required: true,
        },
        freeSpXText: String,
        freeSpYText: String,
        freeSpaceX:String,
        freeSpaceY:String,
        showClearIcon:Boolean
    },
    beforeUpdate() {
        this.cells[0].content = this.freeSpaceX;
        this.cells[2].content = this.freeSpaceY;
        this.cells[6].content = this.freeSpXText;
        this.cells[8].content = this.freeSpYText;
    }
};
</script>
