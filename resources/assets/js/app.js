
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('add-record', require('./components/AddRecord.vue'));
Vue.component('records-table', require('./components/RecordsTable.vue'));
Vue.component('record-line', require('./components/RecordLine.vue'));
Vue.component('delete-record', require('./components/DeleteRecord.vue'));
Vue.component('delete-user', require('./components/DeleteUser.vue'));
Vue.component('delete-domain', require('./components/DeleteDomain.vue'));
Vue.component('remove-domain-password', require('./components/RemoveDomainPassword.vue'));
Vue.component('add-domain-password', require('./components/AddDomainPassword.vue'));
Vue.component('add-domain-password-modal', require('./components/AddDomainPasswordModal.vue'));

const app = new Vue({
    el: '#app'
});
