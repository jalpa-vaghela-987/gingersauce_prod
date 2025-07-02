<template>
  <aside
    class="is_expanded fixed-top flex-shrink-0 px-0 d-flex"
    id="account-sidebar"
  >
    <div class="account-sidebar d-flex flex-column">
      <div v-if="profile?.location" class="location">{{$_.startCase(profile?.location)??'N/A'}}</div>
      <div class="designer-info d-flex flex-column">
        <div v-if="profile?.avatar || profile?.avatar_url" class="photo d-flex">
          <RoundedImage style="width: 115px; height: 115px" :img="profile?.avatar?profile?.avatar_url:null"/>
        </div>
        <div v-if="profile?.name" class="name mt-3 mb-0 fw-bold fs-14 text-black">{{ profile?.name??'N/A' }}</div>
        <div v-if="profile?.position" class="position fs-14 text-black mt-0">{{profile?.position??'N/A'}}</div>
      </div>
      <div v-if="profile?.description" class="detail-info fs-12 mt-22">
        {{profile?.description??'N/A'}}
      </div>
      <div class="contact-block mt-37">
        <span class="fs-12" v-if="profile?.company_web">{{profile?.company_web??'N/A'}}</span>
        <span v-if="profile?.company_dribble" class="d-flex align-items-center gap-2 fs-12"
          ><svg
            height="11"
            width="11"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512"
          >
            <path
              d="M256 8C119.3 8 8 119.3 8 256s111.3 248 248 248 248-111.3 248-248S392.7 8 256 8zm164 114.4c29.5 36 47.4 82 47.8 132-7-1.5-77-15.7-147.5-6.8-5.8-14-11.2-26.4-18.6-41.6 78.3-32 113.8-77.5 118.3-83.5zM396.4 97.9c-3.8 5.4-35.7 48.3-111 76.5-34.7-63.8-73.2-116.2-79-124 67.2-16.2 138 1.3 190.1 47.5zm-230.5-33.3c5.6 7.7 43.4 60.1 78.5 122.5-99.1 26.3-186.4 25.9-195.8 25.8C62.4 147.2 106.7 92.6 165.9 64.6zM44.2 256.3c0-2.2 0-4.3 .1-6.5 9.3 .2 111.9 1.5 217.7-30.1 6.1 11.9 11.9 23.9 17.2 35.9-76.6 21.6-146.2 83.5-180.5 142.3C64.8 360.4 44.2 310.7 44.2 256.3zm81.8 167.1c22.1-45.2 82.2-103.6 167.6-132.8 29.7 77.3 42 142.1 45.2 160.6-68.1 29-150 21.1-212.8-27.9zm248.4 8.5c-2.2-12.9-13.4-74.9-41.2-151 66.4-10.6 124.7 6.8 131.9 9.1-9.4 58.9-43.3 109.8-90.8 142z"
            />
          </svg>
          {{profile?.company_dribble??'N/A'}}</span
        >
        <span v-if="profile?.company_behance" class="d-flex align-items-center gap-2 fs-12"
          ><svg
            height="11"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 576 512"
          >
            <path
              d="M232 237.2c31.8-15.2 48.4-38.2 48.4-74 0-70.6-52.6-87.8-113.3-87.8H0v354.4h171.8c64.4 0 124.9-30.9 124.9-102.9 0-44.5-21.1-77.4-64.7-89.7zM77.9 135.9H151c28.1 0 53.4 7.9 53.4 40.5 0 30.1-19.7 42.2-47.5 42.2h-79v-82.7zm83.3 233.7H77.9V272h84.9c34.3 0 56 14.3 56 50.6 0 35.8-25.9 47-57.6 47zm358.5-240.7H376V94h143.7v34.9zM576 305.2c0-75.9-44.4-139.2-124.9-139.2-78.2 0-131.3 58.8-131.3 135.8 0 79.9 50.3 134.7 131.3 134.7 61.3 0 101-27.6 120.1-86.3H509c-6.7 21.9-34.3 33.5-55.7 33.5-41.3 0-63-24.2-63-65.3h185.1c.3-4.2 .6-8.7 .6-13.2zM390.4 274c2.3-33.7 24.7-54.8 58.5-54.8 35.4 0 53.2 20.8 56.2 54.8H390.4z"
            />
          </svg>
          {{profile?.company_behance??'N/A'}}</span
        >
        <span class="fs-12" v-if="profile?.company_phone || profile?.email">Contact</span>
        <span v-if="profile?.company_phone" class="d-flex align-items-center gap-2 fs-12"
          ><svg
            width="7"
            height="11"
            viewBox="0 0 7 11"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M5.59842 0.109375H1.25657C0.742912 0.109375 0.326172 0.532627 0.326172 1.05431V9.24374C0.326172 9.76542 0.742912 10.1887 1.25657 10.1887H5.59842C6.11208 10.1887 6.52882 9.76542 6.52882 9.24374V1.05431C6.52882 0.532627 6.11208 0.109375 5.59842 0.109375ZM3.42749 9.55871C3.08441 9.55871 2.80723 9.2772 2.80723 8.92876C2.80723 8.58031 3.08441 8.2988 3.42749 8.2988C3.77058 8.2988 4.04776 8.58031 4.04776 8.92876C4.04776 9.2772 3.77058 9.55871 3.42749 9.55871ZM5.59842 7.43261C5.59842 7.56254 5.49375 7.66885 5.36582 7.66885H1.48917C1.36124 7.66885 1.25657 7.56254 1.25657 7.43261V1.29054C1.25657 1.16061 1.36124 1.05431 1.48917 1.05431H5.36582C5.49375 1.05431 5.59842 1.16061 5.59842 1.29054V7.43261Z"
              fill="black"
            />
          </svg>
          {{profile?.company_phone??'N/A'}}</span
        >
        <span v-if="profile?.email" class="d-flex align-items-center gap-2 fs-12"
          ><svg
            width="11"
            height="12"
            viewBox="0 0 11 12"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <g clip-path="url(#clip0_53_296)">
              <path
                d="M9.837 9.66431H1.01762C0.455597 9.66431 0 9.20871 0 8.64669V2.54096C0 1.97893 0.455597 1.52334 1.01762 1.52334H9.837C10.399 1.52334 10.8546 1.97893 10.8546 2.54096V8.64669C10.8546 9.20871 10.399 9.66431 9.837 9.66431ZM9.837 8.64669V7.7816C9.36165 7.3945 8.60382 6.79258 6.9837 5.52397C6.62666 5.24312 5.91942 4.56842 5.42731 4.57629C4.93529 4.56834 4.22781 5.24323 3.87092 5.52397C2.25106 6.79239 1.49304 7.39444 1.01762 7.7816V8.64669H9.837ZM1.01762 2.54096V6.4758C1.50341 6.08887 2.19232 5.54591 3.24235 4.72367C3.70573 4.35892 4.51722 3.5537 5.42731 3.5586C6.33293 3.5537 7.13414 4.34724 7.61208 4.7235C8.6621 5.54572 9.3512 6.08883 9.837 6.47578V2.54096H1.01762Z"
                fill="black"
              />
            </g>
            <defs>
              <clipPath id="clip0_53_296">
                <rect
                  width="10.8546"
                  height="10.8546"
                  fill="white"
                  transform="matrix(1 0 0 -1 0 11.0215)"
                />
              </clipPath>
            </defs>
          </svg>
          {{profile?.email??'N/A'}}</span
        >
      </div>
      <div v-if="profile?.company_logo_full" class="mt-auto mx-auto logo-below">
        <img :src="profile?.company_logo_full" alt="" class="img-fluid"/>
      </div>
    </div>
  </aside>
</template>

<script>
import RoundedImage from "./RoundedImage.vue";

export default {
  components: { RoundedImage },
  props: {
    profile: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {};
  },
};
</script>
