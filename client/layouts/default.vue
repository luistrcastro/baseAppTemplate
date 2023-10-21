<template>
    <Title>{{ routeTitle }} | {{ config.public.title }}</Title>
    <!-- <div v-if="!currentUserId">Loading</div> -->
    <v-app>
        <v-app-bar density="compact" color="primary" clipped-left fixed app>
            <template v-slot:prepend>
                <v-app-bar-nav-icon @click="drawer = !drawer" />
            </template>
            <v-app-bar-title>
                <nuxt-link
                    class="text-decoration-none text-black"
                    :to="{ name: 'home' }"
                >
                    {{ config.public.title }}
                </nuxt-link>
            </v-app-bar-title>
            <v-spacer />
            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>
            <v-btn icon @click.stop="toggleTheme">
                <v-icon>mdi-theme-light-dark</v-icon>
            </v-btn>
            <v-btn icon>
                <v-icon>mdi-dots-vertical</v-icon>
            </v-btn>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" location="left" temporary>
            <v-list>
                <!-- <v-list-item
          prepend-avatar="https://randomuser.me/api/portraits/men/78.jpg"
          title="John Leider"
        ></v-list-item> -->
                <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                    :to="item.to"
                    router
                    exact
                    :prepend-icon="item.icon"
                    :title="item.title"
                >
                </v-list-item>
                <v-list-item
                    @click.stop="logout"
                    prepend-icon="mdi-logout"
                    title="Logout"
                >
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-main>
            <v-container>
                <slot />
            </v-container>
        </v-main>
        <v-footer absolute app inset>
            <span>&copy; 2022 Luis Felipe Castro</span>
        </v-footer>
        <UiSnackbarNotifier />
    </v-app>
</template>

<script setup lang="ts">
import { useTheme } from "vuetify/lib/framework.mjs";
// import { useAuthStore } from "~~/store/auth";
import useCategoryStore from "~/stores/useCategoryStore";
import { useAccountStore } from "~/stores/accounts";

// APP THEME
const theme = useTheme();
function toggleTheme() {
    theme.global.name.value = theme.global.current.value.dark
        ? "light"
        : "dark";
}

onBeforeMount(() => {
    useCategoryStore().getData();
    useCategoryStore().getBaseCategories();
    useAccountStore().getData();
});

// const authStore = useAuthStore();
const currentUserId = computed(() => {
    // return authStore.user?.id;
});
onMounted(() => {
    // authStore.getAuthStoreDataForUser();
});
// const router = useRouter();
// const myRoute = useRoute();
// onBeforeMount(async () => {
//   let authenticated = null;
//   try {
//     const { data } = await useAppFetch("auth/test_auth").index();
//     // console.log(["RESPONSE", data.value]);

//     authenticated = data.value;
//   } catch (error) {
//     // console.log([error]);
//   } finally {
//     if (!authenticated)
//       router.push({ name: "login", query: { redirect: myRoute.fullPath } });
//   }
// });

const { user, logout } = useAuth();

const drawer = ref(false);
const items = [
    {
        icon: "mdi-apps",
        title: "Accounts",
        to: "/accounts",
    },
    {
        icon: "mdi-apps",
        title: "Categories",
        to: "/categories",
    },
    {
        icon: "mdi-apps",
        title: "Budgets",
        to: "/budgets",
    },
    {
        icon: "mdi-apps",
        title: "Transactions",
        to: "/transactions",
    },
    {
        icon: "mdi-apps",
        title: "Planned Payments",
        to: "/planned-payments",
    },
    {
        icon: "mdi-apps",
        title: "Settings",
        to: "/settings",
    },
    {
        icon: "mdi-chart-bubble",
        title: "About",
        to: "/about",
    },
];

// PAGE TAB NAME
const routeTitle = computed(() => useRoute().meta.title);
const config = useRuntimeConfig();
</script>
