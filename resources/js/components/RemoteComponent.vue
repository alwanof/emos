<template>
  <div class="container">
    <div class="text-center h4">
      <i class="fas fa-cog fa-spin px-2 text-primary" v-show="loading"></i>
    </div>
    <div class="row">
      <div class="col-md-4" v-show="acl.access_remote_new">
        <div class="card direct-chat direct-chat-primary">
          <div class="card-header ui-sortable-handle bg-danger" style="cursor: move;">
            <h3 class="card-title">New</h3>

            <div class="card-tools">
              <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary"></span>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="direct-chat-messages">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="(newOrder,index) in newOrders" :key="index">
                  <div>
                    <span class="badge badge-danger">
                      <span class="spinner-grow spinner-grow-sm"></span>
                      <span :id="'norder-'+newOrder.orderID.substring(0, 10)"></span>
                    </span>
                    <a
                      href="javascript:void(0)"
                      @click="exapandNew(newOrder)"
                      class="product-title"
                      data-toggle="tooltip"
                      title="Contacts"
                      data-widget="chat-pane-toggle"
                    >
                      #{{newOrder.orderID.substring(0, 4)}}
                      <span class="text-danger">
                        <i class="fas fa-barcode"></i>
                        {{newOrder.customer.name.substring(0, 12)}}
                      </span>
                      <span class="badge badge-danger float-right">{{newOrder.total}}</span>
                    </a>
                    <span class="product-description" :title="newOrder.note">
                      <i class="fas fa-phone-alt"></i>
                      {{newOrder.customer.phone}}
                      <i class="fas fa-map-marker-alt"></i>
                      {{newOrder.customer.address}}
                      <i class="far fa-comment"></i>
                      {{newOrder.note}}
                    </span>
                  </div>
                </li>
              </ul>
            </div>
            <div class="direct-chat-contacts p-2">
              <div class="pt-2">
                {{newExpand.customer.name}}@{{newExpand.customer.phone}}
                <button
                  type="button"
                  class="btn btn-tool float-right"
                  data-toggle="tooltip"
                  data-widget="chat-pane-toggle"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <ul class="list-group list-group-flush mt-4 rn-details">
                <li class="list-group-item" v-for="(item,index) in newExpand.items" :key="index">
                  <div>
                    {{item.title}}
                    <span class="badge badge-light float-right">{{item.amount}}</span>
                  </div>
                </li>
                <li class="list-group-item text-center">
                  <div v-show="acl.remote_pickitup">
                    <button
                      type="button"
                      @click="pickUp(newExpand.orderID)"
                      class="btn btn-sm btn-danger"
                      data-toggle="tooltip"
                      data-widget="chat-pane-toggle"
                    >PICKUP!</button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- //card -->
      </div>
      <div class="col-md-4" v-show="acl.access_remote_waiting">
        <div class="card direct-chat direct-chat-primary">
          <div class="card-header ui-sortable-handle bg-warning" style="cursor: move;">
            <h3 class="card-title">Waiting</h3>

            <div class="card-tools">
              <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary"></span>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="direct-chat-messages">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="(waitingOrder,index) in waitingOrders" :key="index">
                  <div>
                    <span class="badge badge-warning">
                      <span class="spinner-grow spinner-grow-sm"></span>
                      <span :id="'worder-'+waitingOrder.orderID.substring(0, 10)"></span>
                    </span>
                    <a
                      href="javascript:void(0)"
                      @click="exapandWaiting(waitingOrder)"
                      class="product-title"
                      data-toggle="tooltip"
                      title="Contacts"
                      data-widget="chat-pane-toggle"
                    >
                      #{{waitingOrder.orderID.substring(0, 4)}}
                      <span class="text-warning">
                        <i class="fas fa-barcode"></i>
                        {{waitingOrder.customer.name.substring(0, 12)}}
                      </span>
                      <span class="badge badge-warning float-right">{{waitingOrder.total}}</span>
                    </a>
                    <span class="product-description" :title="waitingOrder.note">
                      <i class="fas fa-phone-alt"></i>
                      {{waitingOrder.customer.phone}}
                      <i class="fas fa-map-marker-alt"></i>
                      {{waitingOrder.customer.address}}
                      <i class="far fa-comment"></i>
                      {{waitingOrder.note}}
                    </span>
                  </div>
                  <div class="progress mt-1" style="height:0.5rem">
                    <div
                      class="progress-bar progress-bar-striped bg-success"
                      role="progressbar"
                      :style="'width: '+orderProgress(waitingOrder)+'%'"
                      aria-valuemax="100"
                    ></div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="direct-chat-contacts p-2">
              <div class="pt-2">
                {{waitingExpand.customer.name}}@{{waitingExpand.customer.phone}}
                <button
                  type="button"
                  class="btn btn-tool float-right"
                  data-toggle="tooltip"
                  data-widget="chat-pane-toggle"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <ul class="list-group list-group-flush mt-4 rn-details">
                <li
                  class="list-group-item"
                  v-for="(item,index) in waitingExpand.items"
                  :key="index"
                >
                  <div>
                    {{item.title}}
                    <span class="badge badge-light float-right">{{item.amount}}</span>
                  </div>
                </li>
                <li class="list-group-item text-center">
                  <div v-show="acl.remote_handover">
                    <button
                      type="button"
                      @click="delivered(waitingExpand.orderID)"
                      class="btn btn-sm btn-warning"
                      data-toggle="tooltip"
                      data-widget="chat-pane-toggle"
                    >Delivered!</button>
                    <button
                      type="button"
                      class="btn btn-sm btn-danger"
                      data-toggle="modal"
                      data-target="#exampleModal"
                    >
                      Print!
                    </button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- //card -->
      </div>
      <div class="col-md-4" v-show="acl.access_remote_done">
        <div class="card direct-chat direct-chat-primary">
          <div class="card-header bg-success">
            <h3 class="card-title">Stabled</h3>

            <div class="card-tools">
              <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary"></span>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="direct-chat-messages">
              <ul class="products-list product-list-in-card pl-2 pr-2">
                <li class="item" v-for="(stabledOrder,index) in stabledOrders" :key="index">
                  <div>
                    <a
                      href="javascript:void(0)"
                      @click="exapandStabled(stabledOrder)"
                      class="product-title"
                      data-toggle="tooltip"
                      title="Contacts"
                      data-widget="chat-pane-toggle"
                    >
                      #{{stabledOrder.orderID.substring(0, 4)}}
                      <span class="text-success">
                        <i class="fas fa-barcode"></i>
                        {{stabledOrder.customer.name.substring(0, 12)}}
                      </span>
                      <span class="badge badge-success float-right">{{stabledOrder.total}}</span>
                    </a>
                    <span class="product-description" :title="stabledOrder.note">
                      <i class="fas fa-phone-alt"></i>
                      {{stabledOrder.customer.phone}}
                      <i class="fas fa-map-marker-alt"></i>
                      {{stabledOrder.customer.address}}
                      <i class="far fa-comment"></i>
                      {{stabledOrder.note}}
                    </span>
                  </div>
                </li>
              </ul>
            </div>
            <div class="direct-chat-contacts p-2">
              <div class="pt-2">
                {{stabledExpand.customer.name}}@{{stabledExpand.customer.phone}}
                <button
                  type="button"
                  class="btn btn-tool float-right"
                  data-toggle="tooltip"
                  data-widget="chat-pane-toggle"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
              <ul class="list-group list-group-flush mt-4 rn-details">
                <li
                  class="list-group-item"
                  v-for="(item,index) in stabledExpand.items"
                  :key="index"
                >
                  <div>
                    {{item.title}}
                    <span class="badge badge-light float-right">{{item.amount}}</span>
                  </div>
                </li>
                <li class="list-group-item text-center">
                  <div v-show="false">
                    <button
                      type="button"
                      @click="done(stabledExpand.orderID)"
                      class="btn btn-sm btn-success"
                      data-toggle="tooltip"
                      data-widget="chat-pane-toggle"
                    >Check-Out!</button>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- //card -->
      </div>
    </div>
     <!-- Modal -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true" >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Invoice#
              {{
                waitingExpand.orderID
                  ? waitingExpand.orderID.substring(0, 6)
                  : ""
              }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label for="tax">Tax</label>
            <input
              id="tax"
              type="text"
              class="form-control"
              v-model="waitingExpand.tax"
            />
            <br />
            <label for="puretotal">Final Total</label>
            <input
              id="puretotal"
              type="text"
              class="form-control"
              v-model="waitingExpand.pureTotal"
            />
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Close
            </button>
            <button
              type="button"
              @click="
                getInvoice(
                  waitingExpand.orderID,
                  waitingExpand.pureTotal,
                  waitingExpand.tax
                )
              "
              target="_blank"
              class="btn btn-primary"
            >
              Apply
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import CONFIG from "../app";
import Timer from "../../../public/assets/dist/js/lib/timer/easytimer.min";

export default {
  name: "RemoteComponent",
  props: ["acl", "lang", "auth", "actor", "masa"],
  data() {
    return {
      path: CONFIG.PATH,
      fullPath: CONFIG.FULL_PATH,
      local: CONFIG.LANG,
      loading: false,
      newOrders: [],
      newExpand: {
        customer: {},
        orderID: null,
        items: [],
      },
      waitingOrders: [],
      waitingExpand: {
        customer: {},
        orderID: null,
        items: [],
      },
      stabledOrders: [],
      stabledExpand: {
        customer: {},
        orderID: null,
        items: [],
      },
    };
  },
  created() {
    this.getNewOrders();
    this.getWaitingOrders();
    this.getStabledOrders();
    this.archiveStabled();
  },
  methods: {
    getNewOrders() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 0)
        .where("remote", "==", true)
        .orderBy("timestamp", "asc")
        .onSnapshot((snap) => {
          if (snap.size == 0) {
            this.loading = false;
            this.newOrders = [];
            return 0;
          }
          let newData = [];
          snap.forEach((doc) => {
            newData.push(doc.data());
          });
          let stabledData = this.whatsHappened(this.newOrders, newData, "hash");
          if (stabledData[0].length > 0) {
            stabledData[0].forEach((element) => {
              const today = new Date();
              const now = today.getTime() / 1000;
              const datePoint = element.timestamp.seconds;
              const sec = now - datePoint;
              this.timer("norder-" + element.orderID.substring(0, 10), sec);
              this.newOrders.push(element);
            });
          }

          if (stabledData[1].length > 0) {
            stabledData[1].forEach((element) => {
              let index = this.newOrders.findIndex(
                (x) => x.orderID == element.orderID
              );
              if (index != -1) {
                this.newOrders.splice(index, 1);
              }
            });
          }
          if (stabledData[2].length > 0) {
            stabledData[2].forEach((element) => {
              let index = this.newOrders.findIndex(
                (x) => x.orderID == element.orderID
              );
              if (index != -1) {
                const today = new Date();
                const now = today.getTime() / 1000;
                const datePoint = element.timestamp.seconds;
                const sec = now - datePoint;
                this.timer("renorder-" + element.orderID.substring(0, 10), sec);
                this.newOrders.splice(index, 1);
                this.newOrders.push(element);
              }
            });
          }

          this.loading = false;
        });
    },
    exapandNew(order) {
      this.newExpand.items = [];
      this.newExpand.customer = order.customer;
      this.newExpand.orderID = order.orderID;
      order.items.forEach((element) => {
        this.newExpand.items.push({
          title: element.title,
          amount: element.amount,
        });
      });
    },
    getWaitingOrders() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 1)
        .where("remote", "==", true)
        .orderBy("timestamp", "asc")
        .onSnapshot((snap) => {
          if (snap.size == 0) {
            this.loading = false;
            return 0;
          }
          snap.forEach((doc) => {
            let isExist = this.waitingOrders.findIndex(
              (x) => x.orderID == doc.data().orderID
            );
            if (isExist > -1) {
              this.waitingOrders[isExist].items.forEach((e, i) => {
                if (e.out != doc.data().items[i].out) {
                  //console.log(doc.data().items[i]);
                  this.waitingOrders[isExist].items[i].out = doc.data().items[
                    i
                  ].out;
                }
              });
            }
            if (isExist == -1) {
              const today = new Date();
              const now = today.getTime() / 1000;
              const datePoint = doc.data().status.timestamp.seconds;
              const sec = now - datePoint;
              this.timer("worder-" + doc.data().orderID.substring(0, 10), sec);
              this.waitingOrders.push(doc.data());
            }
          });
          this.loading = false;
        });
    },
    exapandWaiting(order) {
      this.waitingExpand.items = [];
      this.waitingExpand.customer = order.customer;
      this.waitingExpand.orderID = order.orderID;
      order.items.forEach((element) => {
        this.waitingExpand.items.push({
          title: element.title,
          amount: element.amount,
        });
      });
    },
    getStabledOrders() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 3)
        .where("remote", "==", true)
        .orderBy("timestamp", "asc")
        .onSnapshot((snap) => {
          if (snap.size == 0) {
            this.loading = false;
            return 0;
          }
          this.stabledOrders = [];
          snap.forEach((doc) => {
            this.stabledOrders.push(doc.data());
          });
          this.loading = false;
        });
    },
    exapandStabled(order) {
      this.stabledExpand.items = [];
      this.stabledExpand.customer = order.customer;
      this.stabledExpand.orderID = order.orderID;
      order.items.forEach((element) => {
        this.stabledExpand.items.push({
          title: element.title,
          amount: element.amount,
        });
      });
    },
    archiveStabled() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 3)
        .where("remote", "==", true)
        .get()
        .then((snap) => {
          snap.forEach((doc) => {
            CONFIG.DB.collection("orders")
              .doc(doc.data().orderID)
              .update({
                "status.value": 2,
                hash: Math.random(),
                "status.timestamp": new Date(),
              })
              .then(() => {
                this.loading = false;
              });
          });
        });
    },
    pickUp(orderID) {
      this.loading = true;

      CONFIG.DB.collection("orders")
        .doc(orderID)
        .update({
          "status.value": 1,
          hash: Math.random(),
          "status.timestamp": new Date(),
        })
        .then(() => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    delivered(orderID) {
      this.loading = true;
      let isExist = this.waitingOrders.findIndex((x) => x.orderID == orderID);
      if (isExist != -1) {
        this.waitingOrders.splice(isExist, 1);
      }
      CONFIG.DB.collection("orders")
        .doc(orderID)
        .update({
          "status.value": 3,
          hash: Math.random(),
          "status.timestamp": new Date(),
        })
        .then(() => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    done(orderID) {
      this.loading = true;
      let isExist = this.stabledOrders.findIndex((x) => x.orderID == orderID);
      if (isExist != -1) {
        this.stabledOrders.splice(isExist, 1);
      }
      CONFIG.DB.collection("orders")
        .doc(orderID)
        .update({
          "status.value": 2,
          hash: Math.random(),
          "status.timestamp": new Date(),
        })
        .then(() => {
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    timer(elementID, Seconds) {
      var timer = new Timer();

      timer.start({ startValues: { seconds: Seconds } });
      timer.addEventListener("secondsUpdated", function (e) {
        $("#" + elementID).html(timer.getTimeValues().toString());
      });
    },
    whatsHappened(b, n, c) {
      let add = [];
      let trash = [];
      let updated = [];
      n.forEach((element) => {
        let index = b.findIndex((x) => x.orderID == element.orderID);
        if (index == -1) {
          add.push(element);
        } else {
          if (element[c] != b[index][c]) {
            updated.push(element);
          }
        }
      });
      b.forEach((element) => {
        if (n.findIndex((x) => x.orderID == element.orderID) == -1) {
          trash.push(element);
        }
      });
      return [add, trash, updated];
    },
    orderProgress(order) {
      let out = 0;
      order.items.forEach((e) => {
        if (e.out == 1) {
          out++;
        }
      });
      return Math.round((100 * out) / order.items.length);
    },
       getInvoice(orderID, pureTotal, tax) {
      window.open(
        this.fullPath +
          "/admin/invoice/print/" +
          orderID +
          "/" +
          pureTotal +
          "/" +
          tax
      );
    },
  },
};
</script>

<style scoped>
</style>
