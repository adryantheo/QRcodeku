<template>
    <div id="app">
     <v-app id="inspire">
    <v-toolbar color="white" app>
    
      <img src="../../../../public/Logo.png" height="42" width="42" alt="" >
      <v-toolbar-title>QRku</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-layout row align-center style="max-width: 250px">
        <v-text-field
          placeholder="Search"
          single-line
          append-icon="search"
          :append-icon-cb="() => {}"
          color="white"
          hide-details
        ></v-text-field>
      </v-layout>
    </v-toolbar>
    
    <v-content>
      <v-container grid-list-lg class="my-3">
          <v-btn color="primary" dark class="mb-2" @click="openBrandDialog">Tambah Kupon</v-btn>
        <v-layout align-center justify-space-around row fill-height>

            <v-flex xs12 md6 xl4 v-for="(item, id) in brand" :key="`brand-${id}`">
                <v-card class="rounded" width="300px">
                    <v-img
                    height="130"
                    contain
                    ></v-img>
                    <v-card-text class="text-xs-center">{{item.amount}}</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                         <v-btn round color="error" dark @click="deleteItem(item)">Delete</v-btn>
                         <v-spacer></v-spacer>
                    </v-card-actions>

                </v-card>
            </v-flex>

        </v-layout>
         

        
        <!-- <qrcode value="Rp 25.000" :options="{width: 200}"></qrcode> -->
      </v-container>
    </v-content>

        
    <v-footer height="auto" color="indigo">          
              
        <v-flex
        indigo
        py-3
        text-xs-center
        white--text
        xs12
        >
        &copy;2019 — <strong>PPQ</strong>
        </v-flex>
          
    </v-footer>

</v-app>
    <v-dialog v-model="dialogCreateEditBrand"
    persistent max-width="600px"
    >
    <dialog-create-edit-brand
    :brandId = "parseInt(brandId)"
    @close="closeBrand"
    @create_success="reloadBrand"
    :key="dialogCreateEditBrandKey"
    >
    </dialog-create-edit-brand>

    </v-dialog>
</div>
</template>

<script>
import dialogCreateEditBrand from './dialogCreateEditBrand'

export default {

    components: {
        dialogCreateEditBrand,

    },

    data:() =>({
        brandId: 0,
        brand: [],
        dialogCreateEditBrand: false,
        dialogCreateEditBrandKey: 0,


    }),

    methods: {
        
        fetchBrand(){
            return axios.get('/api/products')
        },
        async getBrand(){
            try{
                const res = await this.fetchBrand();
                this.brand = res.data.reverse();
            } catch (err) {
                console.log(err);
            }            
        },
        openBrandDialog(){
            this.dialogCreateEditBrandKey = !!this.dialogCreateEditBrandKey? 0 : 1;
            this.dialogCreateEditBrand = true;
        },
        editBrand(id){
            this.standId = id;
            this.openBrandDialog();
        },
        async deleteBrand(id){
            const willDelete = confirm("R U Sure?");
            if(willDelete){
                try{
                    const res = await axios.delete(`/api/products/${id}`, null);
                    console.log(res.data);
                    this.getBrand();
                }catch(err){
                    console.log(err);
                }
            }

        },
        closeBrand(){
            this.dialogCreateEditBrand = false;
            this.brandId = 0;
        },
        reloadBrand(){
          this.closeBrand();
          this.getBrand();  
        },
        mounted(){
            this.getBrand();
        },


    },
  
  
}  
</script>