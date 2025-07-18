const axios = require('axios').default;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

export default axios;
