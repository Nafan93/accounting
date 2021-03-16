<template>
    <div>
        <div id="createCertificate" uk-modal  class="uk-modal-container" >
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
    </div>
</template>

<script>
export default {
    props: ['company', 'user', 'invoice'], 
    data() {
        return {
            
        }
    },
    methods: {
        
        createAcceptanceCertificate(id) {
            UIkit.modal("#createCertificate").show();
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
    }
   
}
</script>

<style>

</style>