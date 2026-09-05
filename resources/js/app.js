import "./bootstrap";

import Alpine from "alpinejs";
import assistant from "./assistant";

window.Alpine = Alpine;
Alpine.data("assistant", assistant);

Alpine.start();
