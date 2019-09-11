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
                <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>
            </v-flex>
        </v-layout>
      </v-container>
    </v-content>
</div>
</template>

<script>

export default {
    data:() =>({
        result : '',
        error: '',
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
         async onInit (promise){
            try{
                await promise
            }catch(error){
                if (error.name === 'NotAllowedError') {
                this.error = "ERROR: you need to grant camera access permisson"
                } else if (error.name === 'NotFoundError') {
                this.error = "ERROR: no camera on this device"
                } else if (error.name === 'NotSupportedError') {
                this.error = "ERROR: secure context required (HTTPS, localhost)"
                } else if (error.name === 'NotReadableError') {
                this.error = "ERROR: is the camera already in use?"
                } else if (error.name === 'OverconstrainedError') {
                this.error = "ERROR: installed cameras are not suitable"
                } else if (error.name === 'StreamApiNotSupportedError') {
                this.error = "ERROR: Stream API is not supported in this browser"
                }
            }
        },
    },

} 
</script>