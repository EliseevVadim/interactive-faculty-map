<template>
    <div>
        <h1 class="text-center mt-3">Управление списком ученых званий</h1>
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
                    <span class="text-h5">{{updating ? 'Обновить информацию об ученом звании' : 'Добавить ученое звание'}}</span>
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
                                    label="Название ученого звания*"
                                    required
                                    :rules="commonRules"
                                    hide-details="auto"
                                    v-model="rank.rank_name"
                                ></v-text-field>
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
                Список ученых званий
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
                :items="this.RANKS"
                :search="search"
            >
                <template v-slot:body="{items}">
                    <tbody>
                    <tr v-for="(item,index) in items" :key="index">
                        <td>
                            {{item.id}}
                        </td>
                        <td>
                            {{item.rank_name}}
                        </td>
                        <td>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                color="yellow"
                                @click="startUpdatingScienceRank(item.id)"
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
                                @click="deleteScienceRank(item.id)"
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
    name: "ScienceRanksPresenter",
    data () {
        return {
            showAddingForm: false,
            search: '',
            formValid: true,
            updating: false,
            errorText: "",
            rank: {
                id: null,
                rank_name: ""
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
                { text: 'Название ученого звания', value: 'rank_name' },
                { text: 'Действия', value: 'actions', sortable: false }
            ],
        }
    },
    mounted() {
        this.$store.dispatch('loadAllRanks');
    },
    methods: {
        openAddingForm() {
            this.errorText = "";
            this.resetRank();
            this.updating = false;
            this.showAddingForm = true;
        },
        sendData() {
            this.formValid = this.$refs.submitForm.validate();
            if(!this.formValid)
                return;
            this.errorText = "";
            if(!this.updating) {
                this.$store.dispatch('addScienceRank', this.rank)
                    .then(() => {
                        this.resetRank();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllRanks');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка добавления записи.";
                    });
            }
            else {
                this.$store.dispatch('updateScienceRank', this.rank)
                    .then(() => {
                        this.resetRank();
                        this.showAddingForm = false;
                        this.$store.dispatch('loadAllRanks');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка обновления записи.";
                    });
            }
        },
        resetRank() {
            this.rank.rank_name = "";
            this.rank.id = null;
        },
        deleteScienceRank(id) {
            if (confirm("Вы действительно хотите удалить данную запись")) {
                this.$store.dispatch('deleteScienceRank', id)
                    .then(() => {
                        this.resetRank();
                        this.$store.dispatch('loadAllRanks');
                    })
                    .catch(() => {
                        this.resetRank();
                        alert("Невозможно удалить запись");
                    })
            }
        },
        startUpdatingScienceRank(id) {
            this.errorText = "";
            this.rank.id = id;
            this.$store.dispatch('loadScienceRankId', id)
                .then((response) => {
                    this.rank.id = response.data.data.id;
                    this.rank.rank_name = response.data.data.rank_name;
                    this.updating = true;
                    this.showAddingForm = true;
                })
        }
    },
    computed: {
        ...mapGetters(['RANKS'])
    }
}
</script>

<style scoped>

</style>
