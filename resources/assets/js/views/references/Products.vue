<template>
  <div>
    <!-- main container -->
    <notifications group="notification"/>
    <div class="animated fadeIn">
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
                Product List
                <small
                  class="font-italic"
                >List of all registered products.</small>
              </span>
            </h5>

            <b-row class="mb-2">
              <!-- row button and search input -->
              <b-col sm="4">
                <b-button
                  variant="primary"
                  @click="showModalEntry = true, entryMode='Add', clearFields('product')"
                >
                  <i class="fa fa-plus-circle"></i> Create New Product
                </b-button>
              </b-col>

              <b-col sm="4">
                <span></span>
              </b-col>

              <b-col sm="4">
                <b-form-input v-model="filters.products.criteria" type="text" placeholder="Search"></b-form-input>
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
                  :filter="filters.products.criteria"
                  :fields="tables.products.fields"
                  style
                  :items.sync="tables.products.items"
                  :current-page="paginations.products.currentPage"
                  :per-page="paginations.products.perPage"
                >
                  <!-- table -->

                  <template slot="action" slot-scope="data">
                    <!-- action slot  :to="{path: 'products/' + data.item.id } -->
                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                      <i class="fa fa-edit"></i>
                    </b-btn>

                    <b-btn
                      :size="'sm'"
                      :disabled="forms.product.isDeleting"
                      variant="danger"
                      @click="setDelete(data)"
                    >
                      <icon v-if="forms.product.isDeleting" name="sync" spin></icon>
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
                  :total-rows="paginations.products.totalRows"
                  :per-page="paginations.products.perPage"
                  v-model="paginations.products.currentPage"
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

    <div>
      <!-- modal div -->
      <b-modal
        size="lg"
        v-model="showModalEntry"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('product_code')"
      >
        <div slot="modal-title">
          <!-- modal title -->
          Product Entry - {{entryMode}}
        </div>
        <!-- modal title -->
        <div class="scroll">
          <b-col lg="12">
            <!-- modal body -->
            <b-form @keydown="resetFieldStates('product')" autocomplete="off">
              <b-row>
                <b-col lg="4">
                  <!-- divider -->
                  <b-form-group>
                    <label>* Product Code</label>
                    <b-form-input
                      id="product_code"
                      v-model="forms.product.fields.product_code"
                      type="text"
                      placeholder="Product Code"
                      ref="product_code"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                    <label>* Product Name</label>
                    <b-form-input
                      ref="product_name"
                      id="product_name"
                      v-model="forms.product.fields.product_name"
                      type="text"
                      placeholder="Product Name"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                    <label>Product Desc</label>
                    <b-form-input
                      ref="product_desc"
                      id="product_desc"
                      v-model="forms.product.fields.product_desc"
                      type="text"
                      placeholder="Product Desc"
                    ></b-form-input>
                  </b-form-group>
                   </b-col>
                <b-col lg="4">
                  <b-form-group>
                    <label>Cost Price</label>
                    <vue-autonumeric
                      v-model="forms.product.fields.product_cost"
                      ref="product_cost"
                      id="product_cost"
                      type="text"
                      class="form-control text-right"
                      :disabled="forms.product.fields.is_manual_pricing==1"
                      :options="[{ minimumValue: '0' , maximumValue: '200', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                  <b-form-group>
                    <label>Retail Price</label>
                    <vue-autonumeric
                      v-model="forms.product.fields.product_rate"
                      ref="product_rate"
                      id="product_rate"
                      type="text"
                      class="form-control text-right"
                      :disabled="forms.product.fields.is_manual_pricing==1"
                      :options="[{ minimumValue: '0' , maximumValue: '10000', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                  <b-form-group>
                    <b-form-checkbox
                      ref="is_manual_pricing"
                      id="is_manual_pricing"
                      value="1"
                      unchecked-value="0"
                      v-model="forms.product.fields.is_manual_pricing"
                      @input="forms.product.fields.is_manual_pricing==1? (forms.product.fields.product_rate =0, forms.product.fields.product_cost =0): ''"
                    >Is Manual Price</b-form-checkbox>
                  </b-form-group>
                  <b-form-group>
                    <label>Vat Percent</label>
                    <vue-autonumeric
                      v-model="forms.product.fields.vat_percent"
                      ref="vat_percent"
                      id="vat_percent"
                      type="text"
                      class="form-control text-right"
                      :disabled="forms.product.fields.is_vatable==0"
                      :options="[{ minimumValue: '0' , maximumValue: '100', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                  <b-form-group>
                    <b-form-checkbox
                      id="is_vatable"
                      v-model="forms.product.fields.is_vatable"
                      value="1"
                      unchecked-value="0"
                      @input="forms.product.fields.is_vatable==0? (forms.product.fields.vat_percent =0): ''"
                    >Is Vatable?</b-form-checkbox>
                  </b-form-group>
                </b-col>
                <b-col lg="4">
                  <b-form-group>
                    <label>Min Stock</label>
                    <b-form-input
                      ref="minimum_stock"
                      id="minimum_stock"
                      v-model="forms.product.fields.minimum_stock"
                      type="number"
                      placeholder="Min Stock"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                    <label>Max Stock</label>
                    <b-form-input
                      ref="maximum_stock"
                      id="maximum_stock"
                      v-model="forms.product.fields.maximum_stock"
                      type="number"
                      placeholder="Max Stock"
                    ></b-form-input>
                  </b-form-group>
                  <b-form-group>
                    <label for="category_id">* Category</label>
                    <select2
                      ref="category_id"
                      :allowClear="false"
                      :placeholder="'Select Category'"
                      v-model="forms.product.fields.category_id"
                    >
                      <!-- <option value="-1">New Inventory type</option> -->
                      <!-- MAY WRONG SPELLING -->
                      <option
                        v-for="cat in options.categories.items"
                        :key="cat.category_id"
                        :value="cat.category_id"
                      >{{cat.category_name}}</option>
                    </select2>
                  </b-form-group>
                  <b-form-group>
                    <label for="supplier_id">* Supplier</label>
                    <select2
                      ref="supplier_id"
                      :allowClear="false"
                      :placeholder="'Select Supplier'"
                      v-model="forms.product.fields.supplier_id"
                    >
                      <!-- <option value="-1">New Inventory type</option> -->
                      <option
                        v-for="sup in options.suppliers.items"
                        :key="sup.supplier_id"
                        :value="sup.supplier_id"
                      >{{sup.supplier_name}}</option>
                    </select2>
                  </b-form-group>
                  <b-form-group>
                    <label for="unit_id">* Unit</label>
                    <select2
                      ref="unit_id"
                      :allowClear="false"
                      :placeholder="'Select Unit'"
                      v-model="forms.product.fields.unit_id"
                    >
                      <option
                        v-for="u in options.units.items"
                        :key="u.unit_id"
                        :value="u.unit_id"
                      >{{u.unit_name}}</option>
                    </select2>
                  </b-form-group>
                </b-col>
              </b-row>
            </b-form>
          </b-col>
          <!-- modal body -->
        </div>
        <div slot="modal-footer">
          <!-- modal footer buttons -->
          <b-button :disabled="forms.product.isSaving" variant="primary" @click="onProductEntry">
            <icon v-if="forms.product.isSaving" name="sync" spin></icon>
            <i class="fa fa-check"></i>
            Save
          </b-button>
          <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
        </div>
        <!-- modal footer buttons -->
      </b-modal>
      <b-modal v-model="showModalDelete" :noCloseOnEsc="true" :noCloseOnBackdrop="true">
        <div slot="modal-title">Delete Product</div>
        <b-col lg="12">Are you sure you want to delete this product?</b-col>
        <div slot="modal-footer">
          <b-button :disabled="forms.product.isSaving" variant="primary" @click="onProductDelete">
            <icon v-if="forms.product.isSaving" name="sync" spin></icon>
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
  name: "products",
  data() {
    return {
      entryMode: "Add",
      showModalEntry: false, //if true show modal
      showModalDelete: false,
      showModalNationality: false,
      showModalIdType: false,
      forms: {
        product: {
          isSaving: false,
          isDeleting: false,
          fields: {
            product_id: null,
            product_code: null,
            product_name: null,
            product_desc: null,
            category_id: null,
            product_rate: 0,
            product_cost: 0,
            vat_percent: 0,
            is_manual_pricing: 0,
            is_vatable: 0,
            sort_key: 0
          }
        }
      },
      tables: {
        products: {
          fields: [
            {
              key: "product_code",
              label: "Code",
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
              key: "product_desc",
              label: "Product Desc",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_cost",
              label: "Cost Price",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_rate",
              label: "Retail Price",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "vat_percent",
              label: "Vat Percent",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "category_name",
              label: "Category",
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
              key: "unit_name",
              label: "Unit",
              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "sort_key",
              label: "Sort",
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
        }
      },
      filters: {
        products: {
          criteria: null
        }
      },
      paginations: {
        products: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
      options: {
        categories: {
          items: []
        },
        suppliers: {
          items: []
        },
        units: {
          items: []
        }
      },
      product_id: null,
      row: []
    };
  },
  methods: {
    onProductEntry() {
      if (this.entryMode == "Add") {
        this.createEntity("product", true, "products");
      } else {
        this.updateEntity("product", "product_id", true, this.row);
      }
    },
    onProductDelete() {
      this.deleteEntity(
        "product",
        this.product_id,
        true,
        "products",
        "product_id"
      );
    },
    async setDelete(data) {
      if ((await this.checkIfUsed("product", data.item.product_id)) == true) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.product_id = data.item.product_id;
      this.showModalDelete = true;
    },
    setUpdate(data) {
      this.row = data.item;
      this.resetFieldStates("product");
      this.fillEntityForm("product", data.item.product_id);
      this.showModalEntry = true;
      this.entryMode = "Edit";
    }
  },
  created() {
    this.fillOptionsList("categories");
    this.fillOptionsList("suppliers");
    this.fillOptionsList("units");
    this.fillTableList("products");
  }
};
</script>

