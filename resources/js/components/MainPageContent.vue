<template>
    <div>
        <h1 class="text-center">Карта нашего факультета</h1>
        <v-container>
            <v-select
                :items="this.FLOORS"
                item-text="name"
                item-value="id"
                label="Выберите этаж*"
                @change="drawFloor"
                v-model="currentFloorId"
            ></v-select>
        </v-container>
        <v-container fluid>
            <div id="floor-area">
                <svg id="floor-container">

                </svg>
            </div>
        </v-container>
        <v-container v-if="showAuditoriumDetails">
            <v-row>
                <v-col col="12" elevation="20">
                    <v-card class="mx-auto">
                        <v-card-text>
                            <h1 class="display-1 text--primary text-center">Информация об аудитории</h1>
                            <v-row d-flex class="mt-3">
                                <v-col class="black--text font-weight-black">
                                    <span class="card-key">
                                        Название аудитории:
                                    </span>
                                </v-col>
                                <v-col>
                                    <span class="card-value">
                                        {{selectedAuditorium.auditorium_name}}
                                    </span>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col class="black--text font-weight-black">
                                    <span class="card-key">
                                        Ответственный:
                                    </span>
                                </v-col>
                                <v-col>
                                    <span class="card-value">
                                        {{selectedAuditorium.teacher_name}}
                                    </span>
                                </v-col>
                            </v-row>
                            <h3 class="display-1 text--primary text-center mt-3">Информация о занятости</h3>
                            <v-simple-table>
                                <template v-slot:default>
                                    <thead>
                                    <tr>
                                        <th class="text-left">
                                            Номер пары
                                        </th>
                                        <th class="text-left">
                                            Название
                                        </th>
                                        <th class="text-left">
                                            Начало
                                        </th>
                                        <th class="text-left">
                                            Конец
                                        </th>
                                        <th class="text-left">
                                            Группа
                                        </th>
                                        <th class="text-left">
                                            Курс
                                        </th>
                                        <th class="text-left">
                                            День недели
                                        </th>
                                        <th class="text-left">
                                            Повторение
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr
                                        v-for="(item, i) in selectedAuditorium.pairs"
                                        :key="i"
                                    >
                                        <td>{{ item.pairInfo.pair_number }}</td>
                                        <td>{{ item.pair_name }}</td>
                                        <td>{{ item.pairInfo.start_time }}</td>
                                        <td>{{ item.pairInfo.end_time }}</td>
                                        <td>{{ item.group_name }}</td>
                                        <td>{{ item.course_name }}</td>
                                        <td>{{ item.dayOfWeek.days_name }}</td>
                                        <td>{{ item.repeating.repeating_name }}</td>
                                    </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn text color="deep-purple accent-4" @click="showAuditoriumDetails = false">
                                Закрыть
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "MainPageContent",
    data() {
        return {
            currentFloorId: null,
            showAuditoriumDetails: false,
            selectedAuditorium: {
                auditorium_name: "",
                teacher_name: "",
                pairs: null
            }
        }
    },
    mounted() {
        this.$store.dispatch('loadAllFloors');
    },
    methods: {
        drawFloor() {
            let zoom = d3.zoom()
                .translateExtent([[-500, -300], [1500, 1000]])
                .scaleExtent([0.3, 2])
                .on('zoom', () => {
                    d3.select('#floor-container').attr('transform', d3.event.transform)
                });
            d3.select('#floor-container').call(zoom);
            this.clearFloorArea();
            this.$store.dispatch('loadFloorById', this.currentFloorId)
                .then((response) => {
                    this.drawBounds(JSON.parse(response.data.data.bounds));
                    this.drawFloorObjects(JSON.parse(JSON.stringify(response.data.data.auditoriums)), JSON.parse(JSON.stringify(response.data.data.secondaryObjects)));
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
        drawFloorObjects(auditoriums, secondaryObjects) {
            let data = [];
            for (let i = 0; i < auditoriums.length; i++) {
                data = JSON.parse(auditoriums[i].position_info);
                let gAppend = d3.select('#floor-container')
                    .append('g')
                    .attr('class', 'auditorium');
                gAppend
                    .append('rect')
                    .style("fill", "#cfd5c3")
                    .style("stroke", "black")
                    .style("stroke-width", "2")
                    .style("cursor", "pointer")
                    .attr("x", data.x)
                    .attr("y", data.y)
                    .attr("width", data.width)
                    .attr("height", data.height)
                    .on("click", () => {
                        this.showAuditoriumInfo(auditoriums[i].id);
                    });
                gAppend
                    .append('text')
                    .style("font-size", "14px")
                    .style("color", "black")
                    .style("position", "relative")
                    .style("text-anchor", "middle")
                    .attr("x", data.x + data.width / 2)
                    .attr("y", data.y + data.height / 2 + 5)
                    .text(auditoriums[i].auditorium_name);
            }
            for (let i = 0; i < secondaryObjects.length; i++) {
                data = JSON.parse(secondaryObjects[i].position_info);
                let secondaryObjectAppend = d3.select('#floor-container')
                    .append('g')
                    .attr('class', 'secondaryObject')
                    .attr("width", data.width)
                    .attr("height", data.height);
                secondaryObjectAppend
                    .append('rect')
                    .style("fill", "white")
                    .style("stroke", "black")
                    .style("stroke-width", "2")
                    .attr("x", data.x)
                    .attr("y", data.y)
                    .attr("width", data.width)
                    .attr("height", data.height);
                secondaryObjectAppend
                    .append('text')
                    .style("font-size", "14px")
                    .style("color", "black")
                    .style("position", "relative")
                    .style("text-anchor", "middle")
                    .attr("x", data.x + data.width / 2)
                    .attr("y", data.y + Math.min(20, data.height * 0.4))
                    .text(secondaryObjects[i].object_name);
                secondaryObjectAppend
                    .append('image')
                    .attr("x", data.x + data.width * 0.1)
                    .attr("y", data.y + data.height * 0.4)
                    .attr("width", data.width * 0.8)
                    .attr("height", data.height * 0.6)
                    .attr("href", secondaryObjects[i].object_type.type_path);
            }
        },
        clearFloorArea() {
            d3.selectAll('#floor-container > g').remove();
        },
        showAuditoriumInfo(id) {
            axios.get('/api/auditorium-info/' + id)
                .then((response) => {
                    this.selectedAuditorium = response.data.data;
                    console.log(this.selectedAuditorium);
                })
                .catch((error) => {
                    console.log(error.response.data);
                })
            this.showAuditoriumDetails = true;
        }
    },
    computed: {
        ...mapGetters(['FLOORS'])
    }
}
</script>

<style scoped>
    #floor-area {
        background: #f3f2f1;
        margin: 10px auto;
        border: 1px solid black;
        width: 851px;
        height: 606px;
        overflow: hidden;
    }
    #floor-container {
        background: #f3f2f1;
        height: 100%;
        width: 100%;
        touch-action: none;
        overflow: hidden;
    }
    .card-key {
        font-size: 20px;
    }
    .card-value {
        color: black;
        font-size: 20px;
        font-weight: bolder;
    }
</style>
