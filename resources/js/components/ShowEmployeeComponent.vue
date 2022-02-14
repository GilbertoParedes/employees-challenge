<template>
    <v-app>
        <v-container>
            <v-row justify="space-around">
      <v-card width="1200">
        <v-img
          height="200px"
          src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
        >
          <v-app-bar
            flat
            color="rgba(0, 0, 0, 0)"
          >
            <v-app-bar-nav-icon color="white"></v-app-bar-nav-icon>

           

            <v-spacer></v-spacer>

            <v-btn
              color="white"
              icon
            >
              <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
          </v-app-bar>

          <v-card-title class="white--text mt-8">
            <v-avatar size="56">
              <img
                alt="user"
                src="https://cdn.pixabay.com/photo/2020/06/24/19/12/cabbage-5337431_1280.jpg"
              >
            </v-avatar>
            <p class="ml-3">
              {{employee[0].name}}
            </p>
          </v-card-title>
        </v-img>

        <v-card-text>
          <div class="font-weight-bold ml-8 mb-2">
            Employee Information
          </div>

          <v-timeline
            align-top
            dense
          >
            <v-timeline-item
              color="deep-purple lighten-1"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>Email:</strong> @{{ employee[0].email }}
                </div>
                <!-- <div>{{ message.message }}</div> -->
              </div>
            </v-timeline-item>
            <v-timeline-item
              color="green"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>Job Position:</strong> {{ employee[0].job_position }}
                </div>
                <!-- <div>{{ message.message }}</div> -->
              </div>
            </v-timeline-item>
            <v-timeline-item
              color="blue"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>Birth Date:</strong> {{ fechaFormat(employee[0].birth_date) }}
                </div>
                <!-- <div>{{ message.message }}</div> -->
              </div>
            </v-timeline-item>
            <v-timeline-item
              color="red"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>Address:</strong> {{employee[0].address}}
                </div>
                <!-- <div>{{ message.message }}</div> -->
              </div>
            </v-timeline-item>
            <v-timeline-item
              color="yellow"
              small
            >
              <div>
                <div class="font-weight-normal">
                  <strong>Skills:</strong>
                  <v-simple-table v-if="employee[1].length">
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">
                          Skill
                        </th>
                        <th class="text-left">
                          Qualify
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="skill in employee[1]"
                        :key="skill"
                      >
                        <td>{{ skill.name }}</td>
                        <td>{{ skill.pivot.qualify }}</td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <v-alert v-else
                  border="right"
                  color="blue-grey"
                  dark
                >
                  The employe dont have skills asigned
                </v-alert>
                </div>
                <!-- <div>{{ message.message }}</div> -->
              </div>
            </v-timeline-item>
          </v-timeline>
        </v-card-text>
      </v-card>
    </v-row>
        </v-container>
    </v-app>
</template>
<script>
import moment from 'moment'

export default {
    props: [
        'employee_id'
    ],
    data: () => ({
      employee: [],
      messages: [
        {
          from: 'You',
          message: `Sure, I'll see you later.`,
          time: '10:42am',
          color: 'deep-purple lighten-1',
        },
        {
          from: 'John Doe',
          message: 'Yeah, sure. Does 1:00pm work?',
          time: '10:37am',
          color: 'green',
        },
        {
          from: 'You',
          message: 'Did you still want to grab lunch today?',
          time: '9:47am',
          color: 'deep-purple lighten-1',
        },
      ],
    }),
    mounted() {
        axios.get('/api/employees/'+this.employee_id )
          .then(response => {
            console.log('empleado: ',response.data)
            this.employee = response.data;
            resolve(response)
          })
          .catch(error => {
            //console.log(error)
            
          });
    },
    methods: {
        fechaFormat(date) {
          return moment(date).format("DD/MM/yyyy");
        },
    }
}
</script>
