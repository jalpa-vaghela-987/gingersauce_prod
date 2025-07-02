<template>
  <div class="image rounded-circle">
    <div class="border"></div>
    <img :src="img" alt="User Image" />
  </div>
</template>
<script>
export default {
 props: {
    img: {
      type: String,
      required: false,
    },
  }, 
}
</script>

<style scoped>
.image {
  position: relative;
  overflow: hidden;
  width: 66px;
  height: 66px;
  transition: all 0.5s linear;
  float: left;
  flex-shrink: 0;
  box-sizing: border-box;
  margin: 0 !important;
  display: flex;
}
.image .border {
  width: 110%;
  height: 110%;
  position: absolute;
  z-index: 1;
  box-shadow: 0px 0px 0px 6px rgba(255, 255, 255, 0.1) inset;
  border-radius: 100px;
  left: -5%;
  top: -5%;
}
.image .box > img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 110%;
  height: 110%;
  -o-object-fit: cover;
  object-fit: cover;
  transition: all 0.5s linear;
}
</style>
