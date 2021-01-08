<template>
    <div><!-- main container -->
        <notifications group="notification" />
        <div class="animated fadeIn"> <!-- main div -->
            <b-row> <!-- main row -->
                <b-col sm="12">
                    <b-card > <!-- main card -->
                        <h5 slot="header">  <!-- table header -->
                            <span class="text-primary">
                                <i class="fa fa-bars"></i> 
                                Card type List
                                <small class="font-italic">List of all registered card types.</small></span>
                        </h5>
                        
                        <b-row class="mb-2"> <!-- row button and search input -->
                            <b-col sm="4">
                                <b-button variant="primary" @click="showModalEntry = true, entryMode='Add', clearFields('cardtype')">
                                        <i class="fa fa-plus-circle"></i> Create New Card type
                                </b-button>
                            </b-col>

                            <b-col  sm="4">
                                <span></span>
                            </b-col>

                            <b-col  sm="4">
                                <b-form-input 
                                    v-model="filters.cardtypes.criteria"
                                    type="text" 
                                    placeholder="Search">
                                </b-form-input>
                            </b-col>
                        </b-row> <!-- row button and search input -->
                    
                        <b-row> <!-- row table -->
                            <b-col sm="12">
                                <b-table 
                                    responsive striped hover small bordered show-empty
                                    :filter="filters.cardtypes.criteria"
                                    :fields="tables.cardtypes.fields"
                                    :items.sync="tables.cardtypes.items"
                                    :current-page="paginations.cardtypes.currentPage"
                                    :per-page="paginations.cardtypes.perPage"
                                > <!-- table -->

                                <template slot="action" slot-scope="data"> <!-- action slot  :to="{path: 'cardtypes/' + data.item.id } -->
                                    <b-btn :size="'sm'" variant="primary" @click="setUpdate(data)">
                                        <i class="fa fa-edit"></i>
                                    </b-btn>

                                    <b-btn :size="'sm'" :disabled="forms.cardtype.isDeleting" variant="danger" @click="setDelete(data)">
                                        <icon v-if="forms.cardtype.isDeleting" name="sync" spin></icon>
                                        <i v-else class="fa fa-trash"></i>
                                    </b-btn>
                                </template>

                                </b-table> <!-- table -->
                            </b-col>
                        </b-row> <!-- row table -->

                        <b-row >  <!-- Pagination -->
                                <b-col sm="12" class="my-1">
                                    <b-pagination size="sm" align="right" :total-rows="paginations.cardtypes.totalRows" :per-page="paginations.cardtypes.perPage" v-model="paginations.cardtypes.currentPage"
                                     class="my-0" />
                                </b-col>
                        </b-row> <!-- Pagination -->
                        
                    </b-card><!-- main card -->
                </b-col>
            </b-row> <!-- main row -->

        </div><!-- main div -->

        <div> <!-- modal div -->
            <b-modal 
                v-model="showModalEntry"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
                @shown="focusElement('card_type_code')"
            >
            
            <div slot="modal-title"> <!-- modal title -->
                Unit Entry - {{entryMode}}
            </div> <!-- modal title -->

            <b-col lg=12> <!-- modal body -->
                <b-form @keydown="resetFieldStates('cardtype')" autocomplete="off">
                    <b-form-group>
                        <label>* Code</label>
                        <b-form-input
                            ref="card_type_code"
                            id="card_type_code"
                            v-model="forms.cardtype.fields.card_type_code"
                            type="text"
                            placeholder="Cardtype Code">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>* Card type Name</label>
                        <b-form-input
                            ref="card_type_name"
                            id="card_type_name"
                            v-model="forms.cardtype.fields.card_type_name"
                            type="text"
                            placeholder="Cardtype Name">
                        </b-form-input>
                    </b-form-group>
                    <b-form-group>
                        <label>Card type Desc</label>
                        <b-form-input
                            ref="card_type_desc"
                            id="card_type_desc"
                            v-model="forms.cardtype.fields.card_type_desc"
                            type="text"
                            placeholder="Cardtype Desc">
                        </b-form-input>
                    </b-form-group>
                     <b-form-group>
                    <label>Sort</label>
                        <b-form-input
                            ref="sort_key"
                            id="sort_key"
                            v-model="forms.cardtype.fields.sort_key"
                            type="number"
                            placeholder="Sort Key">
                        </b-form-input>
                    </b-form-group>
                </b-form>
            </b-col> <!-- modal body -->

            <div slot="modal-footer"><!-- modal footer buttons -->
                <b-button :disabled="forms.cardtype.isSaving" variant="primary" @click="onCardtypesEntry">
                    <icon v-if="forms.cardtype.isSaving" name="sync" spin></icon>
                    <i class="fa fa-check"></i>
                    Save
                </b-button>
                <b-button variant="secondary" @click="showModalEntry=false">Close</b-button>
            </div> <!-- modal footer buttons -->

            </b-modal>
            <b-modal 
                v-model="showModalDelete"
                :noCloseOnEsc="true"
                :noCloseOnBackdrop="true"
            >
                <div slot="modal-title">
                    Delete Cardtype
                </div>
                <b-col lg=12>
                    Are you sure you want to delete this card type?
                </b-col>
                <div slot="modal-footer">
                    <b-button :disabled="forms.cardtype.isSaving" variant="primary" @click="onCardtypesDelete">
                        <icon v-if="forms.cardtype.isSaving" name="sync" spin></icon>
                        <i class="fa fa-check"></i>
                        OK
                    </b-button>
                    <b-button variant="secondary" @click="showModalDelete=false">Close</b-button>            
                </div>
            </b-modal>
        </div> <!-- modal div -->

    </div> <!-- main container -->

   
</template>

<script>
export default {
    name: 'cardtypes',
    data () {
      return {
        entryMode: 'Add',
        showModalEntry: false, //if true show modal
        showModalDelete: false,
        forms:{
            cardtype : {
                isSaving: false,
                isDeleting: false,
                fields: {
                   card_type_id: null,
                    card_type_code: null,
                    card_type_name: null,
                    card_type_desc: null,
                    sort_key: 0
                }
            }
        },
        tables: {
            cardtypes: {
                fields: [
                {
                    key: 'card_type_code',
                    label: 'Code',
                    thStyle: {width: '150px'},
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'card_type_name',
                    label: 'Cardtype Name',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'card_type_desc',
                    label: 'Cardtype Desc',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {
                    key: 'sort_key',
                    label: 'Sort',
                    tdClass: 'align-middle',
                    sortable: true
                },
                {   
                    key: 'action',
                    label: '',
                    thStyle: {width: '80px'},
                    tdClass: 'text-center'
                },
                ],
                items: []
            }
        },
        filters: {
          cardtypes: {
            criteria: null
          }
        },
        paginations: {
          cardtypes: {
            totalRows: 0,
            currentPage: 1,
            perPage: 10
          }
        },
        department_id: null,
        row: []
      }
    },
    methods:{
        onCardtypesEntry () {
            if(this.entryMode == 'Add'){
                this.createEntity('cardtype', true, 'cardtypes')
            }
            else{
                this.updateEntity('cardtype', 'card_type_id', true, this.row)
            }
        },
        onCardtypesDelete(){
            this.deleteEntity('cardtype', this.card_type_id, true, 'cardtypes', 'card_type_id')
        },
        async setDelete(data){
            if(await this.checkIfUsed('cardtype', data.item.card_type_id) == true){
                this.$notify({
                    type: 'error',
                    group: 'notification',
                    title: 'Error!',
                    text: "Unable to delete, this record is being used by other transactions."
                })
                return
            }
            this.card_type_id = data.item.card_type_id
            this.showModalDelete = true
        },
        setUpdate(data){
            this.row = data.item
            this.resetFieldStates('cardtype')
            this.fillEntityForm('cardtype', data.item.card_type_id)
            this.showModalEntry=true
            this.entryMode='Edit'
        }
    },
    created () {
      this.fillTableList('cardtypes')
    }
  }
</script>

