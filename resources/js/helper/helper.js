

import axios from "axios";
import { ref } from "vue";


export default {
    data(){

        return {
             authorized:false,
             states:[],
             dataTo:ref({
                value: 0,
                label: 'None'
            }),

        }
    },
    method:{
        fetchAdmin(){
            return admin=[
                {
                    'id':1,
                    'name':'Admin',
                    'company':'Company 1',
                    'company_id':1,
                }
            ]
        },
        async api(method,apiUrl,dataObject ){
            try {
              return await axios({
                    method:method,
                    url: "/api/v1/"+apiUrl,
                    data: dataObject
                });
            } catch (e) {
                return e.response
            }
        },

    }
}
