window._ = require('lodash');
window.Popper = require('popper.js').default;
window.jQuery = require('jquery');
window.$ = require('jquery');
window.moment = require('moment');
window.Swal = require('sweetalert2');
window.axios = require('./services/axios');
window.API = require('./services/api').default;
window.redirect = require('./services/redirect').default;
window.confirmDelete = require('./services/confirm').confirmDelete;
window.mountComponent = require('./components/index').mountComponent;

require('bootstrap');
