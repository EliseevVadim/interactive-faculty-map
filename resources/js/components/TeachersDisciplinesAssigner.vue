<template>
    <div>
        <h1 class="text-center mt-3">Управление списком дисциплин у преподавателей</h1>
        <v-btn
            class="mt-2 mb-3 mx-5"
            fab
            dark
            color="indigo"
            v-ripple
            @click="openAddingForm"
        >
            <v-icon dark>
                mdi-plus
            </v-icon>
        </v-btn>
        <v-dialog
            v-model="showAddingForm"
            persistent
            max-width="600px"
        >
            <v-card>
                <v-card-title>
                    <span class="text-h5">{{updating ? 'Переназначить дисциплину преподавателю' : 'Назначить дисциплину преподавателю'}}</span>
                </v-card-title>
                <v-card-text>
                    <h2 class="text-center red--text">{{errorText}}</h2>
                    <v-container>
                        <v-form
                            lazy-validation
                            ref="submitForm"
                            v-model="formValid">
                            <v-col cols="12">
                                <v-autocomplete
                                    label="Название дисциплины*"
                                    required
                                    :rules="commonRules"
                                    :items="DISCIPLINES"
                                    item-text="discipline_name"
                                    item-value="id"
                                    hide-details="auto"
                                    v-model="teacher_discipline.discipline_id"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete
                                    label="ФИО преподавателя*"
                                    required
                                    :rules="commonRules"
                                    :items="TEACHERS"
                                    item-text="fio"
                                    item-value="id"
                                    hide-details="auto"
                                    v-model="teacher_discipline.teacher_id"
                                ></v-autocomplete>
                            </v-col>
                        </v-form>
                    </v-container>
                    <small>Поля, помеченные * обязательны к заполнению</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="showAddingForm = false"
                    >
                        Закрыть
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="sendData"
                        :disabled="!formValid"
                    >
                        Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title>
                Список дисциплин у преподавателей
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
                :items="this.TEACHERS_DISCIPLINES"
                :search="search"
            >
                <template v-slot:body="{items}">
                    <tbody>
                    <tr v-for="(item,index) in items" :key="index">
                        <td>
                            {{item.id}}
                        </td>
                        <td>
                            {{item.discipline.discipline_name}}
                        </td>
                        <td>
                            {{item.teachers_fio}}
                        </td>
                        <td>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                color="yellow"
                                @click="startUpdatingTeacherDiscipline(item.id)"
                            >
                                <v-icon dark>
                                    mdi-pencil
                                </v-icon>
                            </v-btn>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                dark
                                color="red"
                                @click="deleteTeacherDiscipline(item.id)"
                            >
                                <v-icon dark>
                                    mdi-delete
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
    name: "TeachersDisciplinesAssigner",
    data () {
        return {
            showAddingForm: false,
            search: '',
            formValid: true,
            updating: false,
            errorText: "",
            teacher_discipline: {
                id: null,
                discipline_id: null,
                teacher_id: null
            },
            commonRules: [
                v => !!v || 'Поле является обязательным для заполнения'
            ],
            headers: [
                {
                    text: 'id',
                    align: 'start',
                    value: 'id',
                },
                { text: 'Название дисциплины', value: 'discipline_name' },
                { text: 'ФИО преподавателя', value: 'teachers_name' },
                { text: 'Действия', value: 'actions', sortable: false }
            ],
        }
    },
    mounted() {
        this.$store.dispatch('loadAllDisciplines');
        this.$store.dispatch('loadAllTeachers');
        this.$store.dispatch('loadAllTeachersDisciplines');
    },
    methods: {
        openAddingForm() {
            this.errorText = "";
            this.resetTeacherDiscipline();
            this.updating = false;
            this.showAddingForm = true;
        },
        sendData() {
            this.formValid = this.$refs.submitForm.validate();
            if(!this.formValid)
                return;
            this.errorText = "";
            if(!this.updating) {
                this.$store.dispatch('addTeacherDiscipline', this.teacher_discipline)
                    .then(() => {
                        this.resetTeacherDiscipline();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllTeachersDisciplines');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка добавления записи.";
                    });
            }
            else {
                this.$store.dispatch('updateTeacherDiscipline', this.teacher_discipline)
                    .then(() => {
                        this.resetTeacherDiscipline();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllTeachersDisciplines');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка обновления записи.";
                    });
            }
        },
        resetTeacherDiscipline() {
            this.teacher_discipline.discipline_id = null;
            this.teacher_discipline.id = null;
            this.teacher_discipline.teacher_id = null;
        },
        deleteTeacherDiscipline(id) {
            if (confirm("Вы действительно хотите удалить данную запись")) {
                this.$store.dispatch('deleteTeacherDiscipline', id)
                    .then(() => {
                        this.resetTeacherDiscipline();
                        this.$store.dispatch('loadAllTeachersDisciplines');
                    })
                    .catch(() => {
                        this.resetTeacherDiscipline();
                        alert("Невозможно удалить запись");
                    })
            }
        },
        startUpdatingTeacherDiscipline(id) {
            this.errorText = "";
            this.teacher_discipline.id = id;
            this.$store.dispatch('loadTeacherDisciplineById', id)
                .then((response) => {
                    this.teacher_discipline.id = response.data.data.id;
                    this.teacher_discipline.discipline_id = response.data.data.discipline.id;
                    this.teacher_discipline.teacher_id = response.data.data.teacher_id;
                    this.updating = true;
                    this.showAddingForm = true;
                })
        }
    },
    computed: {
        ...mapGetters(['DISCIPLINES']),
        ...mapGetters(['TEACHERS']),
        ...mapGetters(['TEACHERS_DISCIPLINES'])
    }
}
</script>

<style scoped>

</style>
