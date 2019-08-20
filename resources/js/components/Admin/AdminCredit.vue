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
          <v-layout align-center justify-space-around>
              <v-btn color="primary" dark class="mb-2" @click="openCreditDialog">+ Tambah Credit</v-btn>
          </v-layout>
          <v-layout align-center justify-space-around row fill-height>
          <v-flex>
              <p class="headline">List Credit</p>
          </v-flex>
          </v-layout>         
          
        <v-layout align-center justify-space-around row fill-height>
        
            <v-flex xs12 md6 xl4 v-for="(item, id) in credit" :key="`credit-${id}`">
                <v-card class="rounded" height="100%">
                    <div>
                    <v-img
                    :src="item.image"
                    :aspect-ratio="16/9"
                    ></v-img>

                    </div>
                    <v-spacer></v-spacer>
                    
                    <v-card-text class="text-xs-center">{{item.amount}}</v-card-text>
                    <v-card-actions>
            
                        <v-spacer></v-spacer>
                         <v-btn round color="error" dark @click="deleteCredit(item.id)">Delete</v-btn>
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
        &copy;2019 — <strong><a href="https://github.com/adryantheo" style="color: white">Adryan Theo</a></strong>
        </v-flex>
          
    </v-footer>

</v-app>
    <v-dialog v-model="dialogCreateEditCredit"
    persistent max-width="600px"
    >
    <dialog-create-edit-credit
    :creditId = "parseInt(creditId)"
    @close="closeCredit"
    @create_success="reloadCredit"
    :key="dialogCreateEditCreditKey"
    >
    </dialog-create-edit-credit>

    </v-dialog>
</div>
</template>

<script>
import dialogCreateEditCredit from './dialogCreateEditCredit'

export default {
    props:{
        brand: {
            type: String,
            required: true,
        }

    },

    components: {
        dialogCreateEditCredit,

    },

    data:() =>({
        creditId: 0,
        credit: [],
        dialogCreateEditCredit: false,
        dialogCreateEditCreditKey: 0,


    }),

    methods: {
        
        fetchCredit(){
            return axios.get('/api/credits')
        },
        async getCredit(){
            try{
                const res = await this.fetchCredit();
                this.credit = res.data.reverse();
            } catch (err) {
                console.log(err);
            }            
        },
        openCreditDialog(){
            this.dialogCreateEditCreditKey = !!this.dialogCreateEditCreditKey? 0 : 1;
            this.dialogCreateEditCredit = true;
        },
        editCredit(id){
            this.creditId = id;
            this.openCreditDialog();
        },
        async deleteCredit(id){
            const willDelete = confirm("Apakah Anda Yakin Ingin Menghapus ini?");
            if(willDelete){
                try{
                    const res = await axios.delete(`/api/credits/${id}`, null);
                    console.log(res.data);
                    this.getCredit();
                }catch(err){
                    console.log(err);
                }
            }

        },
        closeCredit(){
            this.dialogCreateEditCredit = false;
            this.creditId = 0;
        },
        reloadCredit(){
          this.closeCredit();
          this.getCredit();  
        },
        


    },
    mounted(){
            this.getCredit();
        },
  
  
}  
</script>