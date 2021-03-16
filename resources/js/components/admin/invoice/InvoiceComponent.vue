<template>
    <div class="uk-container">
        <div class="uk-width-1-1">
            <ul class="uk-breadcrumb">
                <li><a href="#">Home</a></li>
                <li><router-link :key="company.id" :to="{ name: 'showCompany', params: { companyID: company.id }}" >{{ company.name }}</router-link></li>
                <li><a>Счета</a></li>
            </ul> 
            <app-navigation v-bind:user="userID" v-bind:company="company.id"></app-navigation>
            <div uk-grid>
                <div class="uk-width-1-1">
                    <div class="uk-card">
                    <div class="uk-card-header uk-flex uk-flex-middle uk-flex-between">
                        <h3 class="uk-card-title uk-margin-remove">Счета {{ company.name }} </h3>

                        <div>
                            <button
                                class="uk-button uk-button-primary"
                                type="button"
                                uk-toggle="target: #addNew"
                                @click="getInvoiceNumber()"
                            >
                                Добавить счет
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0" v-if="company.invoices != 0">
                        <table class="uk-table" style="text-align: center">
                            <tbody>
                                <tr>
                                    <th>№</th>
                                    <th>Дата</th>
                                    <th>Клиент</th>
                                    <th>Сумма</th>
                                    <th>Оплачен</th>
                                    <th>Акт</th>
                                    <th>УПД</th>
                                    <th>Товарная накладная</th>
                                    <th>Счет-фактура</th>
                                </tr>

                                <tr v-for="invoice in company.invoices" :key="invoice.id">
                                    <td v-if="invoice.number != null">
                                        <router-link :key="company.id" :to="{ name: 'showInvoice', params: { companyID: company.id, invoiceID:invoice.id  }}" >{{ invoice.number.invoice_number }}</router-link>
                                    </td>
                                    <td v-else>Ошибка!</td>
                                    <td>{{ moment(invoice.date).locale('ru').format('LL') }}</td>
                                
                                    <td v-if="invoice.customer != 0">
                                        {{ invoice.customer.name }}
                                    </td>
                                    <td v-else>
                                    Ошибка
                                    </td>
                                    <td>{{ invoice.invoice_total | currency }}</td>
                                    <td v-if="invoice.paid ==1 || invoice.paid != null" class="uk-text-success">Оплачен</td>
                                    <td v-else><button class="uk-button uk-button-link uk-text-danger" @click="changePaidStatus(invoice.id)">Не оплачен</button></td>
                                    <td v-if="invoice.acceptance_certificate != null">
                                        <router-link :key="company.id" :to="{ name: 'ShowAcceptanceCertificate', params: { userID:userID, companyID: companyID, acceptance_certificateID:invoice.acceptance_certificate.id  }}" >{{ invoice.acceptance_certificate.number }}</router-link>
                                    </td>
                                    <td v-else>
                                        <button class="uk-button uk-button-link" @click="createAcceptanceCertificate(invoice.id)">Добавить</button>
                                    </td>
                                    <td v-if="invoice.packing_list_id != null">
                                        {{ invoice.packing_list_id }}
                                    </td>
                                    <td v-else>
                                        <a href="" class="uk-button uk-button-link">Добавить</a>
                                    </td>
                                    <td v-if="invoice.packing_list_id != null">
                                        {{ invoice.packing_list_id }}
                                    </td>
                                    <td v-else>
                                        <a href="" class="uk-button uk-button-link">Добавить</a>
                                    </td>
                                    <td v-if="invoice.vat_invoice_id != null">
                                        {{ invoice.vat_invoice_id }}
                                    </td>
                                    <td v-else>
                                        <a href="" class="uk-button uk-button-link">Добавить</a>
                                    </td>
                                    <td>
                                        <a href="#" data-id="invoice.id" @click="editModalWindow(invoice)">
                                            <span uk-icon="pencil"></span>
                                        </a>
                                        <span>|</span>
                                        <button @click="deleteInvoice(invoice.id)" class="uk-button uk-button-link uk-text-danger" uk-icon="close">
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body table-responsive p-0" v-else>Нет счетов</div>
                    <div class="uk-card-footer"></div>
                    </div>
                </div>
            </div>
        </div>

        <div id="addNew"  uk-modal  class="uk-modal-container" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
              <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">
                            Новый счет
                        </h5>
                        <h5 v-show="editMode" class="modal-title" id="addNewLabel" >
                            Редактировать счет
                        </h5>
                    </div>

                    <form @submit.prevent="editMode ? updateInvoice() : createInvoice()" >
                      <div class="uk-modal-body">
                        <div class="uk-margin  uk-flex uk-flex-left uk-flex-middle">
                            <label for="">Исходящий счет № </label>
                            <input
                                v-model="form.invoice_number"
                                type="text"
                                name="invoice_number"
                                placeholder="Number"
                                class="uk-input uk-width-1-6 uk-margin-small-left uk-margin-medium-right"
                                :class="{
                                    'uk-text-danger': form.errors.has('invoice_number')
                                }"
                            
                            />
                            <has-error
                                :form="form"
                                field="invoice_number"
                            ></has-error>
                        
                            <label for="">от</label>
                            <date-picker 
                                v-model="form.date" 
                                name="date"
                                input-class="uk-input uk-margin-small-left" 
                                :class="{
                                    'is-invalid': form.errors.has('date')
                                }"  
                                type="date"
                                :format = dateFormat
                                @change="setDate()"
                            >
                            </date-picker>
                            <has-error
                                :form="form"
                                field="date"
                            ></has-error>
                        </div>

                        <div class="uk-margin uk-flex uk-flex-between uk-flex-middle">
                            <label for="">Клиент</label>
                            <select
                                v-model="form.customer_id"
                                type="text"
                                name="customer_id"
                                placeholder="Customer"
                                class="uk-select uk-width-3-4"
                                :class="{
                                    'is-invalid': form.errors.has('customer_id')
                                }"
                                @change="setCustomer()"
                            >
                                <option default disabled value="0">Выбрать</option>
                                <option value="add">Добавить клиента</option>
                                <option v-for="customer in company.customers" :key="customer.id" v-bind:value="customer.id" :selected="customer.id === company.customers">
                                    {{customer.name}}
                                </option>
                            </select>
                            <has-error
                                :form="form"
                                field="customers"
                            ></has-error>
                            
                        </div>
                        <table class="uk-table uk-table-middle">
                            <thead>
                                <th>#</th>
                                <th>№</th>
                                <th>Название продукта</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>НДС</th>
                                <th>Сумма</th>
                            </thead>
                            <tbody>
                                <tr v-for="(invoice_product, k) in form.invoice_products" :key="k">
                                    <td>
                                        <span class="uk-text-danger" uk-icon="icon: trash" @click="deleteRow(k, invoice_product)"></span>
                                    </td>
                                    <td>
                                        {{ invoice_product.product_no }}
                                    </td>
                                    <td>
                                        <select name="product_id" class="uk-select" v-model="invoice_product.product_id" @change="setProduct(invoice_product)">
                                            <option default disabled value="0">Выбрать</option>
                                            <option value="add">Добавить продукт</option>
                                            <option v-for="product in company.products" :key="product.id" :value="product.id" :selected="product.id === company.products">
                                                {{ product.title }}
                                            </option>
                                            <option value="selectProduct">Список продуктов</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="uk-input" name="product_price" type="number" min="0" step=".01" v-model="invoice_product.product_price" @change="calculateLineTotal(invoice_product)"
                                        />
                                    </td>
                                    <td>
                                        <input class="uk-input" name="product_qty" type="number" min="0" step="1" v-model="invoice_product.product_qty" @change="calculateLineTotal(invoice_product)"
                                        />
                                    </td>
                                    <td>
                                        <select name="product_tax" v-model="invoice_product.product_tax" class="uk-select uk-width-1-1" @change="calculateTotal(invoice_product)" :class="{
                                                'is-invalid': form.errors.has('product_tax')
                                            }">
                                            <option value="0">Без НДС</option>
                                            <option value="10">10%</option>
                                            <option default selected  value="20">20%</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="uk-input" name="product_total" type="number" min="0" step=".01" v-model="invoice_product.line_total" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="uk-margin">
                            <a class="uk-button uk-button-primary" @click="addNewRow"><span uk-icon="icon: plus"></span>Add row</a>
                        </div>   
                        <div class="uk-flex uk-flex-column uk-flex-bottom">
                            <div class="uk-margin">
                                Итого: {{ form.invoice_subtotal | currency }}    
                            </div>   
                            <div class="uk-margin">
                                НДС сверху: {{ form.invoice_tax | currency }}    
                            </div>
                            <div class="uk-margin">
                                Всего к оплате: {{ form.invoice_total | currency }}    
                            </div>  
                        </div>                     
      
                      </div>
                      <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                          >
                              Close
                          </button>
                          <button
                              v-show="editMode"
                              type="submit"
                              class="uk-button uk-button-primary"
                          >
                              Update
                          </button>
                          <button
                              v-show="!editMode"
                              type="submit"
                              class="uk-button uk-button-primary"
                          >
                              Create
                          </button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="addCustomer" uk-modal  class="uk-modal-container" >
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
                <button class="uk-modal-close-default" type="button" @click="closeaddCustomer()" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h5 class="modal-title" id="addNewLabel">
                            Создать клиента
                        </h5>
                    </div>
                        <form >
                            <div class="uk-margin">
                                <input type="text" name="customer_inn" v-model="customer_inn" class="uk-input" placeholder="Введите ИНН для поиска" @change="loadCustomer()">
                                <div class="uk-margin">
                                    <span v-if="customer_exist == true" class="uk-text-success">Клиент с таким ИНН уже существует</span>
                                    <span v-if="customer_inn_error == true" class="uk-text-danger">Введите корректный ИНН</span>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_name" placeholder="Название организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_kpp" placeholder="КПП организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_legal" placeholder="Юридический адрес организации" readonly> 
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_director" placeholder="Директор оганизации" readonly>
                            </div>
                            <h5>Банковские реквизиты</h5>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_rs" placeholder="Расчетный счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_bic" placeholder="БИК банка" @change="loadBank()">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_ks" placeholder="Кор. счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_name" placeholder="Наименование банка">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_legal" placeholder="Адрес банка">
                            </div>
                        </form>
                    
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closeaddCustomer()"
                          >
                              Close
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="createCustomer()"
                              v-show="!customer_exist"
                          >
                              Create
                          </button>
                      </div>
                </div>
                
            </div>
        </div>
        <div id="changePaidStatus" uk-modal  class="uk-modal-container" >
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
              <button class="uk-modal-close-default" type="button" @click="closePaidStatus()" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h5 class="modal-title" id="addNewLabel">
                           Счет № {{ invoice_number }}
                        </h5>
                    </div>
                        <form >
                            <div class="uk-margin">
                                <label for="">Дата оплаты</label>
                                <date-picker 
                                    v-model="form.date" 
                                    name="date"
                                    input-class="uk-input uk-margin-small-left" 
                                    :class="{
                                        'is-invalid': form.errors.has('date')
                                    }"  
                                    type="date"
                                    :format = dateFormat
                                    @change="setDate()"
                                >
                                </date-picker>
                            </div>
                            <div class="uk-margin">
                                <label for="">Оплачен</label>
                                <input type="checkbox" class="uk-checkbox">
                            </div>
                        </form>
                    
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closePaidStatus()"
                          >
                              Close
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="setPaidStatus()"
                          >
                              Set
                          </button>
                      </div>
                </div>
                
            </div>
        </div>
        <div id="addProduct" uk-modal  class="uk-modal-container" >
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
              <button class="uk-modal-close-default" type="button" @click="closeAddProduct()" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h5 class="modal-title" id="addNewLabel">
                           Добавить продукт
                        </h5>
                    </div>
                        <form >
                            <div class="uk-margin">
                                <label for="">Наименование</label>
                                <input type="text" class="uk-input" v-model="product_title">
                            </div>
                            <div class="uk-margin">
                                <label for="">Категория</label>
                                <select  class="uk-select" v-model="product_category">
                                    <option default disabled value>Выбрать</option>
                                    <option value="add">Добавить</option>
                                    <option v-for="product_category in company.product_categories" :key="product_category.id" :value="product_category.id"  >{{ product_category.title }}</option>
                                </select>
                            </div>
                            <div class="uk-margin">
                                <label for="">Цена</label>
                                <input type="number" min="0" step=".01" class="uk-input" v-model="product_price">
                            </div>
                            <div class="uk-margin">
                                <label for="">НДС</label>
                                <select name="" class="uk-select" v-model="product_tax">
                                    <option value="20">20%</option>
                                    <option value="18">18%</option>
                                    <option value="10">10%</option>
                                    <option value="0">Без НДС</option>
                                </select>
                            </div>
                            <div class="uk-margin">
                                <label for="">Ед. измерения</label>
                                <select name="" class="uk-select" v-model="product_unit">
                                    <option value="шт.">шт.</option>
                                    <option value="ед.">ед.</option>
                                    <option value="усл.">усл.</option>
                                </select>
                            </div>
                        </form>
                    
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closeAddProduct()"
                          >
                              Закрыть
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="createProduct()"
                          >
                              Создать
                          </button>
                      </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ru';
import moment from "moment";
import Navigation from "../../Navigation.vue";
export default {
    props: ['companyID', 'userID'],
    
    data() {
        return {
            dateFormat: moment().locale('ru').format('LL'), 
            editMode: false,
            company: {},
            token: process.env.MIX_DADATA_API_KEY,
            form: new Form({
                company_id: this.companyID,
                user_id: this.userID,
                invoice_number: 0,
                date: '',
                customer_id: 0,
                invoice_subtotal: 0,
                invoice_total: 0,
                invoice_tax: 0,
                invoice_products: [{
                    product_no: 1,
                    product_id: 0,
                    product_price: '',
                    product_qty: '',
                    product_tax: '',
                    line_total: 0
                }],
            }),
            customer_exist: false,
            customer_inn_error: false,
            customer_inn: '',
            customer_name: '',
            customer_kpp: '',
            customer_legal: '',
            customer_director: '',
            customer_director_post: '',
            customer_full_name: '',
            customer_bank_bic: '',
            customer_bank_name: '',
            customer_bank_rs: '',
            customer_bank_ks: '',
            customer_bank_legal: '',
            invoice_product_id: '',
            invoice_number: '',
            product_title: '',
            product_category: 1,
            product_tax: '',
            product_price: '',
            product_unit: '',
        };
        
    },
   
    methods: {
        editModalWindow(invoice) {
            this.form.clear();
            this.editMode = true;
            this.form.reset();
            UIkit.modal("#addNew").show();
            this.getInvoiceNumber(invoice)
            console.log(this.form.invoice_number);
            let invoice_number = this.form.invoice_numberis
            this.form.fill(invoice, invoice_number)
        },

        updateInvoice() {
            this.form
                .put("api/invoice/" + this.form.id)
                .then(() => {
                    Toast.fire({
                        icon: "success",
                        title: "Invoice updated successfully"
                    });

                    Fire.$emit("AfterCreatedInvoiceLoadIt");

                    UIkit.modal("#addNew").hide();
                })
                .catch(() => {
                    console.log("Error.....");
                });
        },
        openModalWindow() {
            this.editMode = false;
            this.form.reset();
            UIkit.modal("#addNew").show();
        },
        setDate(){
            if(editMode = false){
                this.form.date = new Date()
            } else {
                
            }

            this.dateFormat = moment(this.form.date).locale('ru').format('LL')
        },
        async loadCompany(){
            const response = await axios.get('/api/user/' + this.userID + '/company/' + this.companyID)
            this.company = response.data
        },
        addNewRow() {
            this.form.invoice_products.push({
                product_no: this.form.invoice_products.length + 1 ,
                product_id: 0,
                product_price: '',
                product_qty: '',
                product_tax: '',
                line_total: 0
            });
            
        },
        deleteRow(index, invoice_product) {
            var idx = this.form.invoice_products.indexOf(invoice_product);
            if (idx > -1) {
                this.form.invoice_products.splice(idx, 1);
            }
            this.calculateTotal();
        },
        createInvoice() {
            this.$Progress.start();
            this.form
                .post('/api/user/' + this.userID + '/company/' + this.companyID + '/invoice/')
                .then((res) => {
                    Fire.$emit("AfterCreatedInvoiceLoadIt"); //custom events
                    Toast.fire({
                        icon: "success",
                        title: "Invoice created successfully"
                    });
                    if(res.status === 200) {
                    }
                    this.$Progress.finish();
                    this.form.reset();
                    this.form.date = new Date()
                    UIkit.modal("#addNew").hide();
                    this.loadCompany();
                })
        },
        deleteInvoice(id) {
            Swal.fire({
                title: "Удалить счет?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Да, удалить"
            }).then(result => {
                if (result.value) {
                    //Send Request to server
                    this.form
                        .delete("api/invoice/" + id)
                        .then(response => {
                            Swal.fire(
                                "Deleted!",
                                "User deleted successfully",
                                "success"
                            );
                            this.loadCompany();
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: "<a href>Why do I have this issue?</a>"
                            });
                        });
                }
            });
        },
        setProduct(invoice_product) {
            let id = invoice_product.invoice_id
            console.log('before ' + this.company.products.length);
            
            if(invoice_product.product_id == 'add') {
                this.$Progress.start();
                    UIkit.modal("#addNew").hide();
                    UIkit.modal("#addProduct").show();
                    this.invoice_product_id = invoice_product.product_no
                this.$Progress.finish();
            }  else {
                console.log('setProduct');
                this.getProductPrice(invoice_product)
            }
        },
        async createProduct() {
            let invoice_products = this.form.invoice_products
            const formData = new FormData()
            formData.append('company_id', this.companyID)
            formData.append('title', this.product_title)
            formData.append('unit', this.product_unit)
            formData.append('product_category_id', this.product_category)
            formData.append('price', this.product_price)
            formData.append('tax', this.product_tax)

            const response = await axios.post('/api/user/' + this.userID + '/company/' + this.companyID + '/product', formData)
            if( response.status !== 200 ) { 
                console.log('error...');
                    
            }
            await this.loadCompany()
                     
            this.product_title = ''
            this.product_unit = ''
            this.product_category = 1
            this.product_price = ''
            this.product_tax = ''

            let product_id = response.data.id
            for (let i = 0; i < invoice_products.length; i++) {
            
                if(this.invoice_product_id == invoice_products[i].product_no) {
                    invoice_products[i].product_id = product_id
                    console.log('createProduct');
                    this.getProductPrice(invoice_products[i])
                    break
                }  
            }
            UIkit.modal("#addProduct").hide();
            UIkit.modal("#addNew").show();
               
        },
        closeAddProduct() {
            let invoice_products = this.form.invoice_products
            this.$Progress.start();
                for (let i = 0; i < invoice_products.length; i++) {
                    if(this.invoice_product_id === invoice_products[i].product_no) {
                        invoice_products[i].product_id = 0
                    }
                }
                UIkit.modal("#addProduct").hide();
                UIkit.modal("#addNew").show();
            this.$Progress.finish();
        },
        
        getProductPrice(invoice_product) {
                let id = invoice_product.product_id
                
                let products = this.company.products
                let k = products.length + 1 
                let price
                console.log(invoice_product);

                for(let i = 0; i < products.length; i++) {
                    if(products[i].id == id) {
                        invoice_product.product_price = parseFloat(products[i].price.toFixed(2));
                        invoice_product.product_tax = products[i].tax
                        invoice_product.product_qty = 1
                        break;
                    } 
                }
               
            this.calculateLineTotal(invoice_product)
            
        },
        calculateLineTotal(invoice_product) {
            let total = parseFloat(invoice_product.product_price) * parseFloat(invoice_product.product_qty);
            if (!isNaN(total)) {
                invoice_product.line_total = total.toFixed(2);
            }
            
            this.calculateTotal();
        },
        calculateTotal() {
            let subtotal, total;
            subtotal = this.form.invoice_products.reduce(function (sum, product) {
                let lineTotal = parseFloat(product.line_total);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0); 

            this.form.invoice_subtotal = subtotal.toFixed(2);

            let tax;
            tax = this.form.invoice_products.reduce(function(tax, product) {
                let subtax = product.product_tax/100 *  product.line_total
                let lineTax = parseFloat(subtax)
                if (!isNaN(lineTax)) {
                    return tax + lineTax;
                }
            }, 0);
            this.form.invoice_tax = tax.toFixed(2);

            total = subtotal + tax;
            total = parseFloat(total);
            if (!isNaN(total)) {
                this.form.invoice_total = total.toFixed(2);
            } else {
                this.form.invoice_total = '0.00'
            }
        },
        getInvoiceNumber(invoice) {
            let number 
            let invoices = this.company.invoices
            if(this.editMode == false) {
                if(invoices != undefined && invoices.length){
                    number = invoices.length + 1
                    for(let i = 0; i < invoices.length; i++) {
                        let num = this.company.invoices[i].number.invoice_number
                        if(num == number ){
                            number = number + 1
                        }
                    this.form.invoice_number = number 
                    }
                } else {
                    this.form.invoice_number = 1
                }
                this.form.date = new Date()
            } else {
                this.form.invoice_number = invoice.number.invoice_number + 0
                console.log(this.form.invoice_number);
            }
            
        },
        setCustomer() {
            if (this.form.customer_id == 'add') {
                this.$Progress.start();
                    UIkit.modal("#addNew").hide();
                    UIkit.modal("#addCustomer").show();
                    this.loadCustomer();
                this.$Progress.finish();
            }
        },
        loadCustomer(){
            this.customer_exist = false
            this.customer_inn_error = false
            let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
            let query = this.customer_inn;
            let customers = this.company.customers
            
            for (let i = 0; i < customers.length; i++) {
                if (query == customers[i].inn) {
                    this.customer_exist = true
                    break
                } 
            }
            var options = {
                method: "POST",
                mode: "cors",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + this.token
                    },
                body: JSON.stringify({query: query})
            }
            if(this.customer_exist === false && query != 0) {
                fetch(url, options)
                    .then(response => response.json())
                    .then( result => {
                        if (result.suggestions.length == 0) {
                            this.customer_inn_error = true
                        } else {
                            this.customer_name = result.suggestions[0].value
                            this.customer_kpp = result.suggestions[0].data.kpp
                            this.customer_legal = result.suggestions[0].data.address.unrestricted_value
                            this.customer_director = result.suggestions[0].data.management.name
                            this.customer_director_post = result.suggestions[0].data.management.post
                            this.customer_full_name = result.suggestions[0].data.name.full_with_opf 
                        }
                        
                    })
                    .catch(error => console.log("error", error));
                }
            
                    
        },
        loadBank() {
            var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
            var query = this.customer_bank_bic;

            var options = {
                method: "POST",
                mode: "cors",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + this.token
                },
                body: JSON.stringify({query: query})
            }

            fetch(url, options)
                .then(response => response.json())
                .then(result => {
                    this.customer_bank_name = result.suggestions[0].data.name.payment
                    this.customer_bank_ks = result.suggestions[0].data.correspondent_account
                    this.customer_bank_legal = result.suggestions[0].data.address.value
                    })
                .catch(error => console.log("error", error));
        },
        createCustomer(){
            const formData = new FormData()
            formData.append('company_id', this.companyID)
            formData.append('name', this.customer_name)
            formData.append('full_name', this.customer_full_name)
            formData.append('director_name', this.customer_director)
            formData.append('director_post', this.customer_director_post)
            formData.append('inn', this.customer_inn)
            formData.append('kpp', this.customer_kpp)
            formData.append('legal_addres', this.customer_legal)
            formData.append('bank', this.customer_bank_name)
            formData.append('bic', this.customer_bank_bic)
            formData.append('ks', this.customer_bank_ks)
            formData.append('rs', this.customer_bank_rs)
            axios
                .post('/api/user/' + this.userID + '/company/' + this.companyID + '/customer/', formData)
                .then((res) => {
                    if(res.status === 200) {
                        this.loadCompany();
                        console.log(res.data);
                        
                        this.form.customer_id = res.data.id
                        UIkit.modal("#addCustomer").hide();
                        UIkit.modal("#addNew").show();
                    }
                })
        },
        closeaddCustomer(){
            this.form.customer_id = 0
            UIkit.modal("#addCustomer").hide();
            UIkit.modal("#addNew").show();
        },
        changePaidStatus(id) {
            let invoices = this.company.invoices
            
            for(let i = 0; i < invoices.length; i++) {
                if(invoices[i].id == id) {
                        let paid_status = invoices[i].paid  
                        paid_status = 1
                        const formData = new FormData()
                        formData.append('id', id)
                        formData.append('paid', paid_status)
                        axios
                            .put("api/invoice/" + id, formData)
                            .then((res) => {
                                if(res.status === 200) {
                                    this.loadCompany();
                                    console.log(res.data);
                                }
                            })
                        break;
                    }
            }

        },
        closePaidStatus() {
            UIkit.modal("#changePaidStatus").hide();
        },
        createAcceptanceCertificate(id) {
            let invoices = this.company.invoices
            
            for(let i = 0; i < invoices.length; i++) {
                if(invoices[i].id == id) {
                    let customer_id = invoices[i].customer.id
                    let number
                    if (this.company.acceptance_certificates.length != undefined && this.company.acceptance_certificates.length) {
                        for(let i = 0; i < this.company.acceptance_certificates.length; i++){
                            number = this.company.acceptance_certificates[i].number
                        }
                        number += 1
                    } else {
                        number = 1
                    }
                    
                    let subtotal = invoices[i].invoice_subtotal
                    let tax = invoices[i].invoice_tax
                    let total = invoices[i].invoice_total
                    const formData = new FormData()
                    formData.append('invoice_id', id)
                    formData.append('number', number)
                    formData.append('date', new Date())
                    formData.append('company_id', this.companyID)
                    formData.append('user_id', this.userID)
                    formData.append('customer_id', customer_id)
                    formData.append('subtotal', subtotal)
                    formData.append('tax', tax)
                    formData.append('total', total)
                    axios
                        .post('/api/user/' + this.userID + '/company/' + this.companyID + '/acceptance_certificate', formData)
                        .then((res) => {
                                if(res.status === 200) {
                                    this.loadCompany();
                                }
                            })

                }
            }
        }
    },
    
    created() {
        this.$Progress.start();
            this.loadCompany();
        
        //this.loadCustomers();
        Fire.$on("AfterCreatedInvoiceLoadIt", () => {
            //custom events fire on
            this.loadCompany();
        });
        this.$Progress.finish();
    },
    components: {
        DatePicker, 
        appNavigation: Navigation,
    },
};
</script>