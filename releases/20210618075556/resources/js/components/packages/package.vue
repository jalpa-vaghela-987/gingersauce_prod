<template>
  <div class="card text-center" style="height: 350px">
    <div class="card-header" :style="{background: package_item.color}">
      <div
          class="font-weight-bold" style="color: white; font-size: 16px">{{
          package_item.upper_title
        }}
      </div>
    </div>

    <div class="card-body d-flex flex-wrap justify-content-center">
      <div class="package-title">{{ package_item.title }}</div>
      <div class="package-description" v-html="package_item.description"
           style="width: 100%"></div>
      <div class="select-buttons" style="width: 100%">
        <button type="button" class="btn btn-outline-secondary border-radius first"
                :class="{selected : !annual}"
                @click="setMonthly(package_item.alias)"
                v-if="package_item.prolong === 1">{{ translate( 'Monthly' ) }}
        </button>
        <button type="button" class="btn btn-outline-secondary border-radius"
                :class="{selected : annual}"
                @click="setYearly(package_item.alias)"
                v-if="package_item.prolong === 1">{{ translate( 'Yearly' ) }}
        </button>
        <button type="button" class="btn btn-outline-secondary border-radius first"
                :class="{selected : !annual}"
                @click="setMonthly(package_item.alias)"
                v-if="package_item.prolong === 0">{{ translate( '1 Book' ) }}
        </button>
        <button type="button" class="btn btn-outline-secondary border-radius"
                :class="{selected : annual}"
                @click="setYearly(package_item.alias)"
                v-if="package_item.prolong === 0">{{ translate( '10 Books' ) }}
        </button>
      </div>
      <div class="prices" style="width: 100%">
        <span class="crossed">$</span>
        <animated-integer :value="package_item.old_price" :crossed="true"
                          :contr_value="package_item.annual_old_price"
                          :name="package_item.alias"></animated-integer>
        $
        <animated-integer :value="package_item.price" name="books"
                          :name="package_item.alias"
                          :contr_value="package_item.annual_price"></animated-integer>
      </div>

      <form :action="action" method="post" style="margin-top: 30px;" v-if="package_item.prolong === 0 || !has_package">
        <input type="hidden" name="_token" v-bind:value="csrf">
        <input type="hidden" name="package" :value="package_item.id">
        <input type="hidden" name="invoice_type" value="package"/>
        <input type="hidden" name="type" :value="annual ? 1 : 0">
        <button class="btn align-self-end submit-button"
                :style="{background: buttonColor}">{{ translate( 'Buy Now' ) }}
        </button>
      </form>
      <button v-else class="btn align-self-end submit-button" @click="showModal"
              :style="{background: buttonColor}">{{ translate( 'Buy Now' ) }}
      </button>

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
  },
  data() {
    return {
      annual: false,
      csrf  : document.querySelector( 'meta[name="csrf-token"]' ).getAttribute( 'content' ),
    };
  },
  computed: {
    buttonColor() {
      return this.package_item.prolong === 0 ? '#EE6636' : '#29B473';
    },
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
    }
  },
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
  font-size: 36px;
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
