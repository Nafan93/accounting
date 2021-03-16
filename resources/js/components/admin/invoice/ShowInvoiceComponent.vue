<template>
    <div>
        <app-navigation v-bind:user="userID" v-bind:company="companyID"></app-navigation>
        <div class="uk-container uk-margin-small-top">
            <ul class="uk-breadcrumb">
                <li v-if="invoice.company != undefined">
                    <router-link :key="companyID" :to="{ name: 'showCompany', params: { companyID: companyID }}" >{{ invoice.company.name }}</router-link>
                </li>
                <li>
                    <router-link :key="companyID" :to="{ name: 'Invoice', params: { companyID: companyID, userID: userID}}" >Счета</router-link>
                </li>
                <li v-if="invoice.number != undefined">
                    <span>Счет № {{ invoice.number.invoice_number }} от {{ moment(invoice.date).locale('ru').format('LL') }}</span>
                </li>
            </ul> 
            <div uk-grid>
                <div class="uk-width-3-4">
                    <div id="document" class="document">
                        <table  border="2" style="border-collapse: collapse; width: 700px" cellpadding="2" cellspacing="2">
                            <tr style="">
                                <td colspan="2" rowspan="2" style="min-height:13mm; width: 105mm;">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="height: 13mm;">
                                        <tr>
                                            <td valign="top" v-if="invoice.company != undefined">
                                                <div>{{ invoice.company.bank }} <br> </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="bottom" style="height: 3mm;">
                                                <div style="font-size:10pt;">Банк получателя</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="min-height:7mm;height:auto; width: 25mm;">
                                    <div>БИK</div>
                                </td>
                                <td rowspan="2" style="vertical-align: top; width: 60mm;" v-if="invoice.company != undefined">
                                    <div style=" height: 7mm; line-height: 7mm; vertical-align: middle;">{{ invoice.company.bic }}</div>
                                    <div>{{ invoice.company.ks }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25mm;">
                                    <div>Сч. №</div>
                                </td>
                            </tr>
                            <tr>
                                <td style="min-height:6mm; height:auto; width: 50mm;" v-if="invoice.company != undefined">
                                    <div>ИНН {{ invoice.company.inn }}</div>
                                </td>
                                <td style="min-height:6mm; height:auto; width: 55mm;" v-if="invoice.company != undefined">
                                    <div>КПП {{ invoice.company.kpp }}</div>
                                </td>
                                <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 25mm;">
                                    <div>Сч. №</div>
                                </td>
                                <td rowspan="2" style="min-height:19mm; height:auto; vertical-align: top; width: 60mm;">
                                    <div v-if="invoice.company != undefined">{{ invoice.company.rs }}</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="min-height:13mm; height:auto;">

                                    <table border="0" cellpadding="0" cellspacing="0" style="height: 13mm; width: 105mm;">
                                        <tr>
                                            <td valign="top" v-if="invoice.company != undefined">
                                                <div>{{ invoice.company.full_name }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="bottom" style="height: 3mm;">
                                                <div style="font-size: 10pt;">Получатель</div>
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                        <br>
                        <div style="font-weight: bold; font-size: 25pt; text-align: center; width: 700px" v-if="invoice.company != undefined">
                            Счет № {{ invoice.number.invoice_number }} от {{ moment(invoice.date).locale('ru').format('LL') }}
                        </div>
                        <br>
                        <div style="background-color:#000000; width:700px; font-size:1px; height:2px;">&nbsp;</div>
                        <table width="700px">
                            <tr v-if="invoice.company != undefined">
                                <td style="width: 30mm; vertical-align: top;">
                                    <div style=" padding-left:2px; ">Поставщик:   </div>
                                </td>
                                <td>
                                    <div style="font-weight:bold;  padding-left:2px;">
                                        <span>{{ invoice.company.full_name }} ИНН {{ invoice.company.inn }}, КПП {{ invoice.company.kpp }},</span>
                                        <br>
                                        <span style="font-weight: normal;"> {{ invoice.company.legal_addres }} </span>          
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="invoice.customer != undefined">
                                <td style="width: 30mm; vertical-align: top;">
                                    <div style=" padding-left:2px;">Покупатель:    </div>
                                </td>
                                <td>
                                    <div style="font-weight:bold;  padding-left:2px;">
                                        <span>{{ invoice.customer.full_name }} ИНН {{ invoice.customer.inn }}, КПП {{ invoice.customer.kpp }},</span>
                                        <br> 
                                        <span style="font-weight: normal;"> {{ invoice.customer.legal_addres }} </span>           
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <table border="2" width="700px" cellpadding="2" cellspacing="2" style="border-collapse: collapse; width: 700зч;">
                            <thead>
                            <tr>
                                <th style="width:13mm; ">№</th>
                            
                                <th>Товары (работы, услуги)</th>
                                <th style="width:20mm; ">Кол-во</th>
                                <th style="width:17mm; ">Ед.</th>
                                <th style="width:27mm;  ">Цена</th>
                                <th style="width:27mm;  ">Сумма</th>
                            </tr>
                            </thead>
                            <tbody >
                            <tr v-for="line_product in lines" :key="line_product.id">
                                <td style="width:13mm; ">{{ line_product.product_no }}</td>
                            
                                <td>{{ line_product.product_title }}</td>
                                <td style="width:20mm; ">{{ line_product.product_qty }}</td>
                                <td style="width:17mm; ">{{ line_product.product_unit }}</td>
                                <td style="width:27mm; text-align: center; ">{{ line_product.product_price | currency }}</td>
                                <td style="width:27mm; text-align: center; ">{{ line_product.line_total | currency }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table border="0" width="700px" cellpadding="1" cellspacing="1">
                            <tr>
                                <td></td>
                                <td style="width:27mm; font-weight:bold;  text-align:right;">Итого:</td>
                                <td style="width:27mm; font-weight:bold;  text-align: center; ">{{ invoice.invoice_subtotal | currency }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:27mm; font-weight:bold;  text-align:right;">Итого НДС:</td>
                                <td style="width:27mm; font-weight:bold;  text-align: center; ">{{ invoice.invoice_tax | currency }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="width:37mm; font-weight:bold;  text-align:right;">Всего к оплате:</td>
                                <td style="width:27mm; font-weight:bold;  text-align: center; ">{{ invoice.invoice_total | currency }}</td>
                            </tr>
                        </table>
                        <br />
                        <div style="width: 700px">
                            <span>
                                    Всего наименований {{ lines.length }} на сумму {{ invoice.invoice_total | currency }} рублей.<br />
                            {{ total }}
                            </span>
                        </div>
                        <br /><br />
                        <div style="background-color:#000000; width:700px; font-size:1px; height:2px;">&nbsp;</div>
                        <br/>
                        <div style="font-size: 10pt; width: 700px">
                            <span>
                                1. Счет действителен в течении 5 (пяти) банковских дней, не считая дня выписки счета. В случае нарушения срока оплаты сохранение цены на товар и наличие товара на складе НЕ ГАРАНТИРУЕТСЯ.<br />
                                2. Оплата данного счета означает согласие с условиями изложенными в п.1
                            </span>
                        </div>
                        <br /><br />
                        <div style=" background-repeat: no-repeat; padding: 30px 10px; width: 400px; height: 250px;">
                        <div>Руководитель ______________________ </div>
                        <br/>  <br /><br />

                        <div>Главный бухгалтер ______________________</div>
                        <br/>

                        <div style="width: 85mm;text-align:center;">М.П.</div>
                        <br/>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-4">
                    <div class="uk-flex uk-flex-column">
                        <div v-if="invoice.paid_status == 1">
                            <span class="uk-text-success">Оплачен {{ moment(invoice.paid_date).locale('ru').format('LL') }}</span>
                        </div>
                        <div v-else>
                            <span class="uk-text-danger">
                                Не оплачен
                            </span>
                        </div>
                        <a href="">Редактировать</a>
                        <a href="" @click.prevent="print()">Печать</a>
                        <a href="" @click.prevent="createPDF">Скачать</a>
                        <a href="" >Отправить</a>
                        <div v-if="invoice.acceptance_certificate != null">
                            <router-link :key="invoice.company.id" :to="{ name: 'ShowAcceptanceCertificate', params: { userID:userID, companyID: companyID, acceptance_certificateID:invoice.acceptance_certificate.id  }}" >Акт № {{ invoice.acceptance_certificate.number }} от {{ moment(invoice.acceptance_certificate.date).locale('ru').format('LL') }}</router-link>
                        </div>
                        <div v-else>
                            <a href="" class="" @click.prevent="openCreateSertificateModal(invoice.id)">Добавить акт</a>
                        </div>
                        <a href="">Накладная</a>
                        <a href="">Счет-фактура</a>
                        <a href="">Удалить</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="createSertificate" uk-modal  class="uk-modal-container" >
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
              <button class="uk-modal-close-default" type="button" @click="closeCreateSertificateModal()" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h3 class="modal-title" id="addNewLabel">
                           Добавить акт
                        </h3>
                    </div>
                    <div class="uk-modal-body">
                        <form >
                            <div class="uk-flex uk-flex-middle">
                                <div class="uk-margin uk-flex uk-flex-middle">
                                    <label>Номер</label>
                                    <input type="text" class="uk-input uk-margin-small-left uk-margin-small-right" v-model="certificateNumber">
                                </div>
                                <div class="uk-margin uk-margin-remove-top uk-flex uk-flex-middle">
                                    <label>от</label>
                                    <date-picker 
                                        v-model="certificateDate" 
                                        name="date"
                                        input-class="uk-input uk-margin-small-left" 
                                        type="date"
                                        @change="setDate()"
                                        :format = dateFormat
                                    >
                                    </date-picker>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <label>Основание</label>
                                <input type="text" class="uk-input" v-model="certificateBasis">
                            </div>
                        </form>
                    </div>
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closeCreateSertificateModal()"
                          >
                              Закрыть
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="createAcceptanceCertificate()"
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
import Navigation from "../../Navigation.vue";
import html2pdf from 'html2pdf.js';
import moment from "moment";
import rubles from 'rubles';
import numberToString from '../../../rubles.js';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ru';
export default {
    props: ['invoiceID', 'userID', 'companyID'],
    data(){
        return {
            invoice: {},
            lines: {},
            total: '',
            certificateNumber: '',
            certificateDate: '',
            certificateBasis: '',
            dateFormat: moment().locale('ru').format('LL'), 
        }
    },
    methods: {
            loadInvoice(){
                console.log('/api/user/' + this.userID + '/company/' + this.companyID + '/invoice/' + this.invoiceID);
                
                axios
                    .get('/api/user/' + this.userID + '/company/' + this.companyID + '/invoice/' + this.invoiceID).then(data => (this.invoice = data.data))
                    .then( ( res ) => {
                        if(this.invoice != undefined) {
                            let total = this.invoice.invoice_total
                            let rubles = require('rubles').rubles
                            this.total = rubles(total)
                            this.total = this.total.charAt(0).toUpperCase() + this.total.slice(1)
                            this.setLines()
                        }
                    })
            },
            setLines() {
                let invoice_products = this.invoice.invoice_products
                let products = this.invoice.company.products
                let line = {}
                let lines = []
                for (let i = 0; i < invoice_products.length; i++) {
                    let product_id = invoice_products[i].product_id
                    
                    for (let x = 0; x < products.length; x++) {
                        if(products[x].id == product_id) {
                            let product_id = products[x].id
                            let product_no = invoice_products[i].product_no
                            let product_title = products[x].title
                            let product_qty = invoice_products[i].product_qty
                            let product_price = invoice_products[i].product_price
                            let product_unit = products[x].unit
                            let line_total = invoice_products[i].product_total
                            
                            line = {
                                'product_id': product_id,
                                'product_no': product_no,
                                'product_title': product_title,
                                'product_qty': product_qty,
                                'product_price': product_price,
                                'product_unit': product_unit,
                                'line_total': line_total,
                            }
                        }
                    }
                    lines.push(line)
                }
                this.lines = lines
            },
            print() {
                this.$htmlToPaper('document');
            },
            createPDF() {
                let element = document.getElementById('document');
                let invoiceNumber = this.invoice.number.invoice_number
                let invoiceDate = moment(this.invoice.date).locale('ru').format('l')
                let invoiceCompany = this.invoice.company.full_name.toUpperCase()
                let fileName = 'Счет № ' + invoiceNumber + ' от ' + invoiceDate + '  ' + invoiceCompany
                console.log(fileName);
                
                let opt = {
                    margin: 10,
                    filename: fileName,
                    image: {type: 'jpeg',quality: 0.98},
                    html2canvas: {scale: 2},
                    jsPDF: {
                        unit: 'mm',
                        orientation: 'portrait'
                        }
                };

                html2pdf().set(opt).from(element).save();
            },
            
            openCreateSertificateModal(id)  {
                let number, date, basis
                let certificates = this.invoice.company.acceptance_certificates
                
                if (certificates.length != undefined && certificates.length) {
                    for(let i = 0; i < certificates.length; i++){
                        number = certificates[i].number
                    }
                    number += 1
                } else {
                    number = 1
                }
                
                this.certificateNumber = number

                date = new Date()
                this.certificateDate = date

                basis = 'Счет № ' + this.invoice.number.invoice_number + ' от ' + moment(this.invoice.date).locale('ru').format('LL')
                this.certificateBasis = basis

                UIkit.modal("#createSertificate").show();
            },
            setDate(){
                this.dateFormat = moment(this.certificateDate).locale('ru').format('LL')
            },
            createAcceptanceCertificate(id) {
                const formData = new FormData()
                formData.append('invoice_id', this.invoiceID)
                formData.append('company_id', this.companyID)
                formData.append('user_id', this.userID)
                formData.append('number', this.certificateNumber)
                formData.append('date', this.certificateDate)
                formData.append('basis', this.certificateBasis)
                formData.append('customer_id', this.invoice.customer_id)
                formData.append('subtotal', this.invoice.invoice_subtotal)
                formData.append('tax', this.invoice.invoice_tax)
                formData.append('total', this.invoice.invoice_total)
                axios
                    .post('/api/user/' + this.userID + '/company/' + this.companyID + '/acceptance_certificate', formData)
                    .then((res) => {
                            if(res.status === 200) {
                                this.loadInvoice();
                                UIkit.modal("#createSertificate").hide();
                            }
                        })
                
            },
            closeCreateSertificateModal() {
                this.certificateNumber = ''
                this.certificateDate = '',
                this.certificateBasis = '',
                UIkit.modal("#createSertificate").hide();
            }
        },
    mounted() {
        this.loadInvoice();
    },
    components: {
        appNavigation: Navigation,
        DatePicker,
    },
}
</script>

<style>
.main
{
  width: 978px;
  margin: 0 auto;
  font-size: 17px;
}
.document{
    margin: 0;
    padding: 0;
    outline: 0;
    box-sizing: border-box;
    vertical-align: baseline;
    text-align: left;
    background: transparent;
    font-family: "Open Sans", sans-serif;
    font-size: 12px;
    line-height: 1.2;
    color: #000; 
}
</style>