<template>
  <div class="uk-container">
    <div class="uk-width-1-1">
      <ul class="uk-breadcrumb">
          <li><a href="#">Home</a></li>
          <li><router-link :key="company.id" :to="{ name: 'showCompany', params: { companyID: company.id }}" >{{ company.name }}</router-link></li>
          <li><a>Акты</a></li>
      </ul> 

      <div>
        <div class="uk-card">
          
          <div class="uk-card-header uk-flex uk-flex-middle uk-flex-between">
              <h3 class="uk-card-title uk-margin-remove">Акты {{ company.name }} </h3>

          </div>

          <div class="card-body table-responsive p-0" v-if="company.acceptance_certificates != undefined">
              <table class="uk-table" >
                  <tbody>
                      <tr>
                          <th>№</th>
                          <th>Дата</th>
                          <th>Клиент</th>
                          <th>Сумма</th>
                          <th>Счет №</th>
                          
                      </tr>
                      <tr v-for="certificate in company.acceptance_certificates" :key="certificate.id">
                          <td v-if="certificate.number != null">
                              <router-link :key="company.id" :to="{ name: 'ShowAcceptanceCertificate', params: { companyID: company.id, acceptance_certificateID:certificate.id  }}" >{{ certificate.number }}</router-link>
                          </td>
                          <td v-else>Ошибка!</td>
                          <td>{{ moment(certificate.date).locale('ru').format('LL') }}</td>
                          
                          <td v-if="certificate.customer != 0">
                              {{ certificate.customer.name }}
                          </td>
                          <td v-else>
                              Ошибка
                          </td>
                          <td>{{ certificate.total }}</td>
                          <td v-if="certificate.invoice != undefined">
                            <router-link :key="company.id" :to="{ name: 'showInvoice', params: { companyID: company.id, invoiceID:certificate.invoice_id  }}" >{{  certificate.invoice.number.invoice_number }}</router-link>
                          </td>
                          <td v-else><span class="uk-text-danger">Удален</span></td>
                          <td>
                              <a href="#" data-id="certificate.id">
                                  <span uk-icon="pencil"></span>
                              </a>
                              <span>|</span>
                              <a href="#" @click="deleteCertificate(certificate.id)">
                                  <span class="uk-text-danger" uk-icon="close"></span>
                              </a>
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="card-body table-responsive p-0" v-else>Нет актов</div>
          <div class="uk-card-footer"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
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
        },
        deleteCertificate(id) {
          axios
          .delete('/api/acceptance_certificate/' + id)
          .then(res => {
            if(res.status === 200) {
              this.loadCompany();
            }
          })
        }
        },
        mounted() {
            this.loadCompany();
        }
}
</script>

<style>

</style>