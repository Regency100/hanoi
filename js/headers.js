// import moment from 'moment';

new Vue({
    el: '#app',
    data: {
        headers: []
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios.get('http://localhost/hanoi/api/headers.php')
                .then(response => {
                    this.headers = response.data.data;
                    Vue.filter('formatDate', function(value) {
                        if (value) {
                            return moment(String(value)).format('DD/MM/YYYY')
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                    alertify.error('Error notification');
                });
        }
    }
});