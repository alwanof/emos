<template>
  <div>
    <table class="table table-striped mt-5">
      <thead>
        <tr>
          <th>S.No.</th>
          <th>Menu</th>
          <th>U. Price</th>
          <th>QTY</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in order.items" :key="index">
          <td>{{ index }}</td>
          <td>{{ item.title }}</td>
          <td>{{ item.price }}</td>
          <td>{{ item.amount }}</td>
          <td>{{ item.price * item.amount }} {{ actor.currency }}</td>
        </tr>
      </tbody>
    </table>
    <div>
      <span class="font-weight-bold">Basic Total:</span> {{ order.total }}
      {{ actor.currency }}
    </div>
    <div>
      <span class="font-weight-bold">Discount:</span>
      {{ order.total - float(puretotal.replace(/['"]+/g, "")) }}
      {{ actor.currency }}
    </div>
    <hr />
    <div>
      <span class="font-weight-bold">Final Total:</span>
      {{ float(puretotal.replace(/['"]+/g, "")) }} {{ actor.currency }}
    </div>
  </div>
</template>

<script>
import CONFIG from "../app";

export default {
  name: "InvoiceComponent.vue",
  props: ["auth", "lang", "orderid", "puretotal", "actor"],
  data() {
    return {
      path: CONFIG.PATH,
      loading: false,
      local: CONFIG.LANG,
      keywords: null,
      order: {},
      errors: [],
    };
  },
  created() {
    this.getOrder();
  },

  methods: {
    getOrder() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .doc(this.orderid)
        .get()
        .then((doc) => {
          this.loading = false;
          this.order = doc.data();
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    float(n) {
      return parseFloat(n);
    },
  },
};
</script>

<style scoped>
</style>
