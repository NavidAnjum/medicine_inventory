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

                    <label for="supplier_name" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control"  v-model="supplier_name" placeholder="Supplier Name" />
                     </div>
                    <div class="mb-3">

                    <label for="supplier_email" class="form-label">Supplier Email</label>
                    <input type="text" class="form-control"  v-model="supplier_email" placeholder="Supplier Email" />
                     </div>
                    <div class="mb-3">

                    <label for="supplier_phone_number" class="form-label">Supplier Phone</label>
                    <input type="text" class="form-control"  v-model="supplier_phone_number" placeholder="Supplier Phone" />
                    </div>

                    <div class="mb-3">

                        <label for="supplier_address" class="form-label">Supplier Address</label>
                        <input type="text" class="form-control"  v-model="supplier_address" placeholder="Supplier Address" />
                    </div>

                    <!-- Circle Buttons (Default) -->

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
                supplier_email: '',
                supplier_phone_number:'',
                supplier_address:''

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
                        supplier_email: this.supplier_email,
                        supplier_phone_number:this.supplier_phone_number,
                        supplier_address:this.supplier_address
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