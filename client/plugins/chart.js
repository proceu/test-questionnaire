import Vue from "vue";
import { Doughnut } from "vue-chartjs/legacy";
import { Bar } from "vue-chartjs/legacy";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  LineElement,
  PointElement,
  ArcElement
} from "chart.js";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  PointElement,
  BarElement,
  CategoryScale,
  LinearScale,
  LineElement,
  ArcElement
);

Vue.component("chart", {
  extends: Doughnut,
});
Vue.component("bar-chart", {
  extends: Bar,
});
