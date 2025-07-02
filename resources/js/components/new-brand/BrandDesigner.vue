<template>
  <section class="align-self-start col-12" id="designer-book" :style="`order:${orderClass}`" v-if="brandbook.user">
    <div class="content">
      <div class="image-group d-flex gap-3 align-items-center">
        <RoundedImage v-if="brandbook.user.avatar_url" :image="brandbook.user.avatar_url" />
        <div class="name-group m-0 fs-14">
            <div class="name fw-bold">{{ brandbook.user.name }}</div>
            {{ brandbook.user.position }}
        </div>
      </div>
      <h1 class="my-4">Brand Book Designer</h1>
      <p v-if="brandbook.user.description">
          {{ brandbook.user.description }}
      </p>
      <div class="footer d-flex gap-4 gap-md-0 flex-wrap justify-content-between mt-4 me-0 me-lg-5">
        <img v-if="brandbook.user.company_logo_full" :src="brandbook.user.company_logo_full" :alt="brandbook.user.company" width="170px" height="42" />
        <p class="d-flex flex-column m-0">
          <span v-if="brandbook.user.company_web"> <a :href="brandbook.user.company_web" target="_blank">{{ brandbook.user.company_web }}</a></span>
          <span v-if="brandbook.user.company_dribble"
            ><svg
              style="width: 15px; height: 15px"
              class="footer-icon"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
            >
              <path
                d="M256 8C119.3 8 8 119.3 8 256s111.3 248 248 248 248-111.3 248-248S392.7 8 256 8zm164 114.4c29.5 36 47.4 82 47.8 132-7-1.5-77-15.7-147.5-6.8-5.8-14-11.2-26.4-18.6-41.6 78.3-32 113.8-77.5 118.3-83.5zM396.4 97.9c-3.8 5.4-35.7 48.3-111 76.5-34.7-63.8-73.2-116.2-79-124 67.2-16.2 138 1.3 190.1 47.5zm-230.5-33.3c5.6 7.7 43.4 60.1 78.5 122.5-99.1 26.3-186.4 25.9-195.8 25.8C62.4 147.2 106.7 92.6 165.9 64.6zM44.2 256.3c0-2.2 0-4.3 .1-6.5 9.3 .2 111.9 1.5 217.7-30.1 6.1 11.9 11.9 23.9 17.2 35.9-76.6 21.6-146.2 83.5-180.5 142.3C64.8 360.4 44.2 310.7 44.2 256.3zm81.8 167.1c22.1-45.2 82.2-103.6 167.6-132.8 29.7 77.3 42 142.1 45.2 160.6-68.1 29-150 21.1-212.8-27.9zm248.4 8.5c-2.2-12.9-13.4-74.9-41.2-151 66.4-10.6 124.7 6.8 131.9 9.1-9.4 58.9-43.3 109.8-90.8 142z"
              />
            </svg>
            <a :href="brandbook.user.company_dribble" target="_blank">{{ brandbook.user.company_dribble }}</a>
          </span>
          <div class="content">
              <WatermarkImage/>
          </div>
          <span v-if="brandbook.user.company_behance"
            ><svg
              style="width: 17px; height: 17px"
              class="footer-icon"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 576 512"
            >
              <path
                d="M232 237.2c31.8-15.2 48.4-38.2 48.4-74 0-70.6-52.6-87.8-113.3-87.8H0v354.4h171.8c64.4 0 124.9-30.9 124.9-102.9 0-44.5-21.1-77.4-64.7-89.7zM77.9 135.9H151c28.1 0 53.4 7.9 53.4 40.5 0 30.1-19.7 42.2-47.5 42.2h-79v-82.7zm83.3 233.7H77.9V272h84.9c34.3 0 56 14.3 56 50.6 0 35.8-25.9 47-57.6 47zm358.5-240.7H376V94h143.7v34.9zM576 305.2c0-75.9-44.4-139.2-124.9-139.2-78.2 0-131.3 58.8-131.3 135.8 0 79.9 50.3 134.7 131.3 134.7 61.3 0 101-27.6 120.1-86.3H509c-6.7 21.9-34.3 33.5-55.7 33.5-41.3 0-63-24.2-63-65.3h185.1c.3-4.2 .6-8.7 .6-13.2zM390.4 274c2.3-33.7 24.7-54.8 58.5-54.8 35.4 0 53.2 20.8 56.2 54.8H390.4z"
              />
            </svg>
            <a :href="brandbook.user.company_behance" target="_blank">{{ brandbook.user.company_behance }}</a>
          </span>
        </p>
        <p class="d-flex flex-column m-0">
          <span v-if="brandbook.user.company_phone || brandbook.user.company_email">Contact</span>
          <span v-if="brandbook.user.company_phone">
            <svg
              style="width: 13px; height: 16px"
              class="footer-icon"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 384 512"
            >
              <path
                d="M16 64C16 28.7 44.7 0 80 0H304c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H80c-35.3 0-64-28.7-64-64V64zM224 448a32 32 0 1 0 -64 0 32 32 0 1 0 64 0zM304 64H80V384H304V64z"
              />
            </svg>
            <a :href="brandbook.user.company_phone">{{ brandbook.user.company_phone }}</a>
          </span>
          <span v-if="brandbook.user.company_email">
            <svg
              style="width: 16px; height: 13px"
              class="footer-icon"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 512 512"
            >
              <path
                d="M64 112c-8.8 0-16 7.2-16 16v22.1L220.5 291.7c20.7 17 50.4 17 71.1 0L464 150.1V128c0-8.8-7.2-16-16-16H64zM48 212.2V384c0 8.8 7.2 16 16 16H448c8.8 0 16-7.2 16-16V212.2L322 328.8c-38.4 31.5-93.7 31.5-132 0L48 212.2zM0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128z"
              />
            </svg>
            <a :href="brandbook.user.company_email">{{ brandbook.user.company_email }}</a></span
          >
        </p>
      </div>
    </div>
  </section>
</template>
<script>
import RoundedImage from './RoundedImage.vue';
import { mapState } from "vuex";
import WatermarkImage from "./WatermarkImage";
export default {
  data(){
    return {
            orderClass: null
        }
  },
  props: { brandbook: Object },
  components:{
    RoundedImage,
    WatermarkImage
  },
  computed: {
      ...mapState(['currentBrandTabs']),
  },
  mounted(){
    this.getOrderClass('brand-designer');
  },
  methods:{
      async getOrderClass(slug){
          const order =  this.currentBrandTabs.findIndex(tab=>(tab.is_default && tab.slug==slug));
          this.orderClass =   order;//`order-${order}`;
      }
  },
  watch: {
    currentBrandTabs: {
        handler(newTabs) {
            this.getOrderClass("brand-designer");
        },
        deep: true,
        immediate: true,
    }
  },
}
</script>
<style scoped>
.footer > p > span {
  display: flex;
  align-items: first baseline;
  gap: 8px;
  font-size: 11px;
  line-height: 1.5;
}
.footer > p > span > a {
  color: inherit;
  text-decoration: none;
}

@media screen and (max-width: 992px) {
  .footer > p > span {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
  }
}
</style>
