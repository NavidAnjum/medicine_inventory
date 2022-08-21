<template>
    <!-- /.start of container-fluid is on dashboard not here -->


    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Supplier</h1>

    <div class="row">

        <div class="offset-lg-3 col-lg-6">

            <!-- Circle Buttons -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Supplier Details</h6>
                </div>

                <form @submit="add_supplier">

                <div class="card-body">
                    <p >Please add all information about supplier.</p>
                       <div class="mb-3">
                       <label for="company_name" class="form-label">Company Name</label>
                           <input type="text" class="form-control"  v-model="company_name" placeholder="Company Name" />
                       </div>
                    <div class="mb-3">

                    <label for="company_name" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control"  v-model="supplier_name" placeholder="Supplier Name" />
                     </div>
                    <div class="mb-3">

                    <label for="company_name" class="form-label">Supplier Email</label>
                    <input type="text" class="form-control"  v-model="supplier_email" placeholder="Supplier Email" />
                     </div>

                    <!-- Circle Buttons (Default) -->
                    <p>Message is: {{ company_name }}</p>

                        <div class="mb-3">
                            <button type="submit">Submit</button>
                   </div>

                </div>

                </form>
            </div>



        </div>



    </div>


    <!-- /.container-fluid is on dashboard not here -->


</template>

<script>
    const axios = require('axios').default;

    export default {
        data() {
            return {

                company_name: '',
                supplier_name: '',
                supplier_email: ''
            }
        },

        methods: {


            async add_supplier(e) {
                e.preventDefault();
                if(this.company_name==''){
                    this.$swal('Please Add Company Name!!!');

                }
                else if(this.supplier_name==''){
                    this.$swal('Please Add Supplier Name!!!');

                }
                else if(this.supplier_email==''){
                    this.$swal('Please Add Supplier Email!!!');

                }
                else{


                await axios({
                    method: 'post',
                    url: '/api/supplier',
                    data: {
                        company_name: this.company_name,
                        supplier_name: this.supplier_name,
                        supplier_email: this.supplier_email
                    }
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function (response) {
                        console.log(response.data)
                        alert(response.data)

                    })
                }
            }
        }
    }


</script>