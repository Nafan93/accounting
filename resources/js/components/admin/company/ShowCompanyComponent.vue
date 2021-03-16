<template>
    <div class="uk-container">
        <div class="uk-width-1-1">
            <ul class="uk-breadcrumb">
                <li><router-link  :to="{ name: 'Dashboard' }" ><span uk-icon="home"></span></router-link></li>
                <li><span>{{ company.name }}</span></li>
            </ul>
            <h3 class="uk-card-title uk-margin-remove">{{ company.name }} </h3>
            <app-navigation v-bind:user="userID" v-bind:company="company.id"></app-navigation>
            <div uk-grid>
              
                <div class="uk-width-1-1">
                    <div class="uk-card">
                        <div class="uk-card-header uk-flex uk-flex-middle uk-flex-between">
                            <h3 class="uk-card-title uk-margin-remove">Company info</h3>
                        </div>
  
                        <div class="card-body table-responsive p-0">
                            <table class="uk-table">
                                <tbody>
                                    <tr>
                                        <td>Счета</td>
                                        <td>Сумма</td>
                                        <td>Оплачено</td>
                                        <td>Не оплачено</td>
                                    </tr>

                                    <tr>
                                        <td>{{ count_invoices }}</td>
                                        <td>{{ summ_invoices | currency }}</td>
                                        <td>{{ paid_summ_invoices | currency }}</td>
                                        <td>{{ not_paid_summ_invoices | currency  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="uk-card-footer"></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import Navigation from "../../Navigation.vue"
export default {
    props: ['companyID', 'userID'], 
    data(){
        return {
            company: {},
        }
    },
    methods: {
        loadCompany(){
            axios.get('/api/user/' + this.userID + '/company/' + this.companyID).then(data => (this.company = data.data));
        }
    },
    mounted() {
        this.loadCompany();
    },
    computed: {
        count_invoices() {
            if(this.company.invoices && this.company.invoices.length > 0){
                return this.company.invoices.length;
            } else {
                return 0;
            }
        },
        summ_invoices() {
            if(this.company.invoices && this.company.invoices.length > 0){
                let sum = 0;
                for (let i = 0; i < this.company.invoices.length; i++) { 
                  sum = sum + this.company.invoices[i].invoice_total;
                }
                return sum;
               
            } else {
                return 0;
            }
        },
        paid_summ_invoices(){
            if(this.company.invoices && this.company.invoices.length > 0){
                let sum = 0;
                
                for (let i = 0; i < this.company.invoices.length; i++) { 
                    if(this.company.invoices[i].paid == 1){
                        sum = sum + this.company.invoices[i].invoice_total;
                    }
                }
                return sum;
               
            } else {
                return 0;
            }
        },
        not_paid_summ_invoices(){
            if(this.company.invoices && this.company.invoices.length > 0){
                let sum = 0;
                
                for (let i = 0; i < this.company.invoices.length; i++) { 
                    if(this.company.invoices[i].paid != 1){
                        sum = sum + this.company.invoices[i].invoice_total;
                    }
                }
                return sum;
               
            } else {
                return 0;
            }
        },
    },
    components: {
        appNavigation: Navigation,
    }
}
</script>

<style>

</style>