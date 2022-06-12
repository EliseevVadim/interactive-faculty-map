<template>
    <div>
        <h1 class="text-center mt-3">Управление списком аудиторий</h1>
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
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
        >
            <v-card>
                <v-btn
                    class="mx-2"
                    fab
                    dark
                    small
                    color="red"
                    @click="closeModal"
                >
                    <v-icon dark>
                        mdi-close
                    </v-icon>
                </v-btn>
                <v-card-title>
                    <span class="text-h5">{{updating ? 'Обновить информацию об аудитории' : 'Добавить аудиторию'}}</span>
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
                                    label="Название аудитории*"
                                    required
                                    :rules="commonRules"
                                    hide-details="auto"
                                    v-model="auditorium.auditorium_name"
                                ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-select
                                    :items="this.FLOORS"
                                    item-text="name"
                                    item-value="id"
                                    :rules="commonRules"
                                    label="Выберите этаж*"
                                    @change="drawFloorBoundsById()"
                                    v-model="auditorium.floor_id"
                                ></v-select>
                            </v-col>
                            <v-col
                                cols="12"
                            >
                                <v-select
                                    :items="this.TEACHERS"
                                    item-text="fio"
                                    item-value="id"
                                    :rules="commonRules"
                                    label="Выберите ответственное лицо"
                                    v-model="auditorium.holder_id"
                                ></v-select>
                            </v-col>
                            <h4 class="text-center">Данные о расположении:</h4>
                            <v-row justify="space-around">
                                <v-col cols="3" md="4" class="mt-3">
                                    <v-text-field
                                        label="X-координата*"
                                        required
                                        :rules="numberRules"
                                        hide-details="auto"
                                        v-model.number="auditorium.position_info.x"
                                        type="number"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Y-координата*"
                                        required
                                        :rules="numberRules"
                                        hide-details="auto"
                                        v-model.number="auditorium.position_info.y"
                                        type="number"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="3" md="4" class="mt-3">
                                    <v-text-field
                                        label="Относительная ширина*"
                                        required
                                        :rules="numberRules"
                                        hide-details="auto"
                                        v-model.number="auditorium.position_info.width"
                                        type="number"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Относительная высота*"
                                        required
                                        :rules="numberRules"
                                        hide-details="auto"
                                        v-model.number="auditorium.position_info.height"
                                        type="number"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-col cols="12" class="text-center">
                                <v-btn
                                    v-ripple
                                    color="success"
                                    dark
                                    right
                                    @click="previewAuditoriumRect"
                                >
                                    Предпросмотр
                                </v-btn>
                            </v-col>
                            <div id="floor-area">
                                <svg id="floor-container">

                                </svg>
                            </div>
                            <v-col cols="12" class="text-center">
                                <v-btn
                                    v-ripple
                                    @click="clearWholePreviewArea"
                                    color="red"
                                    dark
                                >
                                    Очистить
                                </v-btn>
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
                        @click="closeModal"
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
                Список аудиторий
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
                :items="this.AUDITORIUMS"
                :search="search"
            >
                <template v-slot:body="{items}">
                    <tbody>
                    <tr v-for="(item,index) in items" :key="index">
                        <td>
                            {{item.auditorium_name}}
                        </td>
                        <td>
                            {{item.position_info}}
                        </td>
                        <td>
                            {{item.floor}}
                        </td>
                        <td>
                            {{item.teacher}}
                        </td>
                        <td>
                            <v-btn
                                class="mx-2"
                                fab
                                small
                                color="yellow"
                                @click="startUpdatingAuditorium(item.id)"
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
                                @click="deleteAuditorium(item.id)"
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
    name: "AuditoriumsPresenter",
    data () {
        return {
            showAddingForm: false,
            search: '',
            formValid: true,
            updating: false,
            errorText: "",
            auditorium: {
                id: "",
                auditorium_name: "",
                position_info: {
                    x: "",
                    y: "",
                    width: "",
                    height: ""
                },
                floor_id: "",
                holder_id: ""
            },
            commonRules: [
                v => !!v || 'Поле является обязательным для заполнения'
            ],
            numberRules: [
                v => !!v || 'Поле является обязательным для заполнения',
                v => Number.isFinite(Number(v)) || "Значение должно быть числом"
            ],
            headers: [
                {
                    text: 'Название',
                    align: 'start',
                    value: 'auditorium_name',
                },
                { text: 'Информация о расположении', value: 'position_info' },
                { text: 'Этаж', value: 'floor' },
                { text: 'Ответственный', value: 'teacher' },
                { text: 'Действия', value: 'actions', sortable: false }
            ],
        }
    },
    mounted() {
        this.$store.dispatch('loadAllFloors');
        this.$store.dispatch('loadAllAuditoriums');
        this.$store.dispatch('loadAllTeachers');
    },
    methods: {
        openAddingForm() {
            this.errorText = "";
            this.resetAuditorium();
            this.updating = false;
            this.showAddingForm = true;
        },
        sendData() {
            this.formValid = this.$refs.submitForm.validate();
            if(!this.formValid)
                return;
            this.errorText = "";
            if(!this.updating) {
                this.$store.dispatch('addAuditorium', this.auditorium)
                    .then(() => {
                        this.resetAuditorium();
                        this.closeModal();
                        this.$store.dispatch('loadAllAuditoriums');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка добавления записи.";
                    });
            }
            else {
                this.$store.dispatch('updateAuditorium', this.auditorium)
                    .then(() => {
                        this.resetAuditorium();
                        this.closeModal();
                        this.$store.dispatch('loadAllAuditoriums');
                    })
                    .catch(() => {
                        this.errorText = "Произошла ошибка обновления записи.";
                    });
            }
        },
        resetAuditorium() {
            this.auditorium.auditorium_name = "";
            this.auditorium.floor_id = null;
            this.auditorium.holder_id = null;
            this.auditorium.position_info = {
                x: "",
                y: "",
                width: "",
                height: ""
            };
        },
        deleteAuditorium(id) {
            if (confirm("Вы действительно хотите удалить данную запись")) {
                this.$store.dispatch('deleteAuditorium', id)
                    .then(() => {
                        this.resetAuditorium();
                        this.$store.dispatch('loadAllAuditoriums');
                    })
                    .catch(() => {
                        this.resetAuditorium();
                        alert("Невозможно удалить запись");
                    })
            }
        },
        startUpdatingAuditorium(id) {
            this.errorText = "";
            this.auditorium.id = id;
            this.$store.dispatch('loadAuditoriumById', id)
                .then((response) => {
                    this.auditorium.auditorium_name = response.data.data.auditorium_name;
                    this.auditorium.holder_id = response.data.data.holder_id;
                    this.auditorium.floor_id = response.data.data.floor_id;
                    this.auditorium.position_info = JSON.parse(response.data.data.position_info);
                    this.updating = true;
                    this.showAddingForm = true;
                    this.drawFloorBoundsById();
                    this.drawFloorAuditoriums(JSON.parse(JSON.stringify(response.data.data.auditoriums)));
                })
        },
        drawFloorBoundsById() {
            this.clearWholePreviewArea();
            this.$store.dispatch('loadFloorById', this.auditorium.floor_id)
                .then((response) => {
                    this.drawBounds(JSON.parse(response.data.data.bounds));
                    this.drawFloorAuditoriums(JSON.parse(JSON.stringify(response.data.data.auditoriums)));
                })
        },
        drawBounds(data) {
            let svg = d3.select('#floor-container');
            svg.select('g.drawPoly').remove();
            let g = svg.append('g');
            g.append('polygon')
                .attr('points', data)
                .style('fill', 'none')
                .style("stroke", "black")
                .style("stroke-width", "2");
        },
        drawFloorAuditoriums(auditoriums) {
            if (this.updating) {
                let index = auditoriums.findIndex((item) => item.id === this.auditorium.id);
                auditoriums.splice(index, 1);
                this.previewAuditoriumRect();
            }
            let data = [];
            for (let i = 0; i < auditoriums.length; i++) {
                data = JSON.parse(auditoriums[i].position_info);
                d3.select('#floor-container')
                    .append('rect')
                    .style("fill", "white")
                    .style("stroke", "black")
                    .style("stroke-width", "2")
                    .attr("x", data.x)
                    .attr("y", data.y)
                    .attr("width", data.width)
                    .attr("height", data.height);
            }
        },
        previewAuditoriumRect() {
            try {
                this.removePreviewRect();
                let dragHandler = d3.drag();
                dragHandler
                    .on("drag", this.moveRect);
                d3.select('#floor-container')
                    .append("rect")
                    .style("fill", "white")
                    .style("stroke", "red")
                    .style("stroke-width", "2")
                    .attr("x", this.auditorium.position_info.x)
                    .attr("y", this.auditorium.position_info.y)
                    .attr("width", this.auditorium.position_info.width)
                    .attr("height", this.auditorium.position_info.height)
                    .attr("preview", true)
                    .call(dragHandler);
            }
            catch (e) {}
        },
        clearPreviewBounds() {
            d3.selectAll('#floor-container > g').remove();
        },
        removePreviewRect() {
            d3.selectAll('#floor-container > rect[preview=true]').remove();
        },
        clearWholePreviewArea() {
            this.clearPreviewBounds();
            this.removePreviewRect();
            d3.selectAll('rect').remove();
        },
        moveRect() {
            let x = d3.event.x;
            let y = d3.event.y;
            d3.select('#floor-container > rect[preview=true]')
                .attr("x", x)
                .attr("y", y);
            this.auditorium.position_info.x = x;
            this.auditorium.position_info.y = y;
        },
        closeModal() {
            this.clearWholePreviewArea();
            this.showAddingForm = false;
        }
    },
    computed: {
        ...mapGetters(['AUDITORIUMS']),
        ...mapGetters(['TEACHERS']),
        ...mapGetters(['FLOORS'])
    }
}
</script>

<style scoped>
    #floor-area {
        margin: 10px auto;
        border: 1px solid black;
        width: 851px;
        height: 606px;
        overflow: hidden;
    }
    #floor-container {
        height: 100%;
        width: 100%;
        touch-action: none;
        overflow: hidden;
    }
</style>
