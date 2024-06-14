import "./bootstrap";
import { createApp } from "vue";
import Cart from "./components/Cart.vue";

const app = createApp({
    components: {
        Cart,
    },
});
app.mount("#app");