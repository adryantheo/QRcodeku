<template>
    <div>
    <v-content>        
      <v-container grid-list-lg class="my-3">
          <v-layout align-center justify-space-around>
          </v-layout>
          <v-layout align-center justify-space-around row fill-height>
          <v-flex>
              <p class="headline">App Scaner</p>
          </v-flex>
          </v-layout>         
          
        <v-layout align-center justify-space-around row fill-height>
            <v-flex xs12 md6 xl4>
                <qrcode-stream @decode="onDecode"></qrcode-stream>
            </v-flex>
        </v-layout>
      </v-container>
    </v-content>
</div>
</template>

<script>
import { async } from 'q';

export default {
    data:() =>({
        result : '',
    }),

    methods: {

        async onDecode(qrcode){
            try{
            this.result = qrcode
            console.log(this.result);
            await axios.patch(`/api/credits/${this.result}/redeem`);
            alert("Successfully Redeeming Code");
            }catch(errorRedeem){
                console.log(errorRedeem);
                alert("Failed Redeeming Code");
            }
            
        },
    },
    async mounted(){        
    }

} 
</script>