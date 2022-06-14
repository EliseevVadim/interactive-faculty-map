<template>
    <div>
        <h1 class="text-center mt-3">Управление списком пар</h1>
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
                    <span class="text-h5">{{updating ? 'Обновить информацию о паре' : 'Добавить пару'}}</span>
                </v-card-title>
                <v-card-text>
                    <h2 class="text-center red--text">{{errorText}}</h2>
                    <v-container>
                        <v-form
                            lazy-validation
                            ref="submitForm"
                            v-model="formValid">
                            <v-col cols="12">
                                <v-text-field
                                    label="Название пары*"
                                    required
                                    :rules="commonRules"
                                    hide-details="auto"
                                    v-model="pair.pair_name"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    :items="this.PAIR_INFOS"
                                    item-text="pair_number"
                                    item-value="id"
                                    :rules="commonRules"
                                    label="Выберите номер пары*"
                                    v-model="pair.pair_info_id"
                                ></v-select>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete
                                    label="Аудитория*"
                                    required
                                    :rules="commonRules"
                                    :items="AUDITORIUMS"
                                    item-text="auditorium_name"
                                    item-value="id"
                                    hide-details="auto"
                                    v-model="pair.auditorium_id"
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
                                    v-model="pair.teacher_id"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete
                                    label="Дисциплина*"
                                    required
                                    :rules="commonRules"
                                    :items="DISCIPLINES"
                                    item-text="discipline_name"
                                    item-value="id"
                                    hide-details="auto"
                                    v-model="pair.discipline_id"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-autocomplete
                                    label="День недели*"
                                    required
                                    :rules="commonRules"
                                    :items="this.DAYS_OF_WEEK"
                                    item-text="days_name"
                                    item-value="id"
                                    hide-details="auto"
                                    v-model="pair.day_of_week_id"
                                ></v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-select
                                    :items="this.PAIR_REPEATINGS"
                                    item-text="repeating_name"
                                    item-value="id"
                                    :rules="commonRules"
                                    label="Выберите повторяемость пары*"
                                    v-model="pair.repeating_id"
                                ></v-select>
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
                Список пар
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
                :items="this.PAIRS"
                :search="search"
            >
                <template v-slot:body="{items}">
                    <tbody>
                    <tr v-for="(item,index) in items" :key="index">
                        <td>
                            {{item.pairInfo.pair_number}}
                        </td>
                        <td>
                            {{item.pair_name}}
                        </td>
                        <td>
                            {{item.pairInfo.start_time}}
                        </td>
                        <td>
                            {{item.pairInfo.end_time}}
                        </td>
                        <td>
                            {{item.auditorium.auditorium_name}}
                        </td>
                        <td>
                            {{item.teachers_fio}}
                        </td>
                        <td>
                            {{item.dayOfWeek.days_name}}
                        </td>
                        <td>
                            {{item.repeating.repeating_name}}
                        </td>
                        <td>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                color="yellow"
                                @click="startUpdatingPair(item.id)"
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
                                @click="deletePair(item.id)"
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
    name: "PairsPresenter",
    data () {
        return {
            showAddingForm: false,
            search: '',
            formValid: true,
            updating: false,
            errorText: "",
            pair: {
                id: null,
                pair_name: "",
                pair_info_id: null,
                teacher_id: null,
                auditorium_id: null,
                discipline_id: null,
                day_of_week_id: null,
                repeating_id: null
            },
            commonRules: [
                v => !!v || 'Поле является обязательным для заполнения'
            ],
            headers: [
                {
                    text: 'Номер пары',
                    align: 'start',
                    value: 'id',
                },
                { text: 'Название пары', value: 'pair_name' },
                { text: 'Начало пары', value: 'pair_start' },
                { text: 'Конец пары', value: 'pair_end' },
                { text: 'Аудитория', value: 'auditorium' },
                { text: 'Преподаватель', value: 'teacher' },
                { text: 'День недели', value: 'dayOfWeek' },
                { text: 'Повторение', value: 'repeating' },
                { text: 'Действия', value: 'actions', sortable: false }
            ],
        }
    },
    mounted() {
        this.$store.dispatch('loadAllPairs');
        this.$store.dispatch('loadAllPairInfos');
        this.$store.dispatch('loadAllTeachers');
        this.$store.dispatch('loadAllDaysOfWeek');
        this.$store.dispatch('loadAllPairRepeatings');
        this.$store.dispatch('loadAllDisciplines');
        this.$store.dispatch('loadAllAuditoriums');
    },
    methods: {
        openAddingForm() {
            this.errorText = "";
            this.resetPair();
            this.updating = false;
            this.showAddingForm = true;
        },
        sendData() {
            this.formValid = this.$refs.submitForm.validate();
            if(!this.formValid)
                return;
            this.errorText = "";
            if(!this.updating) {
                this.$store.dispatch('addPair', this.pair)
                    .then(() => {
                        this.resetPair();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllPairs');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка добавления записи.";
                    });
            }
            else {
                this.$store.dispatch('updatePair', this.pair)
                    .then(() => {
                        this.resetPair();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllPairs');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка обновления записи.";
                    });
            }
        },
        resetPair() {
                this.pair.id = null;
                this.pair.pair_name = "";
                this.pair.pair_info_id = null;
                this.pair.teacher_id = null;
                this.pair.auditorium_id = null;
                this.pair.discipline_id = null;
                this.pair.day_of_week_id = null;
                this.pair.repeating_id = null;
        },
        deletePair(id) {
            if (confirm("Вы действительно хотите удалить данную запись")) {
                this.$store.dispatch('deletePair', id)
                    .then(() => {
                        this.resetPair();
                        this.$store.dispatch('loadAllPairs');
                    })
                    .catch(() => {
                        this.resetPair();
                        alert("Невозможно удалить запись");
                    })
            }
        },
        startUpdatingPair(id) {
            this.errorText = "";
            this.pair.id = id;
            this.$store.dispatch('loadPairById', id)
                .then((response) => {
                    this.pair.id = response.data.data.id;
                    this.pair.pair_name = response.data.data.pair_name;
                    this.pair.pair_info_id = response.data.data.pairInfo.id;
                    this.pair.teacher_id = response.data.data.teacher_id;
                    this.pair.auditorium_id = response.data.data.auditorium.id;
                    this.pair.discipline_id = response.data.data.discipline.id;
                    this.pair.day_of_week_id = response.data.data.dayOfWeek.id;
                    this.pair.repeating_id = response.data.data.repeating.id;
                    console.log(response.data.data);
                    this.updating = true;
                    this.showAddingForm = true;
                })
        }
    },
    computed: {
        ...mapGetters(['DISCIPLINES']),
        ...mapGetters(['PAIR_INFOS']),
        ...mapGetters(['TEACHERS']),
        ...mapGetters(['AUDITORIUMS']),
        ...mapGetters(['PAIR_REPEATINGS']),
        ...mapGetters(['DAYS_OF_WEEK']),
        ...mapGetters(['PAIRS'])
    }
}
</script>

<style scoped>

</style>
