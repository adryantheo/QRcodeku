<template>
    <div>

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
                  

        
        <!-- <qrcode value="Rp 25.000" :options="{width: 200}"></qrcode> -->
      </v-container>
    </v-content>

        
  


    <v-dialog v-model="dialogCreateEditCredit"
    persistent max-width="600px"
    >
    <dialog-create-edit-credit
    :creditId = "parseInt(creditId)"
    :brand = "parseInt(brand)"
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
    components: {
        dialogCreateEditCredit,

    },
    props:{
        brand: {
            type: String,
            required: true,
        }

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