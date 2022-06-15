<template>
    <v-app>
        <v-app-bar
            color="deep-purple accent-4"
            elevation="24"
            dense
            dark
            class="flex-grow-0"
        >
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-spacer></v-spacer>
            <v-menu
                bottom
                left
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-btn
                        tile
                        v-bind="attrs"
                        v-on="on"
                    >
                        <v-icon left>
                            mdi-account-circle
                        </v-icon>
                        Добро пожаловать, {{userName}}
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item-group
                        active-class="deep-purple--text text--accent-4"
                    >
                        <v-list-item @click="logout">
                            <v-list-item-icon>
                                <v-icon>mdi-logout</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Выход</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-navigation-drawer
            v-model="drawer"
            absolute
            bottom
            temporary
        >
            <v-list
                flat
                nav
                dense
            >
                <v-subheader>Управление приложением</v-subheader>
                <v-divider></v-divider>
                <v-list-item-group
                    v-model="selectedItem"
                    active-class="deep-purple--text text--accent-4"
                >
                    <v-list-item @click="hideSidebar"
                        v-for="(item, i) in items"
                        :key="i"
                        >
                        <v-list-item-icon>
                            <v-icon v-text="item.icon"></v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-divider></v-divider>
                <v-list-group
                    :value="false"
                    prepend-icon="mdi-tools"
                >
                    <template v-slot:activator>
                        <v-list-item-title>Служебные</v-list-item-title>
                    </template>
                        <v-list-item
                            v-for="([title, icon, index], i) in services"
                            :key="i"
                            link
                            @click="selectItem(index)"
                        >
                            <v-list-item-title v-text="title"></v-list-item-title>
                            <v-list-item-icon>
                                <v-icon v-text="icon"></v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            <floors-presenter v-if="selectedItem === 0"></floors-presenter>
            <teachers-presenter v-if="selectedItem === 1"></teachers-presenter>
            <auditoriums-presenter v-if="selectedItem === 2"></auditoriums-presenter>
            <secondary-objects-presenter v-if="selectedItem === 3"></secondary-objects-presenter>
            <pairs-presenter v-if="selectedItem === 4"></pairs-presenter>
            <disciplines-presenter v-if="selectedItem === 5"></disciplines-presenter>
            <science-ranks-presenter v-if="selectedItem === 6"></science-ranks-presenter>
            <pair-infos-presenter v-if="selectedItem === 7"></pair-infos-presenter>
            <secondary-object-types-presenter v-if="selectedItem === 8"></secondary-object-types-presenter>
            <teachers-disciplines-assigner v-if="selectedItem === 9"></teachers-disciplines-assigner>
        </v-main>
    </v-app>
</template>

<script>
import {mapGetters} from "vuex";
export default {
    name: "AdminPage",
    data() {
        return {
            drawer: false,
            selectedItem : 0,
            items : [
                {text : "Этажи", icon : "mdi-floor-plan"},
                {text : "Преподаватели", icon : "mdi-account-school"},
                {text : "Аудитории", icon : "mdi-cellphone-link"},
                {text : "Вторичные объекты", icon : "mdi-stairs"},
                {text : "Пары", icon : "mdi-calendar-check"},
                {text : "Дисциплины", icon : "mdi-playlist-check"}
            ],
            services: [
                ['Ученые звания', 'mdi-trophy-award', 6],
                ['Информация о парах', 'mdi-information-variant', 7],
                ['Типы вторичных объектов', 'mdi-map-legend', 8],
                ['Назначение дисциплин', 'mdi-clipboard-check', 9]
            ]
        }
    },
    computed: {
        userName() {
           return localStorage.getItem('username');
        },
        ...mapGetters(['USER'])
    },
    methods: {
        clickToggleDrawer() {
            this.drawer = !this.drawer
        },
        logout() {
            this.$store.dispatch('logout');
        },
        hideSidebar() {
            this.drawer = false;
        },
        selectItem(index) {
            this.selectedItem = index;
            this.hideSidebar();
        }
    },
};
</script>
