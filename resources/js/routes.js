import Dashboard from './components/admin/DashboardComponent.vue'
import ShowUserComponent from './components/admin/ShowUserComponent.vue'
import Company from './components/admin/company/CompanyComponent.vue'
import ShowCompany from './components/admin/company/ShowCompanyComponent.vue'
import Invoice from './components/admin/invoice/InvoiceComponent.vue'
import ShowInvoice from './components/admin/invoice/ShowInvoiceComponent.vue'
import Customer from './components/admin/customer/CustomerComponent.vue'
import ShowCustomer from './components/admin/customer/ShowCustomerComponent.vue'
import AcceptanceCertificate from './components/admin/acceptance_certificate/AcceptanceCertificateComponent.vue'
import ShowAcceptanceCertificate from './components/admin/acceptance_certificate/ShowAcceptanceCertificateComponent.vue'

export const routes = [{
        path: '/',
        component: Dashboard,
        name: 'Dashboard'
    },
    {
        path: '/user/:userID',
        component: ShowUserComponent,
        props: true
    },
    {
        path: '/user/:userID/company',
        component: Company
    },
    {
        path: '/user/:userID/company/:companyID',
        component: ShowCompany,
        name: 'showCompany',
        props: true
    },
    {
        path: '/user/:userID/company/:companyID/invoice',
        name: 'Invoice',
        component: Invoice,
        props: true,
    },
    {
        path: '/user/:userID/company/:companyID/invoice/:invoiceID',
        component: ShowInvoice,
        name: 'showInvoice',
        props: true
    },
    {
        path: '/user/:userID/company/:companyID/acceptance_certificates',
        name: 'AcceptanceCertificate',
        component: AcceptanceCertificate,
        props: true,
    },
    {
        path: '/user/:userID/company/:companyID/acceptance_certificate/:acceptance_certificateID',
        component: ShowAcceptanceCertificate,
        name: 'ShowAcceptanceCertificate',
        props: true
    },
    /* {
         path: '/company/:companyID/customers',
         name: 'Customer',
         component: Customer,
         props: true
     },
     {
         path: '/company/:companyID/customers/:customerId',
         component: ShowCustomer,
         name: 'showCustomer',
         props: true
     },*/


];