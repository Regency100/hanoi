new Vue(
    {
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
                        Vue.filter('formatDate', function (value) {
                            if (value) {
                                return moment(String(value)).format('DD/MM/YYYY')
                            }
                        });
                    })
                    .catch(error => {
                        alertify.error(error.message);
                    });
            },
            async createHeader() {
                try {
                    const url = 'http://localhost/hanoi/api/headers.php';
                    await axios.post(url);
                    alertify.success("Create Date Success");
                    this.fetchData();
                } catch (error) {
                    alertify.error('Duplicate Date');
                }
            },
        }
    }
);
