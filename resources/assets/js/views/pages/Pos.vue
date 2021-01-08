<style>
.b {
  border: 1px solid black;
  background-color: lightgray;
  color: black;
  font-size: 11px;
  cursor: pointer;
  margin-top: -12%;
}
.success {
  border-color: gray;
  color: black;
}
.success:hover {
  background-color: rgb(157, 209, 240);
  color: black;
}
.i {
  size: 10px;
}
.imgsize {
  width: 30px;
  height: 30px;
}
.barr:focus {
  background-color : #e8e376;
}
.input:focus {
  background-color : #e8e376;
}
.hr {
  border: 0.5px solid black;
  margin-top: -2%;
}
.types {
  margin-left: 5%;
  margin-top: -2%;
}
.typeboxx:focus {
  background-color : #e8e376;
}
.typebox {
  margin-top: -2%;
  margin-bottom: 3%;
  text-align: right;
}
.typeboxx {
  margin-top: -2%;
  margin-bottom: 3%;
  text-align: right;
}
.paybtn {
  background-color: aqua;
  border-radius: 0px;
  height: 70.5px;
  width: 31.6%;
  margin-left: 1%;
  margin-top: 1%;
  text-align: center;
  color: red;
  font-family: "Times New Roman", Times, serif;
  font-size: 220%;
  text-shadow: 0.5px 0.5px black;
  font-weight: bold;
}
.paybtn:hover {
  background-color: rgb(157, 209, 240);
}
.btnqty{
  background-color: aqua;
  border-radius: 0px;
  height: 70.5px;
  width: 31%;
  margin-left: 1%;
  margin-top: 1%;
  text-align: center;
  color: red;
  font-family: "Times New Roman", Times, serif;
  font-size: 22px;
  text-shadow: 0.5px 0.5px black;
  font-weight: bold;
}
.btnqty:hover {
  background-color: rgb(157, 209, 240);
}
.enter {
  background-color: aqua;
  border-radius: 0px;
  height: 90px;
  width: 97%;
  margin-left: 3%;
  margin-top: 1%;
  padding: 0%;
  font-family: "Times New Roman", Times, serif;
  font-size: 240%;
  color: red;
  text-shadow: 0.5px 0.5px black;
  font-weight: bold;
}
.cardmodal {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  border-radius: 0px;
  margin-left: -4%;
  margin-top: 0.5%;
  margin-bottom: 0%;
  height: 43%;
  width: 108%;
}
.titlelabel {
  font-size: 11px;
  margin-left: 3%;
}
.iconcard {
  background-color: lightgrey;
  margin-top: -1%;
  width: 99%;
  margin-left: 0.1%;
  height: 43px;
  grid-column: 2/4;
}
.checkbox {
  margin-top: 2%;
  margin-left: 86%;
}
.btnplus {
  border: none;
  padding: initial;
  margin-top: -2%;
  background: none;
  margin-left: 3%;
  width: 6%;
  height: 5%;
  transform: rotate(360deg);
}
.btnplus:active::after {
  border: none;
  background: none;
  transform: rotate(360deg);
}
/* .container{
  height:auto;
  width:auto;} */

</style>

<template>
  <div>
     <notifications group="notification" />
    <div>
      <b-row no-gutters>
        <b-col lg="9" class="pospic">
          <b-card>
            <table>
              <tr>
                <td>
                  <label style="font-size: 30px">BUSINESS LOGO HERE</label>
                  <!-- <img src="images/pos/jdev-logo.png" height="10%" width="100%" /> -->
                </td>
              </tr>
            </table>
            <b-row>
              <!-- row table -->
              <b-col sm="12">
                <b-table
                  selectable
                  select-mode="single"
                  responsive
                  fixed
                  striped
                  hover
                  small
                  bordered
                  show-empty
                  :filter="filters.posystem.criteria"
                  :fields="tables.posystem.fields"
                  style="height: 400px;"
                  :items.sync="tables.posystem.items"
                  @filtered="onFiltered($event, 'products')"
                  @row-selected="selectedRow = $event"
                >
                  <!-- table -->
                </b-table>
                <!-- table -->
              </b-col>
            </b-row>
            <!-- row table -->
            <br />
            <br />
            
            <b-row>
              <b-col sm="6">
                <label style="font-weight:bold; font-size: 15px;" id="productcode">Scan PLU / Barcode Here:</label>
              </b-col>

              <b-col sm="6">
                <label style="font-weight:bold; font-size: 15px;">Total Quantity:</label>
                <label style="font-weight:bold; font-size: 15px;">0</label>
              </b-col>
            </b-row>
            <b-row>
              <b-col sm="12">
                <b-form-input class= "barr"
                  style=" font-weight:bold; font-size: 15px; "
                  ref="productcode"
                  id="product_code"
                  type="text"
                ></b-form-input>
              </b-col>
            </b-row>
          </b-card>
        </b-col>

        <b-col lg="3">
          <table class="w-100">
            <tr border="#111" bgcolor="#000">
              <td valign="top">
                <label style="font-size: 15px; color: white" >AMOUNT DUE:</label>
                <label ref="total_amount_due" id="total_amount_due" style="font-size: 70px; color:yellow" class="float-right">{{formatNumber(this.getTotalItems)}}</label>
              </td>
            </tr>
            <br />
            <!-- <th bgcolor="#fff"></th> -->
            <tr bgcolor="#000">
              <td valign="top">
                <label style="font-size: 15px; color: white">TENDERED:</label>
                <label style="font-size: 70px; color:yellow" class="float-right">0.00</label>
              </td>
            </tr>
            <br />
            <tr bgcolor="#000">
              <td valign="top">
                <label style="font-size: 15px; color: white">CHANGE:</label>
                <label style="font-size: 70px; color:yellow" class="float-right">0.00</label>
              </td>
            </tr>
            <tr bgcolor="#fff">
              <td > 
                <label style="height=25px; width=100px">BUSINESS LOGO HERE</label>
                <!-- <img src="images/pos/jdev-logo.png" height="25%" width="100%" /> -->
              </td>
            </tr>
          </table>
        </b-col>
      </b-row>
      <div>
      <b-row no-gutters>
        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="focusElement('row')"
          >
            <h3>
              <img src="images/pos/f1.png" class="imgsize" />
            </h3>F1 - FOCUS GRID
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="focusElement('productcode')"
          >
            <h3>
              <img src="images/pos/f2.png" class="imgsize" />
            </h3>F2 - SCAN
            <br />BARCODE
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="showModalProducts = true"
          >
            <h3>
              <img src="images/pos/f3.png" class="imgsize" />
            </h3>F3 - BROWSE
            <br />ITEM
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="removeProduct"
          >
            <h3>
              <img src="images/pos/f4.png" class="imgsize" />
            </h3>F4 - VOID
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
          >
            <h3>
              <img src="images/pos/f5.png" class="imgsize" />
            </h3>F5 - JOURNAL
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="showModalPayment = true"

          >
            <h3>
              <img src="images/pos/f6.png" class="imgsize" />
            </h3>F6 - PAYMENT
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
          >
            <h3>
              <img src="images/pos/f7.png" class="imgsize" />
            </h3>F7 - OPEN CASH
            <br />DRAWER
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="showModalDelete = true"
          >
            <h3>
              <img src="images/pos/f8.png" class="imgsize" />
            </h3>F8 - CANCEL
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
          >
            <h3>
              <img src="images/pos/f9.png" class="imgsize" />
            </h3>F9 - HOLD
            <br />TRANSACTION
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
          >
            <h3>
              <img src="images/pos/f10.png" class="imgsize" />
            </h3>F10 - DISCOUNT
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
            @click="rowSelected"
          >
            <h3>
              <img src="images/pos/f11.png" class="imgsize" />
            </h3>F11 - QUANTITY
          </b-button>
        </b-col>

        <b-col sm="1">
          <b-button
            squared
            responsive
            variant="outline-light"
            class="b success"
            style="height: 80px; width: 135px"
          >
            <h3>
              <img src="images/pos/f12.png" class="imgsize" />
            </h3>F12 - X READING
          </b-button>
        </b-col>
      </b-row>

      <b-row>
        <b-col sm="10">
          <label style="font-size: 13px;">Cashier:</label>
          <label style="font-size: 13px;"></label>
        </b-col>

        <b-col sm="2">
          <label style="font-size: 13px; text-align: right">Datetime:</label>
          <label style="font-size: 13px;"></label>
        </b-col>
      </b-row>
      </div>

      <!-- modal div -->
      <div>
        <!-- modal div -->
        <b-modal
          size="lg"
          v-model="showModalProducts"
          :noCloseOnEsc="true"
          :noCloseOnBackdrop="true"
          :scrollable="true"
          @shown="focusElement('product_id')"
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
              <b-form-input v-model="filters.products.criteria" type="text" placeholder="Search"></b-form-input>
            </b-col>
          </b-row>
          <!-- row button and search input -->

          <b-table
            selectable
            select-mode="single"
            responsive
            fixed
            striped
            hover
            small
            bordered
            show-empty
            :filter="filters.products.criteria"
            :fields="tables.products.fields"
            :per-page="paginations.products.perPage"
            :current-page="paginations.products.currentPage"
            :items.sync="tables.products.items"
            @filtered="onFiltered($event, 'products')"
            @row-selected="selectedRow = $event"
          >
            <!-- table -->
          </b-table>
          <b-row>
            <b-col sm="12" class="my-1">
              <b-pagination
                size="sm"
                align="right"
                v-model="paginations.products.currentPage"
                :per-page="paginations.products.perPage"
                :total-rows="paginations.products.totalRows"
                class="my-0"
              ></b-pagination>
            </b-col>
          </b-row>
          <!-- modal body -->

          <div slot="modal-footer">
            <!-- modal footer buttons -->
            <b-button variant="primary" @click="rowSelected" >
              <icon v-if="forms.pos.isSaving" name="sync" spin></icon>
              <i class="fa fa-check"></i>
              Accept
            </b-button>
            <b-button variant="secondary" @click="showModalProducts=false">Close</b-button>
          </div>
          <!-- modal footer buttons -->
        </b-modal>
      </div>

      <!-- modal div -->
      <div>
        <!-- modal div -->
        <b-modal
        size="lg"
        id="modal-center"
        centered
        title="BootstrapVue"
        v-model="showModalQuantity"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('input_quantity')"
      >
        <div slot="modal-title">Product Quantity</div>
        <div>
          <b-col lg="12">
          <b-row>
          <b-col lg="6">
            <br>
          <h4>
            <center>{{forms.quantity.fields.product_name}}</center>
          </h4>
           <hr class="hr" />
<br>
          <b-row class="my-1">
            <b-col sm="4">
              <label>Product Code:</label>
            </b-col>

            <b-col sm="8">
              <b-form-input
                readonly
                style="text-align:right"
                ref="product_code"
                id="product_code"
                v-model="forms.quantity.fields.product_code"
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-1">
            <b-col sm="4">
              <label>Prev.Quantity:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input
                style="text-align:right"
                readonly
                id="product_quantity"
                v-model="forms.quantity.fields.prev_quantity"
              ></b-form-input>
            </b-col>
          </b-row>

          <b-row class="my-1">
            <b-col sm="4">
              <label>Product Cost:</label>
            </b-col>
            <b-col sm="8">
              <b-form-input
                style="text-align:right"
                readonly
                ref="product_cost"
                id="product_cost"
                v-model="forms.quantity.fields.product_rate"
              ></b-form-input>
            </b-col>
          </b-row>
<br>
          <h4>
            <center>Please input quantity:</center>
          </h4>
          <br>
         <vue-autonumeric
                    class="input"
                    ref="input_quantity"
                    id="product_quantity"
                    v-model="forms.quantity.fields.product_quantity"
                    style="text-align:center; height:49px; font-size:49px; width:97.5%; margin-left: 1%;"
                    :options="{
                          minimumValue: '0',
                          maximumValue: '999999',
                          emptyInputBehavior:'0',
                          decimalPlaces: 0}"
                  ></vue-autonumeric>
          </b-col>

          
          <b-col lg="6">
            <div>
                      <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(7)">7</b-button>
                      <b-button class="btnqty" @click="addPayment1(8)">8</b-button>
                      <b-button class="btnqty" @click="addPayment1(9)">9</b-button>

                      <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(4)">4</b-button>
                      <b-button class="btnqty" @click="addPayment1(5)">5</b-button>
                      <b-button class="btnqty" @click="addPayment1(6)">6</b-button>

                      <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(1)">1</b-button>
                      <b-button class="btnqty" @click="addPayment1(2)">2</b-button>
                      <b-button class="btnqty" @click="addPayment1(3)">3</b-button>

                      <b-button style="margin-left: 2%;" class="btnqty" @click="addPayment1(0)">0</b-button>
                      <b-button class="btnqty" @click="forms.quantity.fields.product_quantity = 0">CLEAR</b-button>
                      <b-button class="btnqty" @click="showModalQuantity=false">CANCEL</b-button>

                      <b-button class="enter" @click="acceptQuantity">ENTER</b-button>
            </div>
        </b-col>
            </b-row>
          </b-col>
        </div>

        

        <div slot="modal-footer">
          
        </div>
      </b-modal>

       <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete
                </div>
                <b-col lg=12>
                    Are you sure you want to cancel this transaction?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.pos.isSaving" variant="primary" value="Refresh Page" onClick="window.location.reload();">
                        <icon v-if="forms.pos.isSaving" name="sync" spin ></icon>
                        <i class="fa fa-check"></i>
                        OK
                    </b-button>
                    <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>            
                </div>
            </b-modal>

            <b-modal 
                v-model="showModalVoid"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete
                </div>
                <b-col lg=12>
                    Are you sure you want to void this item?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.pos.isSaving" variant="primary" @click="removeProduct=true" >
                        <icon v-if="forms.pos.isSaving" name="sync" spin ></icon>
                        <i class="fa fa-check"></i>
                        OK
                    </b-button>
                    <b-button variant="secondary" @click="showModalVoid=false">Close</b-button>            
                </div>
            </b-modal>

          <b-modal
        size="lg"
        id="modal-center"
        centered
        v-model="showModalPayment"
        :noCloseOnEsc="true"
        :noCloseOnBackdrop="true"
        @shown="focusElement('totaltendered')"
        
      >
        <div slot="modal-title" class="titlemodal">
          Payment<br>
          <small>Add payment like cash, card, cheque and etc.</small>
        </div>

        <div>
          <div class="iconcard">
            <div>
              <!-- <b-form-checkbox  v-model="forms.adjustmentlist.fields.adjustment_type" class="checkbox" value="1" :checked="adjustment_type = 1"> -->
              <b-form-checkbox class="checkbox">
                <label>Print Receipt</label>
              </b-form-checkbox>
            </div>
          </div>

          <b-col lg="12">
            <b-row>
              <b-col lg="6">
                <div class="cardmodal">
                  <p class="card-header">
                    <center>
                      <b>Type of Payments</b>
                    </center>
                  </p>
                  <div c  lass="card-body">
                    <hr class="hr" />

                    <b-row class="my-1">
                      <b-button class="btnplus" @click="showModalCardPayment = true">
                        <img src="images/pos/plus.png" height="20px" width="20px" />
                      </b-button>
                      <label class="types" for="input-small">F1 - Card</label>

                      <vue-autonumeric
                      readonly
                        ref="card_type_id"
                        id="card_type_id"
                        v-model="forms.payment.fields.card_type_id"
                        class="typebox"
                        style="margin-left: 34%"
                        :options="{
                                        minimumValue: '0',
                                        maximumValue: '999999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </b-row>

                    <hr class="hr" />

                    <b-row class="my-1">
                      <b-button class="btnplus" @click="showModalCheckPayment = true">
                        <img src="images/pos/plus.png" height="20px" width="20px" />
                      </b-button>

                      <label class="types" for="input-small">F2 - Check</label>
                      <vue-autonumeric
                      readonly
                        v-model="forms.payment.fields.check_type_id"
                        class="typebox"
                        style="margin-left: 32%"
                        :options="{
                                        minimumValue: '0', 
                                        maximumValue: '999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </b-row>
                    <hr class="hr" />

                    <b-row class="my-1">
                      <b-button class="btnplus" @click="showModalGCPayment = true">
                        <img src="images/pos/plus.png" height="20px" width="20px" />
                      </b-button>
                      <label class="types" for="input-small">F3 - Gift Check</label>

                      <vue-autonumeric
                      readonly
                        v-model="forms.payment.fields.gc_type_id"
                        class="typebox"
                        style="margin-left: 27%"
                        :options="{
                                        minimumValue: '0', 
                                        maximumValue: '999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </b-row>
                     <hr class="hr" />

                    <b-row class="my-1">
                      <b-button class="btnplus">
                        <img src="images/pos/plus.png" height="20px" width="20px" />
                      </b-button>
                      <label class="types" for="input-small">F4 - Charge</label>

                      <vue-autonumeric
                      readonly
                        ref="charge"
                        id="charge"
                        v-model="forms.payment.fields.charge_to"
                        class="typebox"
                        style="margin-left: 31%"
                        :options="{
                                        minimumValue: '0',
                                        maximumValue: '999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </b-row>
                    <hr class="hr" />

                    <b-row class="my-1">
                      <b-button class="btnplus" @click="focusElement('totaltendered')">
                        <img src="images/pos/plus.png" height="20px" width="20px" />
                      </b-button>
                      <label class="types" for="input-small">F5 - Cash</label>

                      <vue-autonumeric
                      
                        v-model="forms.payment.fields.total_tendered"
                        ref="totaltendered"
                        id="total_tendered"
                        class="typeboxx"
                        style="margin-left: 33.5%"
                        formatNumber="true"
                        :options="{
                                        minimumValue: '0', 
                                        maximumValue: '999999',
                                        emptyInputBehavior:'0',}"
                      ></vue-autonumeric>
                    </b-row>
                    <hr class="hr" />
                  </div>
                </div>
<br>
                <div>
                  <b-row>
                    <table class="w-100">
            <tr border="#111" bgcolor="#000">
              <td valign="top">
                <label style="font-size: 18px; color: white">AMOUNT DUE:</label>
                <label ref="total_amount_due" id="total_amount_due" style="font-size: 54px; color:yellow" class="float-right">{{formatNumber(this.getTotalItems)}}</label>
              </td>
            </tr>
            <br />
            <!-- <th bgcolor="#fff"></th> -->
            <tr bgcolor="#000">
              <td valign="top">
                <label style="font-size: 18px; color: white">TENDERED:</label>
                <label ref="cash" id="total_tendered" style="font-size: 54px; color:yellow" class="float-right">{{formatNumber(this.forms.payment.fields.total_tendered)}}</label>
              </td>
            </tr>
            <br />
            <tr bgcolor="#000">
              <td valign="top">
                <label style="font-size: 18px; color: white">CHANGE:</label>
                <label id="total_change" style="font-size: 54px; color:yellow" class="float-right">{{formatNumber(forms.payment.fields.total_tendered - getTotalItems)}}</label>
              </td>
            </tr>
          </table>
                  </b-row>
                </div>
              </b-col>

              <b-col lg="6">
                <div>
                  <b-row>
                    <table>
                      <b-button
                        style="margin-left: 3%; margin-top: 0.2%;"
                        class="paybtn"
                        @click="addPayment2(100)"
                      >100</b-button>
                      <b-button style="margin-top: 0.2%;" class="paybtn" @click="addPayment2(50)">50</b-button>
                      <b-button style="margin-top: 0.2%;" class="paybtn" @click="addPayment2(20)">20</b-button>

                      <b-button
                        style="margin-left: 3%;"
                        class="paybtn"
                        @click="addPayment2(1000)"
                      >1,000</b-button>
                      <b-button class="paybtn" @click="addPayment2(500)">500</b-button>
                      <b-button class="paybtn" @click="addPayment2(200)">200</b-button>
                    </table>
                  </b-row>
                  <br />
                  <br />
                  <b-row>
                    <table>
                      <b-button style="margin-left: 3%;" class="paybtn" @click="addPayment1(7)">7</b-button>
                      <b-button class="paybtn" @click="addPayment1(8)">8</b-button>
                      <b-button class="paybtn" @click="addPayment1(9)">9</b-button>

                      <b-button style="margin-left: 3%;" class="paybtn" @click="addPayment1(4)">4</b-button>
                      <b-button class="paybtn" @click="addPayment1(5)">5</b-button>
                      <b-button class="paybtn" @click="addPayment1(6)">6</b-button>

                      <b-button style="margin-left: 3%;" class="paybtn" @click="addPayment1(1)">1</b-button>
                      <b-button class="paybtn" @click="addPayment1(2)">2</b-button>
                      <b-button class="paybtn" @click="addPayment1(3)">3</b-button>

                      <b-button style="margin-left: 3%;" class="paybtn" @click="addPayment1(0)">0</b-button>
                      <b-button class="paybtn" @click="forms.payment.fields.total_tendered = 0">CLEAR</b-button>
                      <b-button class="paybtn" @click="showModalPayment=false">CANCEL</b-button>

                      <b-button class="enter">ENTER</b-button>
                    </table>
                  </b-row>
                </div>
              </b-col>
            </b-row>
          </b-col>
        </div>
        <div slot="modal-footer"></div>
      </b-modal>
       
       <div> <!-- modal div -->
            <b-modal 
                v-model="showModalCardPayment"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('card_holder_name')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Add/Edit Card Payment<br>
          <small>Add or Edit Card Payment on invoice</small>
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form>
                    <b-form-group>
                        <label for="card_holder_name">* Card Holder Name:</label>
                        <b-form-input
                            id="card_holder_name"
                            v-model="forms.payment.fields.card_holder_name"
                            type="text"
                            placeholder="Card Holder Name"
                            ref="card_holder_name">
                        </b-form-input>
                    </b-form-group>
                   <b-form-group>
                    <label for="card_type_id">* Card Type</label>
                    <select2
                        ref="card_type_id"
                        :allowClear="false"
                        :placeholder="'Select Card Type'"
                        v-model="forms.pos.fields.card_type_id"
                    >
                        <option
                        v-for="ct in options.cardtypes.items"
                        :key="ct.card_type_id"
                        :value="ct.card_type_id"
                        >{{ct.card_type_name}}</option>
                    </select2>
                    </b-form-group>
                    <b-form-group>
                        <label>* Card No.:</label>
                        <b-form-input
                            ref="card_check_gc_no"
                            id="card_check_gc_no"
                            v-model="forms.payment.fields.card_check_gc_no"
                            type="text"
                            placeholder="Card no.">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>* Approval No.:</label>
                        <b-form-input
                            ref="card_approval_no"
                            id="card_approval_no"
                            v-model="forms.payment.fields.card_approval_no"
                            type="text"
                            placeholder="Approval no.">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                    <label>* Amount</label>
                    <vue-autonumeric
                      ref="payment_amount"
                      id="payment_amount"
                      v-model="forms.payment.fields.payment_amount"
                      type="text"
                      class="form-control text-right"
                      :options="[{ minimumValue: '0' , maximumValue: '200', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->
            </b-modal>
        </div> <!-- modal div -->


        <div> <!-- modal div -->
            <b-modal 
                v-model="showModalCheckPayment"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('card_type')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Add/Edit Check Payment<br>
          <small>Add or Edit Check Payment on invoice</small>
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form>
                   <b-form-group>
                    <label for="check_type_id">* Check Type</label>
                    <select2
                        ref="check_type_id"
                        :allowClear="false"
                        :placeholder="'Select Check Type'"
                        v-model="forms.payment.fields.check_type_id"
                    >
                        <option
                        v-for="ckt in options.checktypes.items"
                        :key="ckt.check_type_id"
                        :value="ckt.check_type_id"
                        >{{ckt.check_type_name}}</option>
                    </select2>
                    </b-form-group>
                    <b-form-group>
                        <label>* Check No.:</label>
                        <b-form-input
                            ref="card_check_gc_no"
                            id="card_check_gc_no"
                            v-model="forms.payment.fields.card_check_gc_no"
                            type="text"
                            placeholder="Check no.">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                    <label>* Amount</label>
                    <vue-autonumeric
                      ref="payment_amount"
                      id="payment_amount"
                      v-model="forms.payment.fields.payment_amount"
                      type="text"
                      class="form-control text-right"
                      :options="[{ minimumValue: '0' , maximumValue: '200', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->
            </b-modal>
        </div> <!-- modal div -->
       

         <div> <!-- modal div -->
            <b-modal 
                v-model="showModalGCPayment"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('card_type')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Add/Edit GC Payment<br>
          <small>Add or Edit GC Payment on invoice</small>
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form>
                   <b-form-group>
                    <label for="gc_type_id">* GC Type</label>
                    <select2
                        ref="gc_type_id"
                        :allowClear="false"
                        :placeholder="'Select GC Type'"
                        v-model="forms.payment.fields.gc_type_id"
                    >
                        <option
                        v-for="gct in options.gctypes.items"
                        :key="gct.gc_type_id"
                        :value="gct.gc_type_id"
                        >{{gct.gc_type_name}}</option>
                    </select2>
                    </b-form-group>
                    <b-form-group>
                        <label>* GC No.:</label>
                        <b-form-input
                            ref="card_check_gc_no"
                            id="card_check_gc_no"
                            v-model="forms.payment.fields.card_check_gc_no"
                            type="text"
                            placeholder="GC no.">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                    <label>* Amount</label>
                    <vue-autonumeric
                      ref="payment_amount"
                      id="payment_amount"
                      v-model="forms.payment.fields.payment_amount"
                      type="text"
                      class="form-control text-right"
                      :options="[{ minimumValue: '0' , maximumValue: '200', emptyInputBehavior:'0', decimalCharacter: '.'}]"
                    >></vue-autonumeric>
                  </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->
            </b-modal>
        </div> <!-- modal div -->
       

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "posystem",
  data() {
    return {
      entryMode: "Add",
      selectedRow: [],
      showModalEntry: false, //if true show modal
      showModalProducts: false,
      showModalCheckPayment: false,
      showModalCardPayment: false,
      showModalGCPayment:false,
      showModalQuantity: false,
      showModalDiscount: false,
      showModalDelete: false,
      showModalVoid: false,
      showModalPayment: false,
      showNationality: false,
      showModalIdType: false,
      forms: {
        quantity:{
          fields: {
            product_code: null,
            product_quantity: null,
            prev_quantity: null,
            product_rate: null,
            product_name: null
          }
        },
        pos: {
          isSaving: false,
          isDeleting: false,
          fields: {
            item: null,
            product_name: null,
            product_code: null,
            unit_name: null,
            product_cost: null,
            product_quantity: null,
            discount: null,
            total: null
          }
        },
        payment:{
          fields: {
            gc_type_id: null,
            charge_to: null,
            total_amount_due: null,
            total_tendered: null,
            total_change:null,
            check_type_id: null
          }
        },
         totchange:{
          fields: {
            total_amount_due: null,
            total_tendered: null,
            total_change:null,
          }
         }
      },
      tables: {
        posystem: {
          fields: [
            {
              key: "product_name",
              label: "Item Name",

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
              key: "product_rate",
              label: "Unit Price",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "product_quantity",
              label: "Quantity",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "discount",
              label: "Discount",

              tdClass: "align-middle",
              sortable: true
            },
            {
              key: "item_total",
              label: "Total",
              tdClass: "align-middle",
              sortable: true,
              formatter: (value, key, item) => {
                item.item_total = item.product_rate * item.product_quantity
                return this.formatNumber(item.item_total)
              }
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
              key: "product_rate",
              label: "Cost",
              tdClass: "align-middle",
              sortable: true,
              formatter: (value) => {
                  return this.formatNumber(value)
              }
            }
          ],
          items: []
        }
      },
      filters: {
        posystem: {
          criteria: null
        },
        products: {
          criteria: null
        }
      },
      paginations: {
        posystem: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        },
        products: {
          totalRows: 0,
          currentPage: 1,
          perPage: 10
        }
      },
       options: {
        cardtypes: {
          items: []
        },
        checktypes: {
          items: []
        },
        gctypes: {
          items: []
        }
       },
      pos_id: null,
      row: []
    };
  },
  methods: {
  //   onCategoryEntry() {
  //     if (this.entryMode == "Add") {
  //       this.createEntity("pos", true, "posystem");
  //     } else {
  //       this.updateEntity("pos", "pos_id", true, this.row);
  //     }
  //   },
    onPosDelete() {
      this.deleteEntity("pos", this.pos_id, true, "posystem", "pos_id");
    },
    async setDelete(data) {
      if ((await this.checkIfUsed("pos", data.item.pos_id)) == true) {
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text:
            "Unable to delete, this record is being used by other transactions."
        });
        return;
      }
      this.pos_id = data.item.pos_id;
      this.showModalDelete = true;
    },
  //   setUpdate(data) {
  //     this.row = data.item;
  //     this.resetFieldStates("pos");
  //     this.fillEntityForm("pos", data.item.pos_id);
  //     this.showModalEntry = true;
  //     this.entryMode = "Edit";
  //   }
  // },
  rowSelected() {
      if (this.selectedRow.length == 0) {
        console.log("notify");
        this.$notify({
          type: "error",
          group: "notification",
          title: "Error!",
          text: "Please select a product."
        });
        return;
      }
      this.forms.quantity.fields.unit_name = this.selectedRow[0].unit_name;
      this.forms.quantity.fields.product_id = this.selectedRow[0].product_id;
      this.forms.quantity.fields.product_code = this.selectedRow[0].product_code;
      this.forms.quantity.fields.product_name = this.selectedRow[0].product_name;
      this.forms.quantity.fields.product_rate = this.selectedRow[0].product_rate;
      (this.forms.quantity.fields.prev_quantity = 1),
      (this.forms.quantity.fields.product_quantity = 1),
        (this.forms.quantity.fields.product_total = this.selectedRow[0].product_rate);
      this.showModalQuantity = true;
    },
    acceptQuantity() {
      this.tables.posystem.items.push({
        product_id: this.forms.quantity.fields.product_id,
        product_code: this.forms.quantity.fields.product_code,
        product_name: this.forms.quantity.fields.product_name,
        product_rate: this.forms.quantity.fields.product_rate,
        product_quantity: this.forms.quantity.fields.product_quantity,
        item_total:
          this.forms.quantity.fields.product_rate *
          this.forms.quantity.fields.product_quantity,
        unit_name: this.forms.quantity.fields.unit_name
      });
      this.showModalQuantity = false;
    },
  removeProduct(index){
        this.tables.posystem.items.splice(index, 1)
    }
  },
 
  created() {
    this.$http.get('api/pos', {
        headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
        }
    }).then(response => {
        this.tables.products.items = response.data.products
        this.paginations.posystem.totalRows = response.data.products.length
        this.options.cardtypes.items = response.data.cardtypes
        this.options.checktypes.items = response.data.checktypes
        this.options.gctypes.items = response.data.gctypes
      
    }).catch(error => {
        console.log(error)
    })
  },
  computed: {
    getTotalItems() {
      this.forms.pos.fields.total_amount_due = 0;

      this.tables.posystem.items.forEach(item => {
        
            // console.log(item);
            this.forms.pos.fields.total_amount_due += Number(item.product_rate) * Number(item.product_quantity);
        
      });
      return parseFloat(this.forms.pos.fields.total_amount_due,2);
    }
  },
  getTotalPayment() {
      this.forms.payment.fields.payment_amount = 0;

      this.tables.posystem.items.forEach(item => {
        
            // console.log(item);
            this.forms.payment.fields.payment_amount += Number(item.card_type_id) + Number(item.check_type_id) + Number(item.gc_type_id) + Number(item.charge_to);
        
      });
      return parseFloat(this.forms.payment.fields.payment_amount,2);
    },
    getTotalChange() {
      this.forms.totchange.fields.total_change = 0;

      this.tables.posystem.items.forEach(item => {
        
            // console.log(item);
            this.forms.totchange.fields.total_change = Number(item.total_amount_due) - Number(item.total_tendered);
        
      });
      return parseFloat(this.forms.totchange.fields.change_total,2);
    }
  }
</script>
