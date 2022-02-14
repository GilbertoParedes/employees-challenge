<template>
<v-container>
<v-app>
    <div>
        <v-data-table
            :headers="headers"
            :items="employees"
            class="elevation-1"
        >
            <template v-slot:item="{ item }">
                
                <tr>
                    <td>{{ item.name }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.job_position }}</td>
                    <td>{{ fechaFormat(item.birth_date) }}</td>
                    <td>{{ item.address }}</td>
                    <td class="text-center">
                        <v-btn :href="route('employees.show', item.id)" type="button-employee" class="mx-1" fab small color="#4fa7ff">
                            <v-icon color="#ffffff">mdi-eye</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
            <template v-slot:top>
            <v-toolbar
                flat
            >
                <v-toolbar-title>Employees
                    <v-snackbar
                    v-if="employee_create"
                    :timeout="5000"
                    :value="true"
                    absolute
                    bottom
                    color="success"
                    outlined
                    right
                    >
                    <strong>Employee created</strong>
                    </v-snackbar>
                </v-toolbar-title>
                <v-divider
                class="mx-4"
                inset
                vertical
                ></v-divider>
                <v-spacer></v-spacer>
                <v-dialog
                v-model="dialog"
                max-width="800px"
                >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                    >
                    New Employee
                    </v-btn>
                </template>
                <v-card>
                    <v-card-title>
                    <span class="text-h5">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                    <v-form>
                        <v-container>
                            <v-row>
                            <v-col
                            cols="12"
                            sm="6"
                            md="6"
                            >
                                <v-text-field
                                    label="name"
                                    v-model="employee.name"
                                    outlined
                                ></v-text-field>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            md="6"
                            >
                                <v-text-field
                                    label="Email"
                                    v-model="employee.email"
                                    outlined
                                    placeholder="john@doe.com"
                                ></v-text-field>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            md="6"
                            >
                                <v-text-field
                                    label="Job Position"
                                    v-model="employee.job_position"
                                    outlined
                                    placeholder="john@doe.com"
                                ></v-text-field>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            md="6"
                            >
                            <v-menu
                            ref="menu1"
                            v-model="menu1"
                            :close-on-content-click="false"
                            transition="scale-transition"
                            offset-y
                            max-width="290px"
                            min-width="auto"
                            >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                v-model="employee.birth_date"
                                label="Birth Date"
                                outlined
                                prepend-icon="mdi-calendar"
                                v-bind="attrs"
                                @blur="date = parseDate(employee.birth_date)"
                                v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="date"
                                no-title
                                @input="menu1 = false"
                            ></v-date-picker>
                            </v-menu>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="12"
                            md="12"
                            >
                                <v-text-field
                                    label="Address"
                                    v-model="employee.address"
                                    outlined
                                    placeholder="john@doe.com"
                                ></v-text-field>
                            </v-col>
                            <v-col 
                                cols="12"
                                offset="8"
                            >
                            <v-chip
                                    class="ma-2"
                                    color="secondary"
                                    >
                                    Add Skills
                                    </v-chip>
                                <v-btn
                                class="mx-2 text-center"
                                fab
                                dark
                                color="indigo"
                                @click="otherSkill()"
                                >
                                    <v-icon dark>
                                        mdi-plus
                                    </v-icon>
                                </v-btn>
                            </v-col>
                            <v-row v-for="(skill, index) in count_skill" :key="index">
                            <v-col
                            cols="12"
                            sm="5"
                            md="5"
                            >
                            <v-input
                                error
                                disabled
                            >
                                Skill Name
                            </v-input>
                                <v-select
                                :items="skills"
                                label="Skill Name"
                                solo
                                hint="For example, flowers or used cars"
                                placeholder="Skill"
                                item-text="name"
                                item-value="id"
                                @input="selecteSkills($event, index)"
                                :id="'name_' + index" :value="'name_' + index" v-model="employe_skill['name_' + index]"
                                ></v-select>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="5"
                            md="5"
                            >
                                <v-input
                                    error
                                    disabled
                                >
                                    Qualify
                                </v-input>
                                <v-select
                                :items="qualify"
                                label="Skill Qualify"
                                placeholder="qualify"
                                solo
                                :id="'qualify_' + index" :value="'qualify_' + index" v-model="employe_skill['qualify_' + index]"
                                @input="selectedQualify($event, index)"
                                ></v-select>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="2"
                            md="2"
                            class="delete-button"
                            >
                            <v-btn
                            
                            class="mx-2"
                            fab
                            dark
                            mt="5"
                            color="red"
                            @click="deleteSkill()"
                            >
                                <v-icon dark>
                                    mdi-delete
                                </v-icon>
                            </v-btn>
                            </v-col>
                            
                            </v-row>
                            </v-row>
                            <v-row v-for="(error, key, i) in validationErrors" :key="i">
                        
                                <div v-for="(errors, keys, j) in error" :key="j">                                    
                                <v-snackbar
                                :timeout="3000"
                                :value="true"
                                absolute
                                top
                                right
                                tile
                                color="red accent-2"
                                >
                                <strong>{{errors}}</strong>
                                </v-snackbar>
                                </div>

                            </v-row>
                        </v-container>
                    </v-form>
                    </v-card-text>

                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="close"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="save"
                    >
                        Save
                    </v-btn>
                    </v-card-actions>
                </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                <v-card>
                    <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                    <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
                </v-dialog>
            </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editItem(item)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                @click="deleteItem(item)"
            >
                mdi-delete
            </v-icon>
            </template>
            <template v-slot:no-data>
            <v-btn
                color="primary"
                @click="initialize"
            >
                Reset
            </v-btn>
            </template>
        </v-data-table>
    </div>
</v-app>
</v-container>
</template>
<script>

import axios from 'axios'
import { Link } from '@inertiajs/inertia-vue' // vue 2
import Multiselect from 'vue-multiselect'
import moment from 'moment'

export default {
    components: [
        Link,
        Multiselect
    ],
    data() {
        return {
            qualify: [1, 2, 3, 4, 5],
            count_skill: 1,
            obj: {},
            employe_skill: [],
            employees: [],
            skills: [],
            dialog: false,
            dialogDelete: false,
            headers: [
                { text: 'Name', value: 'name' },
                { text: 'Mail', value: 'email' },
                { text: 'Job Position', value: 'job_position' },
                { text: 'Birth Date', value: 'birth_date' },
                { text: 'Address', value: 'address' },
                { text: 'view More', value: 'id' },
            ],
            editedIndex: -1,
            employee: {
                name: '',
                email: '',
                job_position: '',
                birth_date: '',
                address: '',
                skills: []
            },
            employee_create: false,
            errors: [],
            date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            //dateFormatted: vm.formatDate((new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)),
            menu1: false,
            menu2: false,
            editedItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
            defaultItem: {
                name: '',
                calories: 0,
                fat: 0,
                carbs: 0,
                protein: 0,
            },
        };
    },
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Employee' : 'Edit Employee'
      },
      computedDateFormatted () {
        return this.formatDate(this.date)
      },
      validationErrors(){
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
      },
      cleanEmployee() {
          this.employee.name = '';
          this.employee.email = '';
          this.employee.job_position = '';
          this.employee.birth_date = '';
          this.employee.address = '';
          this.employee.skills = [];
          this.count_skill = 1;
          this.employe_skill['name_0'] = ''
          this.employe_skill['qualify_0'] = ''
      }
    },
    methods: {
        fechaFormat(date) {
          return moment(date).format("DD/MM/yyyy");
        },
        otherSkill (){
            if (this.count_skill < 5) {
                this.count_skill = this.count_skill + 1;
            }
          
        },
        deleteSkill() {
            if (this.count_skill > 0) {
                this.count_skill = this.count_skill - 1
            }
        },
        selecteSkills(event, index) {
            console.log('Skill event :',event);
            let skill = event;
            this.employe_skill.push([
                skill
            ]);
            this.employee.skill = this.employe_skill;
        },
        selectedQualify(event, index) {
            let qualify = event;
            this.employe_skill[index].push(qualify); 
            this.employee.skill = this.employe_skill;
            console.log('evento e index', event, index);
        },
        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
            }
            this.options.push(tag)
            this.value.push(tag)
        },
        editItem (item) {
            this.editedIndex = this.employees.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem (item) {
            this.editedIndex = this.employees.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        deleteItemConfirm () {
            this.employees.splice(this.editedIndex, 1)
            this.closeDelete()
        },

        close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
          axios.post('/api/employees', this.employee)
            .then(response => {
              console.log(response.data);
              this.employee_create = true;
              this.cleanEmployee;
              this.close()
            })
            .catch(error => {
              console.log('error de validaciones',error.response.data.errors)
              this.errors.push(error.response.data.errors);
            })
      },
      formatDate (date) {
        if (!date) return null

        const [year, month, day] = date.split('-')
        return `${month}/${day}/${year}`
      },
      parseDate (date) {
        if (!date) return null

        const [month, day, year] = date.split('/')
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
      },

    },
    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
      date (val) {
        this.employee.birth_date = this.formatDate(this.date)
      },
    },
    mounted() {
        axios.get('api/employees')
          .then(response => {
            console.log('empleados: ',response.data)
            this.employees = response.data;
            resolve(response)
          })
          .catch(error => {
            //console.log(error)
            
          });

          axios.get('api/skills')
          .then(response => {
            this.skills = response.data;
            resolve(response)
          })
          .catch(error => {
            //console.log(error)
            
          });
    }
}
</script>
<style>
.delete-button button {
    margin-top: 40px !important;
}
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>