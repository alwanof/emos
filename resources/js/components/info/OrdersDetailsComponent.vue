<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">{{ local[lang+".info"]["orders_spotlight"] }}</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-sm-3 col-6">
            <div class="description-block border-right">
              <span class="description-percentage text-danger">
                <i class="fas fa-concierge-bell"></i>
                {{orders.yesterday}}
              </span>
              <h5 class="description-header">{{ coin }}{{orders.incomeYesterday}}</h5>
              <span class="description-text">{{ local[lang+".info"]["yesterday"] }}</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-6">
            <div class="description-block border-right">
              <span class="description-percentage text-danger">
                <i class="fas fa-concierge-bell"></i>
                {{orders.lastweak}}
              </span>
              <h5 class="description-header">{{ coin }}{{orders.incomeLastwaek}}</h5>
              <span class="description-text">{{ local[lang+".info"]["lastweak"] }}</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-6">
            <div class="description-block border-right">
              <span class="description-percentage text-danger">
                <i class="fas fa-concierge-bell"></i>
                {{orders.lastmonth}}
              </span>
              <h5 class="description-header">{{ coin }}{{orders.incomeLastmonth}}</h5>
              <span class="description-text">{{ local[lang+".info"]["lastmonth"] }}</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-3 col-6">
            <div class="description-block">
              <span class="description-percentage text-danger">
                <i class="fas fa-concierge-bell"></i>
                {{orders.lastyear}}
              </span>
              <h5 class="description-header">{{ coin }}{{orders.incomeLastyear}}</h5>
              <span class="description-text">{{ local[lang+".info"]["lastyear"] }}</span>
            </div>
            <!-- /.description-block -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CONFIG from "../../app";

export default {
  name: "OrdersDetailsComponent",
  props: ["auth", "lang", "coin"],
  data() {
    return {
      path: CONFIG.PATH,
      loading: false,
      local: CONFIG.LANG,
      orders: {
        yesterday: 0,
        lastweak: 0,
        lastmonth: 0,
        lastyear: 0,
        incomeYesterday: 0,
        incomeLastwaek: 0,
        incomeLastmonth: 0,
        incomeLastyear: 0,
        amountYesterday: 0,
        amountLastwaek: 0,
        amountLastmonth: 0,
        amountLastyear: 0,
        percYesterday: 0,
        percLastweak: 0,
        percLastmonth: 0,
        percLastyear: 0,
      },
      errors: [],
    };
  },
  created() {
    this.loading = true;

    const today = new Date();
    const now = today.getTime() / 1000;




    CONFIG.DB.collection("orders")
      .where("user.email", "==", this.auth.email) //this.auth.email
      .get()
      .then((snapshot) => {

        snapshot.forEach((doc) => {
          const firebaseDate = new Date(
            doc.data().timestamp.toDate()
          ).toDateString();

          //console.log(firebaseDate);


          const datePoint = new Date(firebaseDate).getTime() / 1000;



          if (now - datePoint > 86400 && now - datePoint < 172800) {
            this.orders.yesterday++;

            doc.data().items.forEach((item) => {
              this.orders.amountYesterday = this.orders.amountYesterday + item.amount;
              this.orders.incomeYesterday = this.orders.incomeYesterday + item.subTotal;
            });


          }
          if (now - datePoint < 604800) {
            this.orders.lastweak++;

            doc.data().items.forEach((item) => {
              this.orders.amountLastwaek = this.orders.amountLastwaek + item.amount;
              this.orders.incomeLastwaek = this.orders.incomeLastwaek + item.subTotal;
            });

          }
          if (now - datePoint < 2592000) {
            this.orders.lastmonth++;
            doc.data().items.forEach((item) => {

              this.orders.amountLastmonth = this.orders.amountLastmonth + item.amount;
              this.orders.incomeLastmonth = this.orders.incomeLastmonth + item.subTotal;
            });
          }
          if (now - datePoint < 31449600) {
            this.orders.lastyear++;
            doc.data().items.forEach((item) => {
              this.orders.amountLastyear = this.orders.amountLastyear + item.amount;
              this.orders.incomeLastyear = this.orders.incomeLastyear + item.subTotal;
            });
          }
        });

        this.loading = false;
      });
  },

  methods: {},
};
</script>

<style scoped>
</style>
