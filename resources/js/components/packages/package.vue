<template>
  <div class="pricing-card card text-center mx-0">
    <!-- <div class="card-header" :style="{background: package_item.color}">
      <div
          class="font-weight-bold" style="color: white; font-size: 16px">{{
          package_item.upper_title
        }}
      </div>
    </div> -->

    <div class="card-body justify-content-center package-card pt-5 px-12">
      <div class="package-title">{{ package_item.upper_title }}</div>
      <div class="package-description f-13 px-3" v-html="package_item.description"
           style="width: 100%"></div>
      <!-- <div class="select-buttons" style="width: 100%"> -->
        <!-- <button type="button" class="btn btn-outline-secondary border-radius first"
                :class="{selected : !annual}"
                @click="setMonthly(package_item.alias)"
                v-if="package_item.prolong === 1">{{ translate( 'Monthly' ) }}
        </button> -->
          <!-- <button type="button" class="btn btn-outline-secondary border-radius"
                  :class="{selected : annual}"
                  @click="setYearly(package_item.alias)"
                  v-if="package_item.prolong === 1">{{ translate( 'Yearly' ) }}
          </button> -->
        <!-- <button type="button" class="btn btn-outline-secondary border-radius first"
                :class="{selected : !annual}"
                @click="setMonthly(package_item.alias)"
                v-if="package_item.prolong === 0">{{ translate( '1 Book' ) }}
        </button> -->
        <!-- <button type="button" class="btn btn-outline-secondary border-radius"
                :class="{selected : annual}"
                @click="setYearly(package_item.alias)"
                v-if="package_item.prolong === 0">{{ translate( '10 Books' ) }}
        </button> -->
      <!-- </div> -->
      <div class="prices" style="width: 100%">
        <!-- <span class="crossed">$</span>
        <animated-integer :value="package_item.old_price" :crossed="true"
                          :contr_value="package_item.annual_old_price"
                          :name="package_item.alias"></animated-integer> -->
          <div v-if="monthlyPrice">
            $<animated-integer :value="monthlyPrice" name="books"
                            :name="package_item.alias">
            </animated-integer><span class="f-13">/mo
              <p class="fw-500" v-if="package_item.price>0">{{translate("Billed annually. You pay")+' $'+ Math.floor(package_item.price)+' '+translate("today. ")}}</p>
              </span>
          </div>
          <div v-else>
              <span>Free</span>
          </div>
        </div>
        <div :class="`buy-package-block`">
          <form :action="action" method="post" style="margin-top: 30px;" v-if="(package_item.prolong === 0 || !has_package) && package_item.id !=current_package_id && package_item.price > 0">
            <input type="hidden" name="_token" v-bind:value="csrf">
            <input type="hidden" name="package" :value="package_item.id">
            <input type="hidden" name="invoice_type" value="package"/>
            <input type="hidden" name="watermark_book_id" v-model="bookId"/>
            <input type="hidden" name="type" :value="annual ? 1 : 0">

            <button class="btn align-self-end submit-button"
                    :style="{background: buttonColor}">{{ translate( 'Buy Now' ) }}
            </button>
          </form>
          <button v-if="has_package && this.package_item.price !=0 && this.package_item.id ==current_package_id" class="btn align-self-end submit-button" @click="showModal"
          :style="{background: buttonColor}">{{ translate( 'Buy Now' ) }} 
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import translate from '../../utils/translate';

export default {
  name : 'package',
  props: {
    package_item: Object,
    action      : String,
    has_package : Boolean,
    current_package_id: {
      type: Number,
      required:false
    }
  },
  data() {
    return {
      annual: false,
      bookId: false,
      csrf  : document.querySelector( 'meta[name="csrf-token"]' ).getAttribute( 'content' ),
    };
  },
  computed: {
    buttonColor() {
      return (this.has_package && this.package_item.id == this.current_package_id)?'#B2B2B2':'#29B473';
      // return this.package_item.prolong === 0 ? '#EE6636' : '#29B473';
    },
    monthlyPrice() {
        return Math.floor(this.package_item.price / 12);
    }
  },
  methods : {
    translate,
    setMonthly( alias ) {
      this.annual = false;
      this.$root.$emit( 'switch-changed', { state: true, name: alias } );
    },
    setYearly( alias ) {
      this.annual = true;
      this.$root.$emit( 'switch-changed', { state: false, name: alias } );
    },
    showModal(){
      this.$root.$emit('show-have-subscription-modal');
    },
    setBookId(value){
        this.bookId = value
    }
  },
    created() {
        this.$root.$on('fill-value', this.setBookId);
    }
};
</script>

<style lang="scss" scoped>
.card-header {
  min-height: 50px;
}

.package-title {
  font-size: 24px;
  font-weight: bold;
}

.btn-outline-secondary.selected {
  color: #fff;
  background-color: #6c757d;
  border-color: #6c757d;
}

.btn.btn-outline-secondary.border-radius {
  border-radius: 20px;
  padding: 5px 20px;
}

.btn.first {
  margin-right: 20px;
}

.prices {
  font-size: 48px;
}

span.crossed {
  color: #898989;
  font-size: 28px;
  text-decoration: line-through;
}

.submit-button {
  color: white;
  font-size: 14px;
  font-style: normal;
  font-weight: 700;
  line-height: 21px;
  letter-spacing: 0em;
  text-align: center;
}


</style>
