<template>
  <div class="parentClassV3 account-page">
    <AccountHeader />
    <div class="container-fluid">
      <div class="wrapper d-flex align-items-stretch flex-row">
        <AccountSidebar :profile="user"/>
        <AccountMain :brandbooks="brandbooks" v-if="brandbooks.length "/>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
import AccountHeader from './book-v3/AccountHeader.vue';
import AccountMain from './book-v3/AccountMain.vue';
import AccountSidebar from './book-v3/AccountSidebar.vue';
export default {
  data(){
    return {
      author_encrypted_id : null,
      endpoints : endpoints,
      user : null,
      brandbooks:[]
    }
  },
  components:{
    AccountHeader,AccountMain, AccountSidebar
  },
  created(){
    // if(this.$route.params?.id == this.getUser?.id){
    //     window.location.href = '/my';
    // }
    this.author_encrypted_id = this.$route.query?.user_id;
  },
  mounted(){
    this.getData();
  },
  computed:{
    ...mapState(['getLoading','getUser']),
  },
  methods:{
    async getData(){
      try {
        await axios.get( this.endpoints.ajax.get.author.dashboard + '?user_id=' + this.author_encrypted_id ).then( response => {
          const {data}  = response;
          this.user = data.user;
          this.brandbooks = data.books;
        });
      } catch (error) {
        console.log(error);
      }
    }
  }
}
</script>
