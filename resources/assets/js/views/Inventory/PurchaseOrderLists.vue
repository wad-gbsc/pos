<template>
  <div>
    <!-- main container -->
    <notifications group="notification" />
    <div v-show="!showEntry" class="animated fadeIn">
      <!-- main div -->
      <b-row>
        <!-- main row -->
        <b-col sm="12">
          <b-card>
            <!-- main card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">
                <i class="fa fa-bars"></i>
                Purchase Order List
                <small
                  class="font-italic"
                >List of all registered pruchase order.</small>
              </span>
            </h5>

            <!-- row button and search input -->

            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showEntry = true, entryMode='Add', clearFields('purchaseorderlist'), tables.purchaseorderitems.items=[], forms.purchaseorderlist.fields.purchase_order_datetime = new Date()"
                 
                >
                  <i class="fa fa-plus-circle"></i> Create New Purchase Order
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input
                  v-model="filters.purchaseorderlists.criteria"
                  type="text"
                  placeholder="Search"
                ></b-form-input>
              </b-col>
            </b-row>
            <!-- row button and search input -->

            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  responsive
                  fixed
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :filter="filters.purchaseorderlists.criteria"
                  :fields="tables.purchaseorderlists.fields"
                  style
                  :items.sync="tables.purchaseorderlists.items"
                  :current-page="paginations.purchaseorderlists.currentPage"
                  :per-page="paginations.purchaseorderlists.perPage"
                >
                  <!-- table -->

                  <template slot="action" slot-scope="data">
                    <!-- action slot  :to="{path: 'purchaseorderlists/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.purchaseorderlist.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.purchaseorderlist.isDeleting" name="sync" spin></icon>
                      <i v-else class="fa fa-trash"></i>
                    </b-btn>
                  </template>
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->

            <b-row>
              <!-- Pagination -->
              <b-col sm="12" class="my-1">
                <b-pagination
                  size="sm"
                  align="right"
                  :total-rows="paginations.purchaseorderlists.totalRows"
                  :per-page="paginations.purchaseorderlists.perPage"
                  v-model="paginations.purchaseorderlists.currentPage"
                  class="my-0"
                />
              </b-col>
            </b-row>
            <!-- Pagination -->
          </b-card>
          <!-- main card -->
        </b-col>
      </b-row>
      <!-- main row -->
    </div>
    <!-- main div -->



<!--SECOND CARD-->
    <div v-show="showEntry" class="animated fadeIn">
      <!-- sec div -->
      <b-row>
        <!-- sec row -->
        <b-col sm="12">
          <b-card>
            <!-- sec card -->
            <h5 slot="header">
              <!-- table header -->
              <span class="text-primary">Purchase Order List Entry - {{entryMode}}</span>
            </h5>
            <div class="scroll">
              <b-col lg="12">
                <!-- modal body -->
                <b-form autocomplete="off">
                  <b-row>
                    <b-col lg="4">
                      <!-- divider -->
                      <b-form-group>
                        <label>* Purchase Order No</label>
                        <b-form-input
                          disabled
                          id="purchase_order_no"
                          v-model="forms.purchaseorderlist.fields.purchase_order_no"
                          type="text"
                          placeholder="Auto Generated"
                          ref="purchase_order_no"
                        ></b-form-input>
                      </b-form-group>
                      <b-form-group>
                        <label for="department_id">* Department</label>
                        <select2
                          ref="department_id"
                          :allowClear="false"
                          :placeholder="'Select Department'"
                          v-model="forms.purchaseorderlist.fields.department_id"
                        >
                          <option
                            v-for="dep in options.departments.items"
                            :key="dep.department_id"
                            :value="dep.department_id"
                          >{{dep.department_name}}</option>
                        </select2>
                      </b-form-group>
                      <b-form-group>
                        <label for="supplier_id">* Supplier</label>
                        <select2
                          ref="supplier_id"
                          :allowClear="false"
                          :placeholder="'Select Supplier'"
                          v-model="forms.purchaseorderlist.fields.supplier_id"
                        >
                          <!-- <option value="-1">New Inventory type</option> -->
                          <option
                            v-for="sup in options.suppliers.items"
                            :key="sup.supplier_id"
                            :value="sup.supplier_id"
                          >{{sup.supplier_name}}</option>
                        </select2>
                      </b-form-group>
                    </b-col>
                    <b-col lg="4">
                      <b-form-group>
                        <label>* Date</label>
                        <date-picker
                          id="purchase_order_datetime"
                          format="MMMM/DD/YYYY"
                          v-model="forms.purchaseorderlist.fields.purchase_order_datetime"
                          lang="en"
                          input-class="form-control mx-input"
                          ref="purchase_order_datetime"
                          :clearable="false"
                        ></date-picker>
                      </b-form-group>
                      <b-form-group>
                        <label>Contact Person</label>
                        <b-form-input
                          id="contact_person"
                          v-model="forms.purchaseorderlist.fields.contact_person"
                          type="text"
                          placeholder="Contact Person"
                          ref="contact_person"
                        ></b-form-input>
                      </b-form-group>
                      <b-form-group>
                        <label>Contact No</label>
                        <b-form-input
                          id="contact_num"
                          v-model="forms.purchaseorderlist.fields.contact_num"
                          type="text"
                          placeholder="Contact No"
                          ref="contact_num"
                        ></b-form-input>
                      </b-form-group>
                    </b-col>
                    <b-col lg="4">
                      <b-form-group>
                        <label>Email</label>
                        <b-form-input
                          id="email_address"
                          v-model="forms.purchaseorderlist.fields.email_address"
                          type="text"
                          placeholder="Email"
                          ref="email_address"
                        ></b-form-input>
                      </b-form-group>
                      <b-form-group>
                        <label>Deliver To</label>
                        <b-form-input
                          id="deliver_to"
                          v-model="forms.purchaseorderlist.fields.deliver_to"
                          type="text"
                          placeholder="Deliver To"
                          ref="deliver_to"
                        ></b-form-input>
                      </b-form-group>
                      <b-form-group>
                        <label>Requested By</label>
                        <b-form-input
                          id="requested_by"
                          v-model="forms.purchaseorderlist.fields.requested_by"
                          type="text"
                          placeholder="Requested By"
                          ref="requested_by"
                        ></b-form-input>
                      </b-form-group>
                    </b-col>
                  </b-row>
                </b-form>
              </b-col>
              <!-- modal body -->
            </div>

            <div>
              <!-- row table -->
              <b-row class="mb-2">
                    <b-col lg=4>
                        <b-button variant="primary" @click="showModalProducts = true, selectedRow=[]">
                            <i class="fa fa-plus-circle"></i> Add Item
                        </b-button>
                    </b-col>
                    <b-col lg=4></b-col>
                    <b-col lg=4>
                        <b-form-input v-model="filters.purchaseorderitems.criteria" placeholder="Search"></b-form-input>
                    </b-col>
                </b-row>
              <b-row>
                <b-col sm="12">
                  <b-table
                    responsive
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.purchaseorderitems.criteria"
                    :fields="tables.purchaseorderitems.fields"
                    style
                    :items.sync="tables.purchaseorderitems.items"
                
                  >
                    <!-- table -->
                    <template slot="product_cost" slot-scope="data">
                      <vue-autonumeric
                        ref="product_cost"
                        id="product_cost"
                        v-model="data.item.product_cost"
                        class="form-control text-right"
                        :options="{
                                                minimumValue: '0', 
                                                emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </template>

                    <template slot="product_quantity" slot-scope="data">
                      <vue-autonumeric
                        ref="product_quantity"
                        id="product_quantity"
                        v-model="data.item.product_quantity"
                        class="form-control"
                        :options="{
                                                minimumValue: '0', 
                                                emptyInputBehavior:'1',}"
                      ></vue-autonumeric>
                    </template>

                   <template slot="action" slot-scope="data">
                                <b-btn
                                    :size="'sm'"
                                    variant="danger"
                                    @click="removeProduct(data.index)"
                                >
                                    <i class="fa fa-trash"></i>
                                </b-btn>
                            </template>
                        </b-table>
                  <!-- table -->
                   <b-row>
                            <b-col lg=4>
                                <b-form-textarea
                                    rows=2
                                    placeholder="Remarks"
                                    v-model="forms.purchaseorderlist.fields.purchase_order_remarks">
                                </b-form-textarea>
                            </b-col>
                            <b-col lg=5></b-col>
                            <b-col lg=3>
                                <b-row>
                                    <b-col lg=5>
                                        <label class="float-right col-form-label">Total Amount :</label>
                                    </b-col>
                                    <b-col lg=7>
                                        <vue-autonumeric
                                            readonly
                                            ref="total_amount"
                                            id="total_amount"
                                            v-model="this.getTotalItems"
                                            class='form-control text-right'
                                            :options="{
                                            minimumValue: '0',  
                                            emptyInputBehavior:'0',}"
                                        >
                                        </vue-autonumeric>
                                    </b-col>
                                </b-row>
                            </b-col>
                        </b-row>
                </b-col>
              </b-row>
            </div>

            

            <div  class="pull-right mt-2">
              <!-- modal footer buttons -->
              <b-button
                :disabled="forms.purchaseorderlist.isSaving"
                variant="primary"
                @click="onPurchaseorderlistEntry()">
                <icon v-if="forms.purchaseorderlist.isSaving" name="sync" spin></icon>
                <i class="fa fa-check"></i>
                Save
              </b-button>
              <b-button variant="secondary" @click="showEntry=false">Close</b-button>
            </div>
            <!-- modal footer buttons -->
          </b-card>
          <!-- sec card -->
        </b-col>
      </b-row>
      <!-- sec row -->
       
    </div>
    <!-- sec div -->

    <div>
      <!-- modal div -->
<div>
              <!-- modal div -->
              <b-modal
                size="lg"
                v-model="showModalProducts"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                :scrollable="true"
                @shown="focusElement('purchase_order_id')"
              >
                <div slot="modal-title">
                  <!-- modal title -->
                  Product List
                </div>
                <!-- modal title -->

                <b-row class="mb-2">
                  <!-- row button and search input -->
                  <b-col sm="4"></b-col>

                  <b-col sm="4">
                    <span></span>
                  </b-col>

                  <b-col sm="4">
                    <b-form-input
                    v-model="filters.products.criteria"
                    type="text"
                    placeholder="Search"
                ></b-form-input>
                  </b-col>
                </b-row>
                <!-- row button and search input -->

                <b-col sm="12">
                  <b-table
                    responsive
                    selectable
                    select-mode="single"
                    fixed
                    striped
                    hover
                    small
                    bordered
                    show-empty
                    :filter="filters.products.criteria"
                    :fields="tables.products.fields"
                    style
                    :items.sync="tables.products.items"
                    :current-page="paginations.products.currentPage"
                    :per-page="paginations.products.perPage"
                    @filtered="onFiltered($event, 'products')"
                    @row-selected="selectedRow = $event"
                  >
                    <!-- table -->
                  </b-table>
                </b-col>
                <!-- modal body -->
                <div></div>

                            <b-row>
                            <!-- Pagination -->
                            <b-col sm="12" class="my-1">
                                <b-pagination
                                size="sm"
                                align="right"
                                :total-rows="paginations.products.totalRows"
                                :per-page="paginations.products.perPage"
                                v-model="paginations.products.currentPage"
                                class="my-0"
                                />
                            </b-col>
                            </b-row>
                            <!-- Pagination -->

                <div slot="modal-footer">
                  <!-- modal footer buttons -->
                  <b-button
                    variant="primary"
                    @click="rowSelected"
                  >
                    <icon v-if="forms.purchaseorderlist.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Accept
                  </b-button>
                  <b-button variant="secondary" @click="showModalProducts=false">Close</b-button>
                </div>
                <!-- modal footer buttons -->
              </b-modal>
            </div>
      <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title">Delete Purchase Order</div>
        <b-col lg="12">Are you sure you want to delete this Purchase Order List?</b-col>
        <div slot="modal-footer">
          <b-button
            :disabled="forms.purchaseorderlist.isSaving"
            variant="primary"
            @click="onPurchaseorderlistDelete"
          >
            <icon v-if="forms.purchaseorderlist.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            OK
          </b-button>
          <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>
        </div>
      </b-modal>
    </div>
    <!-- modal div -->
  </div>
  <!-- main container -->
</template>



<script>
export default {
  name: "purchaseorderlists",
  data() {
    return {
      selectedRow: [],
      entryMode: "Add",
      showEntry: false, //if true show modal
      showModalProducts: false,
      showModalDelete: false,
      showNationality: false,
      showModalIdType: false,
      forms: {
        purchaseorderlist: {
          isSaving: false,
          isDeleting: false,
          fields: {
            purchase_order_id: null,
            purchase_order_no: null,
            department_id: null,
            supplier_id: null,
            purchase_order_datetime: null,
            purchase_order_remarks: null,
            contact_person: null,
            contact_num: null,
            total_amount: 0,
            is_received: 0
          }
        }
      },
      tables: {
        purchaseorderlists: {
          fields: [
            {
              key: "purchase_order_no",
              label: "Purchase Order No",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "department_name",
              label: "Department",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "supplier_name",
              label: "Supplier",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "purchase_order_datetime",
              label: "Date Time",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "total_amount",
              label: "Total Amount",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "is_received",
              label: "Is Received",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
        purchaseorderitems: {
          fields: [
            {
              key: "product_code",
              label: "Product Code",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_name",
              label: "Product Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "unit_name",
              label: "Unit",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_cost",
              label: "Cost",
              thStyle: { width: "12%" },
              thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "product_quantity",
              label: "Quantity",
              thStyle: { width: "12%" },
              thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true
            },
            {
              key: "total_cost",                                              
              label: "Total",
              thStyle: { width: "15%" },
              thClass: "text-right",
              tdClass: "align-middle text-right",
              sortable: true,
              formatter: (value, key, item) => {
                item.total_cost = item.product_cost * item.product_quantity;
                return this.formatNumber(item.total_cost);
                text: "align-right"
              }
            },
            {
              key: "action",
              label: "",
              thStyle: { width: "80px" },
              tdClass: "text-center"
            }
          ],
          items: []
        },
        products: {
          fields: [
            {
              key: "product_code",
              label: "Product Code",
              thStyle: { width: "150px" },
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_name",
              label: "Product Name",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "unit_name",
              label: "Unit",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_cost",
              label: "Cost",
              tdClass: "align-middle",
              sortable: true
            }
          ],
          items: []
        }
      },
      filters: {
        purchaseorderlists: {
          criteria: null
        },
        purchaseorderitems: {
          criteria: null
        },
        products: {
          criteria: null
        },
      },
      paginations: {
            purchaseorderlists: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
             purchaseorderitems: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
            products: {
                totalRows: 0,
                currentPage: 1,
                perPage: 10
            },
        },
     
      
      options: {
        departments: {
          items: []
        },
        suppliers: {
          items: []
        }
      },
      purchase_order_id: null,
      row: []
    };
  },
  methods: {
    onPurchaseorderlistEntry() {
      if(this.tables.purchaseorderitems.items.length > 0) {
        this.forms.purchaseorderlist.fields.items = this.tables.purchaseorderitems.items
        if (this.entryMode == "Add") {
          this.createEntity("purchaseorderlist", false, "purchaseorderlists");
        } else {
          this.updateEntity("purchaseorderlist","purchase_order_id",false,this.row );
        }
      }
      else {
        this.$notify({
          type: 'error',
          group: 'notification',
          title: 'Error!',
          text: 'Please Add an Item'
        })
      }
    },
    onPurchaseorderlistDelete() {
      this.deleteEntity(
        "purchaseorderlist",
        this.purchase_order_id,
        true,
        "purchaseorderlists",
        "purchase_order_id"
      );
    },
    onProductlistDelete() {
      this.deleteEntity(
        "productlist",
        this.product_id,
        true,
        "productlist",
        "purchase_order_id"
      );
    },
    async setDelete(data) {
      if (
        (await this.checkIfUsed(
          "purchaseorderlist",
          data.item.purchase_order_id
        )) == true
      ) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.purchase_order_id = data.item.purchase_order_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.$http.get('api/purchaseorderlist/'+ data.item.purchase_order_id, {
          headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
          }
      }).then(response => {
          this.forms.purchaseorderlist.fields = response.data.purchaseorderlists
          this.tables.purchaseorderitems.items = response.data.purchaseorderitems
          this.showEntry = true
          this.entryMode = "Edit"
      }).catch(err => {
          console.log(err)
      })
    },
    rowSelected() {
      if(this.selectedRow.length > 0){
        if(this.tables.purchaseorderitems.items.filter(i => i.product_id == this.selectedRow[0].product_id).length > 0){
           this.$notify({
                    type: "error",
                    group: "notification",
                    title: "Error!",
                    text: "Product is already added."
                })
                return
            }
           this.tables.purchaseorderitems.items.push({
                product_id: this.selectedRow[0].product_id,
                product_code: this.selectedRow[0].product_code,
                product_name: this.selectedRow[0].product_name,
                unit_name: this.selectedRow[0].unit_name,
                product_cost: this.selectedRow[0].product_cost,
                product_quantity: 1,
                product_total: this.selectedRow[0].product_cost
           })
        }
  },
  removeProduct(index){
        this.tables.purchaseorderitems.items.splice(index, 1)
    }
  },
  created() {
    // this.fillOptionsList("departments");
    // this.fillOptionsList("suppliers");
    // this.fillTableList("purchaseorderlists");
    // this.fillTableList("products");

    this.$http.get('api/purchaseorderlists', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then(response => {
        this.tables.purchaseorderlists.items = response.data.purchaseorderlists
        this.paginations.purchaseorderlists.totalRows = response.data.purchaseorderlists.length
        this.tables.products.items = response.data.products
        this.paginations.products.totalRows = response.data.products.length
        this.options.departments.items = response.data.departments
        this.options.suppliers.items = response.data.suppliers
    }).catch(error => {
        console.log(error)
    })
  },
  computed: {
    getTotalItems() {
      this.forms.purchaseorderlist.fields.total_amount = 0;

      this.tables.purchaseorderitems.items.forEach(item => {
        
            // console.log(item);
            this.forms.purchaseorderlist.fields.total_amount += Number(item.product_cost) * Number(item.product_quantity);
        
      });
      return this.forms.purchaseorderlist.fields.total_amount;
    }
  }
};
</script>

