<template>
    <div class="uk-container">
        <app-navigation v-bind:user="userID" v-bind:company="companyID"></app-navigation>
        <ul class="uk-breadcrumb">
                <li><a href="#">Home</a></li>
                <li v-if="certificate.company != undefined">
                    <router-link :key="companyID" :to="{ name: 'showCompany', params: { companyID: companyID }}" >{{ certificate.company.name }}</router-link>
                </li>
                <li>
                    <router-link :key="companyID" :to="{ name: 'AcceptanceCertificate', params: { companyID: companyID }}" >Акты</router-link>
                </li>
                <li v-if="certificate.number != undefined">
                    <span>Акт № {{ certificate.number }} от {{ moment(certificate.date).locale('ru').format('LL') }}</span>
                </li>
            </ul> 
        <div uk-grid>
            <div class="uk-width-3-4">
                <div class="document" id="document">
                    <table cellspacing="0" style="width: 700px;font-size: 16px;">
                        <tr>
                            <td colspan="6" style="border-bottom: 3px solid #000;font-size: 25px;font-weight: bold;">Акт № {{ certificate.number }} от {{ moment(certificate.date).locale('ru').format('LL') }}</td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td>Исполнитель:</td>
                            <td colspan="5" style="font-weight: bold;"  v-if="certificate.invoice != undefined">{{ certificate.invoice.company.full_name }}, ИНН/КПП: {{ certificate.invoice.company.inn }}/{{ certificate.invoice.company.kpp }}, {{ certificate.invoice.company.legal_addres }} </td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td>Заказчик:</td>
                            <td colspan="5" style="font-weight: bold;" v-if="certificate.invoice != undefined">{{ certificate.invoice.customer.full_name }} ИНН/КПП: {{ certificate.invoice.customer.inn }}/{{ certificate.invoice.customer.kpp }}, {{ certificate.invoice.customer.legal_addres }}</td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr style="font-weight: bold;text-align: center;">
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-left: 2px solid #000;border-bottom: 1px solid #000;">№</td>
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-bottom: 1px solid #000;">Наименование работ, услуг</td>
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-bottom: 1px solid #000;">Кол-во</td>
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-bottom: 1px solid #000;">Ед.</td>
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-bottom: 1px solid #000;">Цена</td>
                            <td style="border: 1px solid #000;border-top: 2px solid #000;border-right: 2px solid #000;border-bottom: 1px solid #000;">Сумма</td>
                        </tr>
                        <tr v-for="line_product in lines" :key="line_product.id">
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-left: 2px solid #000;border-bottom: 0px solid #000;text-align: center;">{{ line_product.product_no }}</td>
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-bottom: 0px solid #000;">{{ line_product.product_title }}</td>
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-bottom: 0px solid #000;text-align: right;">{{ line_product.product_qty }}</td>
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-bottom: 0px solid #000;text-align: right;">{{ line_product.product_unit }}</td>
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-bottom: 0px solid #000;text-align: right;">{{ line_product.product_price | currency }}</td>
                            <td style="border: 1px solid #000;border-top: 1px solid #000;border-right: 2px solid #000;border-bottom: 0px solid #000;text-align: right;">{{ line_product.line_total | currency }}</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border-top: 3px solid #000;"></td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="5" style="font-weight: bold;text-align: right;">Итого:</td>
                            <td style="font-weight: bold;text-align: right;">{{ certificate.total | currency }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" style="font-weight: bold;text-align: right;">В том числе НДС:</td>
                            <td style="font-weight: bold;text-align: right;">{{ certificate.tax | currency }}</td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="6">Всего оказано услуг {{ lines.length }}, на сумму {{ certificate.total | currency }} рублей</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="font-weight: bold;">{{ total }}</td>
                        </tr>
                        <tr height="15px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="6">Вышеперечисленные услуги выполнены полностью и в срок. Заказчик претензий по объему, качеству и срокам оказания услуг не имеет.</td>
                        </tr>
                        <tr height="50px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight: bold;">ИСПОЛНИТЕЛЬ</td>
                            <td></td>
                            <td colspan="4" style="font-weight: bold;">ЗАКАЗЧИК</td>
                        </tr>
                        <tr>
                            <td colspan="2" v-if="certificate.invoice != undefined">_______/{{ certificate.invoice.company.director_name }}</td>
                            <td></td>
                            <td colspan="4" v-if="certificate.invoice != undefined">_______/{{ certificate.invoice.customer.director_name }}</td>
                        </tr>
                        <tr height="100px;">
                            <td colspan="6"></td>
                        </tr>
                        <tr>
                            
                        </tr>
                    </table>
                </div>
            </div>
            <div class="uk-width-1-4">
                <div class="uk-flex uk-flex-column">
                    <a href="">Отправить</a>
                    <a href="" @click.prevent="print()">Печать</a>
                    <a href="" @click.prevent="createPDF">Скачать</a>
                    <a href="">Передан</a>
                    <a href="">Подписан</a>
                    <a href="">Удалить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import Navigation from "../../Navigation.vue";
export default {
    props: ['acceptance_certificateID', 'userID', 'companyID'],
    data(){
        return {
            certificate: {},
            lines: {},
            total: ''
        }
    },
    methods: {
            loadAcceptanceCertificate(){
                console.log('/api/user/' + this.userID + '/company/' + this.companyID + '/acceptance_certificate/' + this.acceptance_certificateID);
                
                axios
                    .get('/api/user/' + this.userID + '/company/' + this.companyID + '/acceptance_certificate/' + this.acceptance_certificateID).then(data => (this.certificate = data.data))
                    .then( ( res ) => {
                        if(this.certificate != undefined) {
                            let total = this.certificate.total
                            let rubles = require('rubles').rubles
                            this.total = rubles(total)
                            this.total = this.total.charAt(0).toUpperCase() + this.total.slice(1)
                            this.setLines()
                        }
                    })
            },
            setLines() {
                let invoice_products = this.certificate.invoice.invoice_products
                let products = this.certificate.company.products
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
                let certificateNumber = this.certificate.number
                let certificateDate = moment(this.certificate.date).locale('ru').format('l')
                let certificateCompany = this.certificate.company.full_name.toUpperCase()
                let fileName = 'Акт № ' + certificateNumber + ' от ' + certificateDate + '  ' + certificateCompany
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

                //html2pdf().set(opt).from(element).save();
            },
        },
        mounted() {
            this.loadAcceptanceCertificate();
        },
        components: {
            appNavigation: Navigation,
        },
}
</script>

<style>
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