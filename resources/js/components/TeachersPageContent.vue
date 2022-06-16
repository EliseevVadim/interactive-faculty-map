<template>
    <div>
        <h1 class="text-center mt-3">Cписок преподавателей</h1>
        <v-dialog
            v-model="showDetailsForm"
            persistent
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="text-h5">Подробная информация о преподавателе</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row d-flex class="mt-3">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                        Фото:
                                    </span>
                            </v-col>
                            <v-col>
                                <img :src="teacher.photo_path === null ? 'img/blank-item.jpg' : '../storage/' + teacher.photo_path" alt="#"/>
                            </v-col>
                        </v-row>
                        <v-row d-flex class="mt-3">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                    ФИО:
                                </span>
                            </v-col>
                            <v-col>
                                <span class="card-value">
                                    {{teacher.fio}}
                                </span>
                            </v-col>
                        </v-row>
                        <v-row d-flex class="mt-3">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                    Ученое звание:
                                </span>
                            </v-col>
                            <v-col>
                                <span class="card-value">
                                    {{teacher.scienceRank}}
                                </span>
                            </v-col>
                        </v-row>
                        <v-row d-flex class="mt-3">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                    Дата рождения:
                                </span>
                            </v-col>
                            <v-col>
                                <span class="card-value">
                                    {{teacher.birth_date.slice(0, 10)}}
                                </span>
                            </v-col>
                        </v-row>
                        <v-row d-flex class="mt-3">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                    Email:
                                </span>
                            </v-col>
                            <v-col>
                                <span class="card-value">
                                    {{teacher.email}}
                                </span>
                            </v-col>
                        </v-row>
                        <v-row d-flex class="mt-3" v-if="teacher.teachersDisciplines.length > 0">
                            <v-col class="black--text font-weight-black">
                                <span class="card-key">
                                    Преподаваемые дисциплины:
                                </span>
                            </v-col>
                            <v-col>
                                <ul>
                                    <li v-for="(item, i) in teacher.teachersDisciplines" :key="i">
                                        <span class="card-value">
                                            {{item.discipline.discipline_name}}
                                        </span>
                                    </li>
                                </ul>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="showDetailsForm = false"
                    >
                        Закрыть
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title>
                Список преподавателей
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Поиск"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="this.TEACHERS"
                :search="search"
            >
                <template v-slot:body="{items}">
                    <tbody>
                    <tr v-for="(item,index) in items" :key="index">
                        <td class="text-center">
                            <img width="100" height="100" :src="item.photo_path === null ? 'img/blank-item.jpg' : '../storage/' + item.photo_path" alt="#"/>
                        </td>
                        <td>
                            {{item.fio}}
                        </td>
                        <td>
                            {{item.scienceRank}}
                        </td>
                        <td>
                            {{item.birth_date.slice(0, 10)}}
                        </td>
                        <td>
                            {{item.email}}
                        </td>
                        <td>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                color="primary"
                                @click="showDetailsAboutTeacher(item.id)"
                            >
                                <v-icon dark>
                                    mdi-details
                                </v-icon>
                            </v-btn>
                        </td>
                    </tr>
                    </tbody>
                </template>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "TeachersPageContent",
    data () {
        return {
            showDetailsForm: false,
            search: '',
            teacher: {
                fio: "",
                birth_date: new Date().toISOString().slice(0, 10),
                email: "",
                science_rank_id: null,
                photo: null,
                teachersDisciplines: []
            },
            photoRules: [
                value => !value || value.size < 2000000 || 'Avatar size should be less than 2 MB!'
            ],
            emailRules: [
                v => !!v || 'Поле является обязательным для заполнения',
                v => /.+@.+/.test(v) || 'Введенный email некорректен'
            ],
            commonRules: [
                v => !!v || 'Поле является обязательным для заполнения'
            ],
            headers: [
                {
                    text: 'Фото',
                    align: 'start',
                    sortable: false,
                    value: 'photo_path',
                },
                { text: 'ФИО', value: 'fio' },
                { text: 'Ученая степень', value: 'scienceRank' },
                { text: 'Дата рождения', value: 'birth_date' },
                { text: 'Email', value: 'email' },
                { text: 'Действия', value: 'actions', sortable: false }
            ],
        }
    },
    mounted() {
        this.$store.dispatch('loadAllTeachers');
    },
    methods: {
        openAddingForm() {
            this.errorText = "";
            this.resetTeacher();
            this.updating = false;
            this.showAddingForm = true;
        },
        resetTeacher() {
            this.teacher.birth_date = new Date().toISOString().slice(0, 10);
            this.teacher.email = "";
            this.teacher.fio = "";
            this.teacher.science_rank_id = null;
            this.teacher.photo = null;
        },
        showDetailsAboutTeacher(id) {
            this.$store.dispatch('loadTeacherById', id)
                .then((response) => {
                    this.teacher = response.data.data;
                    console.log(this.teacher);
                })
            this.showDetailsForm = true;
        }
    },
    computed: {
        ...mapGetters(['TEACHERS'])
    }
}
</script>

<style scoped>
    .card-value {
        color: black;
        font-size: 20px;
        font-weight: bolder;
    }
    li > .card-value {
        font-size: 18px;
        font-weight: normal;
    }
</style>
